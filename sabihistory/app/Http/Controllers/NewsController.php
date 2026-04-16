<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:academic,department,university,general',
            'image_url' => 'nullable|url',
            'source_url' => 'nullable|url'
        ]);

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'image_url' => $request->image_url,
            'source_url' => $request->source_url,
            'posted_by' => Auth::id(),
            'published_at' => now()
        ]);

        return redirect()->route('news.index')->with('success', 'News published.');
    }

    public function destroy(News $news)
    {
        $this->authorize('admin');
        $news->delete();
        return redirect()->route('news.index')->with('success', 'News deleted.');
    }
}