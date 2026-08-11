<?php

use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('guests are redirected to the login page', function (string $method, string $uri) {
    $news = News::factory()->create();

    $this->call($method, str_replace('{news}', (string) $news->id, $uri))
        ->assertRedirect(route('login'));
})->with([
    ['get', '/admin/news'],
    ['get', '/admin/news/create'],
    ['post', '/admin/news'],
    ['get', '/admin/news/{news}/edit'],
    ['put', '/admin/news/{news}'],
    ['delete', '/admin/news/{news}'],
]);

test('unverified users are redirected to the email verification notice', function () {
    $unverified = User::factory()->unverified()->create();

    $this->actingAs($unverified)->get(route('admin.news.index'))
        ->assertRedirect(route('verification.notice'));
});

test('registration is no longer available', function () {
    $this->get('/register')->assertNotFound();

    expect(Route::has('register'))->toBeFalse();
});

test('all news is listed newest first', function () {
    $older = News::factory()->create(['published_at' => now()->subWeek()]);
    $scheduled = News::factory()->scheduled()->create();

    $response = $this->actingAs($this->user)->get(route('admin.news.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('admin/news/Index')
        ->has('news', 2)
        ->where('news.0.id', $scheduled->id)
        ->where('news.1.id', $older->id),
    );
});

test('news can be created and shows up on the public page', function () {
    $response = $this->actingAs($this->user)->post(route('admin.news.store'), [
        'title' => 'Fresh off the press',
        'content' => 'Something happened today.',
        'published_at' => now()->format('Y-m-d\TH:i'),
    ]);

    $response->assertRedirect(route('admin.news.index'));

    $this->assertDatabaseHas(News::class, [
        'title' => 'Fresh off the press',
        'content' => 'Something happened today.',
    ]);

    $this->get(route('home'))->assertInertia(fn (Assert $page) => $page
        ->component('news/Index')
        ->has('news', 1)
        ->where('news.0.title', 'Fresh off the press'),
    );
});

test('news cannot be created with invalid data', function (array $attributes, string $field) {
    $response = $this->actingAs($this->user)->post(route('admin.news.store'), [
        'title' => 'Fresh off the press',
        'content' => 'Something happened today.',
        'published_at' => now()->format('Y-m-d\TH:i'),
        ...$attributes,
    ]);

    $response->assertInvalid($field);

    $this->assertDatabaseCount(News::class, 0);
})->with([
    'missing title' => [['title' => ''], 'title'],
    'missing content' => [['content' => ''], 'content'],
    'invalid published at' => [['published_at' => 'not a date'], 'published_at'],
]);

test('news can be edited', function () {
    $news = News::factory()->create();

    $response = $this->actingAs($this->user)->get(route('admin.news.edit', $news));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('admin/news/Edit')
        ->where('news.title', $news->title)
        ->where('news.published_at', $news->published_at->format('Y-m-d\TH:i')),
    );
});

test('news can be updated', function () {
    $news = News::factory()->create();

    $response = $this->actingAs($this->user)->put(route('admin.news.update', $news), [
        'title' => 'Updated title',
        'content' => 'Updated content.',
        'published_at' => '2026-01-31T09:30',
    ]);

    $response->assertRedirect(route('admin.news.index'));

    expect($news->refresh())
        ->title->toBe('Updated title')
        ->content->toBe('Updated content.')
        ->and($news->published_at->format('Y-m-d H:i'))->toBe('2026-01-31 09:30');
});

test('news can be deleted', function () {
    $news = News::factory()->create();

    $response = $this->actingAs($this->user)->delete(route('admin.news.destroy', $news));

    $response->assertRedirect(route('admin.news.index'));

    $this->assertModelMissing($news);
});

test('logging in redirects to the admin news list', function () {
    $response = $this->post(route('login.store'), [
        'email' => $this->user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.news.index', absolute: false));
});
