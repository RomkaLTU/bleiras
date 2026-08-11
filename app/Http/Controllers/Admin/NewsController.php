<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    /**
     * Show all news, newest first.
     */
    public function index(): Response
    {
        return Inertia::render('admin/news/Index', [
            'news' => News::query()
                ->latest('published_at')
                ->get()
                ->map(fn (News $news) => [
                    'id' => $news->id,
                    'title' => $news->title,
                    'published_at' => $news->published_at->format('M j, Y H:i'),
                ]),
        ]);
    }

    /**
     * Show the form for creating news.
     */
    public function create(): Response
    {
        return Inertia::render('admin/news/Create');
    }

    /**
     * Store a new news item.
     */
    public function store(NewsRequest $request): RedirectResponse
    {
        News::create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('News created.')]);

        return to_route('admin.news.index');
    }

    /**
     * Show the form for editing news.
     */
    public function edit(News $news): Response
    {
        return Inertia::render('admin/news/Edit', [
            'news' => [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'published_at' => $news->published_at->format('Y-m-d\TH:i'),
            ],
        ]);
    }

    /**
     * Update the given news item.
     */
    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        $news->update($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('News updated.')]);

        return to_route('admin.news.index');
    }

    /**
     * Delete the given news item.
     */
    public function destroy(News $news): RedirectResponse
    {
        $news->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('News deleted.')]);

        return to_route('admin.news.index');
    }
}
