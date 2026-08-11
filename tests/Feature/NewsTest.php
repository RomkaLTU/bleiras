<?php

use App\Models\News;
use Inertia\Testing\AssertableInertia as Assert;

test('news list is displayed newest first', function () {
    $older = News::factory()->create(['published_at' => now()->subWeek()]);
    $newer = News::factory()->create(['published_at' => now()->subDay()]);

    $response = $this->get(route('home'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('news/Index')
        ->has('news', 2)
        ->where('news.0.id', $newer->id)
        ->where('news.1.id', $older->id),
    );
});

test('news list does not show news published in the future', function () {
    $published = News::factory()->create();
    News::factory()->scheduled()->create();

    $response = $this->get(route('home'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('news/Index')
        ->has('news', 1)
        ->where('news.0.id', $published->id),
    );
});

test('published news can be viewed', function () {
    $news = News::factory()->create();

    $response = $this->get(route('news.show', $news));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('news/Show')
        ->where('news.title', $news->title)
        ->where('news.content', $news->content),
    );
});

test('news published in the future cannot be viewed', function () {
    $news = News::factory()->scheduled()->create();

    $this->get(route('news.show', $news))->assertNotFound();
});
