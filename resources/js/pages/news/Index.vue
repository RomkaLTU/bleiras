<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { show } from '@/routes/news';

type NewsItem = {
    id: number;
    title: string;
    excerpt: string;
    published_at: string;
};

defineProps<{
    news: NewsItem[];
}>();

const formatDate = (date: string) =>
    new Date(date).toLocaleDateString(undefined, { dateStyle: 'long' });
</script>

<template>
    <Head title="News" />

    <div class="flex flex-col gap-6">
        <h1 class="text-2xl font-semibold">News</h1>

        <p v-if="news.length === 0" class="text-muted-foreground">
            There is no news yet.
        </p>

        <Card v-for="item in news" :key="item.id" class="gap-3">
            <CardHeader>
                <CardTitle class="text-xl">
                    <Link :href="show(item.id)" class="hover:underline">
                        {{ item.title }}
                    </Link>
                </CardTitle>
                <p class="text-sm text-muted-foreground">
                    {{ formatDate(item.published_at) }}
                </p>
            </CardHeader>
            <CardContent class="text-muted-foreground">
                {{ item.excerpt }}
            </CardContent>
        </Card>
    </div>
</template>
