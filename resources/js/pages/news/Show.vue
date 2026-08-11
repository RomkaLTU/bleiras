<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft } from '@lucide/vue';
import { home } from '@/routes';

type NewsItem = {
    id: number;
    title: string;
    content: string;
    published_at: string;
};

const { news } = defineProps<{
    news: NewsItem;
}>();

const publishedAt = new Date(news.published_at).toLocaleDateString(undefined, {
    dateStyle: 'long',
});
</script>

<template>
    <Head :title="news.title" />

    <article class="flex flex-col gap-6">
        <Link
            :href="home()"
            class="inline-flex items-center gap-1.5 text-sm text-muted-foreground hover:text-foreground"
        >
            <ArrowLeft class="size-4" />
            Back to news
        </Link>

        <div class="flex flex-col gap-2">
            <h1 class="text-2xl font-semibold">{{ news.title }}</h1>
            <p class="text-sm text-muted-foreground">{{ publishedAt }}</p>
        </div>

        <div class="whitespace-pre-line">{{ news.content }}</div>
    </article>
</template>
