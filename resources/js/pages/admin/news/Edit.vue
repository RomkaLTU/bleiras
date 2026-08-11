<script setup lang="ts">
import { Head, setLayoutProps } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import NewsForm from '@/components/NewsForm.vue';
import { edit, index, update } from '@/routes/admin/news';

const { news } = defineProps<{
    news: {
        id: number;
        title: string;
        content: string;
        published_at: string;
    };
}>();

setLayoutProps({
    breadcrumbs: [
        {
            title: 'News',
            href: index(),
        },
        {
            title: news.title,
            href: edit(news.id),
        },
    ],
});
</script>

<template>
    <Head title="Edit news" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4">
        <Heading title="Edit news" />

        <NewsForm
            :action="update.form(news.id)"
            :news="news"
            submit-label="Save news"
        />
    </div>
</template>
