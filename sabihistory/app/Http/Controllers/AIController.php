<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use App\Models\Material;
use App\Models\AiSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

class AIController extends Controller
{
    protected $ai;

    public function __construct(AIService $ai)
    {
        $this->ai = $ai;
        $this->middleware('auth')->except(['research']);
    }

    // Research assistant - chat interface
    public function research(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:2000'
        ]);

        // Find related materials from database
        $relatedMaterials = Material::approved()
            ->search($request->query)
            ->take(5)
            ->get();

        // Get AI response with context
        $response = $this->ai->research($request->query, $relatedMaterials);

        // Log the session
        $aiSession = AiSession::create([
            'user_id' => Auth::id() ?? 1, // Guest fallback
            'query' => $request->query,
            'response' => $response,
            'query_type' => 'research',
            'related_material_ids' => $relatedMaterials->pluck('id')->toJson()
        ]);

        return response()->json([
            'success' => true,
            'response' => $response,
            'related_materials' => $relatedMaterials,
            'session_id' => $aiSession->id
        ]);
    }

    // Summarize uploaded file
    public function summarize(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,txt,png,jpg,jpeg|max:10240'
        ]);

        $file = $request->file('file');
        $text = $this->extractTextFromFile($file);
        
        if (empty($text)) {
            return response()->json([
                'success' => false,
                'message' => 'Could not extract text from file'
            ], 400);
        }

        $summary = $this->ai->summarize($text);

        // Log session
        if (Auth::check()) {
            AiSession::create([
                'user_id' => Auth::id(),
                'query' => 'Summarize file: ' . $file->getClientOriginalName(),
                'response' => $summary,
                'query_type' => 'summary'
            ]);
        }

        return response()->json([
            'success' => true,
            'summary' => $summary,
            'original_length' => strlen($text),
            'summary_length' => strlen($summary)
        ]);
    }

    // Find materials related to a topic
    public function findRelated(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:500'
        ]);

        $related = $this->ai->findRelatedMaterials($request->topic, 10);
        
        $materials = collect($related)->map(function($item) {
            return $item['material'];
        });

        return response()->json([
            'success' => true,
            'topic' => $request->topic,
            'materials' => $materials,
            'count' => $materials->count()
        ]);
    }

    // Check plagiarism
    public function checkPlagiarism(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:50'
        ]);

        // Get all materials for comparison
        $materials = Material::approved()->get();
        
        $result = $this->ai->detectPlagiarism($request->text, $materials);

        // Log session
        if (Auth::check()) {
            AiSession::create([
                'user_id' => Auth::id(),
                'query' => 'Plagiarism check: ' . substr($request->text, 0, 100),
                'response' => json_encode($result),
                'query_type' => 'plagiarism'
            ]);
        }

        return response()->json($result);
    }

    // Extract text from various file types
    private function extractTextFromFile($file)
    {
        $extension = $file->getClientOriginalExtension();
        $path = $file->getPathname();

        switch ($extension) {
            case 'txt':
                return file_get_contents($path);
                
            case 'pdf':
                $parser = new Parser();
                $pdf = $parser->parseFile($path);
                return $pdf->getText();
                
            case 'docx':
                $phpWord = IOFactory::load($path);
                $text = '';
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= $element->getText() . ' ';
                        }
                    }
                }
                return $text;
                
            case 'jpg':
            case 'jpeg':
            case 'png':
                // For images, you'd need OCR. This is a placeholder.
                return '[Image detected. OCR would extract text here.]';
                
            default:
                return null;
        }
    }
}