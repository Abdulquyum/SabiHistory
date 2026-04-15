<?php

namespace App\Services;

use App\Models\Material;
use App\Models\AiSession;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

class AIService
{
    protected $apiKey;
    protected $model;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->model = 'gemini-pro';
    }

    // Summarize text using Gemini
    public function summarize($text, $maxLength = 300)
    {
        $prompt = "Summarize the following text in {$maxLength} characters or less. Be concise and capture key points:\n\n{$text}";
        
        return $this->callGemini($prompt);
    }

    // Research assistant with context from local materials
    public function research($query, $localMaterials = [])
    {
        $context = "";
        if (count($localMaterials) > 0) {
            $context = "Relevant materials from our database:\n";
            foreach ($localMaterials as $material) {
                $context .= "- {$material->title}: {$material->description}\n";
            }
            $context .= "\n";
        }

        $prompt = "You are a history and strategic studies research assistant. {$context}Answer this student's question accurately and helpfully:\n\n{$query}";
        
        return $this->callGemini($prompt);
    }

    // Detect plagiarism by comparing against database
    public function detectPlagiarism($text, $materials = [])
    {
        $matches = [];
        
        foreach ($materials as $material) {
            $similarity = $this->calculateSimilarity($text, $material->description ?? '');
            if ($similarity > 0.3) { // 30% similarity threshold
                $matches[] = [
                    'material_id' => $material->id,
                    'title' => $material->title,
                    'similarity' => round($similarity * 100, 2)
                ];
            }
        }
        
        return [
            'plagiarism_detected' => count($matches) > 0,
            'matches' => $matches,
            'originality_score' => 100 - (count($matches) > 0 ? $matches[0]['similarity'] : 0)
        ];
    }

    // Find related materials using keyword extraction
    public function findRelatedMaterials($query, $limit = 10)
    {
        $keywords = $this->extractKeywords($query);
        $materials = Material::approved()->get();
        
        $ranked = [];
        foreach ($materials as $material) {
            $score = $this->relevanceScore($query . ' ' . implode(' ', $keywords), $material->title . ' ' . $material->description);
            if ($score > 0) {
                $ranked[] = [
                    'material' => $material,
                    'score' => $score
                ];
            }
        }
        
        usort($ranked, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        return array_slice($ranked, 0, $limit);
    }

    // Generate "Today in History" content
    public function generateTodayInHistory()
    {
        $today = date('F j');
        $prompt = "Give me a interesting historical fact that happened on {$today}. Keep it under 280 characters. Format: 'On this day in [YEAR], [EVENT]'";
        
        return $this->callGemini($prompt);
    }

    // Generate "Did You Know" content
    public function generateDidYouKnow()
    {
        $prompt = "Give me a fascinating but lesser-known historical fact. Keep it under 280 characters. Start with 'Did you know?'";
        
        return $this->callGemini($prompt);
    }

    // Private: Call Gemini API
    private function callGemini($prompt)
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";
        
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode === 200) {
            $result = json_decode($response, true);
            return $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Unable to generate response.';
        }
        
        return 'AI service temporarily unavailable. Please try again later.';
    }

    // Simple text similarity calculation
    private function calculateSimilarity($str1, $str2)
    {
        $words1 = array_unique(str_word_count(strtolower($str1), 1));
        $words2 = array_unique(str_word_count(strtolower($str2), 1));
        
        $intersection = count(array_intersect($words1, $words2));
        $union = count(array_unique(array_merge($words1, $words2)));
        
        return $union > 0 ? $intersection / $union : 0;
    }

    // Extract keywords from text
    private function extractKeywords($text)
    {
        $stopWords = ['the', 'and', 'of', 'to', 'in', 'for', 'on', 'with', 'by', 'is', 'are', 'was', 'were'];
        $words = str_word_count(strtolower($text), 1);
        return array_diff($words, $stopWords);
    }

    // Calculate relevance score
    private function relevanceScore($query, $content)
    {
        $queryWords = $this->extractKeywords($query);
        $contentWords = $this->extractKeywords($content);
        
        $matches = 0;
        foreach ($queryWords as $word) {
            if (in_array($word, $contentWords)) {
                $matches++;
            }
        }
        
        return count($queryWords) > 0 ? $matches / count($queryWords) : 0;
    }
}