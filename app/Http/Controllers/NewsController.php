<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    /**
     * Show the published news, newest first.
     */
    public function index(): Response
    {
        return Inertia::render('news/Index', [
            'news' => News::query()
                ->published()
                ->latest('published_at')
                ->get()
                ->map(fn (News $news) => [
                    'id' => $news->id,
                    'title' => $news->title,
                    'excerpt' => $news->excerpt,
                    'published_at' => $news->published_at,
                ]),
        ]);
    }

    /**
     * Show a single published news item.
     */
    public function show(News $news): Response
    {
        abort_if($news->published_at->isFuture(), 404);

        return Inertia::render('news/Show', [
            'news' => [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'published_at' => $news->published_at,
            ],
        ]);
    }
}
