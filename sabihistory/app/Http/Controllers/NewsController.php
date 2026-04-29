<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    // Admin only
    public function create()
    {
        $this->authorize('admin');
        return view('news.create');
    }

    public function store(Request $request)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:academic,department,university,general',
            'image_url' => 'nullable|url',
            'source_url' => 'nullable|url',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
        ]);

        $attachmentPath = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $uploaded = $request->file('attachment');
            $attachmentPath = $uploaded->store('news-attachments', 'public');
            $attachmentType = str_starts_with((string) $uploaded->getMimeType(), 'image/') ? 'image' : 'pdf';
        }

        News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'image_url' => $validated['image_url'] ?? null,
            'source_url' => $validated['source_url'] ?? null,
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
            'posted_by' => Auth::id(),
            'published_at' => now()
        ]);

        return redirect()->route('admin.news')->with('success', 'News published.');
    }

    public function edit(News $news)
    {
        $this->authorize('admin');
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $this->authorize('admin');

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:academic,department,university,general',
            'image_url' => 'nullable|url',
            'source_url' => 'nullable|url',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'remove_attachment' => 'nullable|boolean',
        ]);

        $attachmentPath = $news->attachment_path;
        $attachmentType = $news->attachment_type;

        if (!empty($validated['remove_attachment']) && $attachmentPath) {
            if (Storage::disk('public')->exists($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }

            $attachmentPath = null;
            $attachmentType = null;
        }

        if ($request->hasFile('attachment')) {
            if ($attachmentPath && Storage::disk('public')->exists($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }

            $uploaded = $request->file('attachment');
            $attachmentPath = $uploaded->store('news-attachments', 'public');
            $attachmentType = str_starts_with((string) $uploaded->getMimeType(), 'image/') ? 'image' : 'pdf';
        }

        $news->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category' => $validated['category'],
            'image_url' => $validated['image_url'] ?? null,
            'source_url' => $validated['source_url'] ?? null,
            'attachment_path' => $attachmentPath,
            'attachment_type' => $attachmentType,
        ]);

        return redirect()->route('admin.news')->with('success', 'News updated.');
    }

    public function destroy(News $news)
    {
        $this->authorize('admin');

        if ($news->attachment_path && Storage::disk('public')->exists($news->attachment_path)) {
            Storage::disk('public')->delete($news->attachment_path);
        }

        $news->delete();
        return redirect()->route('admin.news')->with('success', 'News deleted.');
    }
}