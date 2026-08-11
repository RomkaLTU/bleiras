<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { create, destroy, edit, index } from '@/routes/admin/news';

type NewsItem = {
    id: number;
    title: string;
    published_at: string;
};

defineProps<{
    news: NewsItem[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'News',
                href: index(),
            },
        ],
    },
});

const deleteNews = (item: NewsItem) => {
    if (confirm('Are you sure you want to delete this news item?')) {
        router.delete(destroy(item.id));
    }
};
</script>

<template>
    <Head title="News" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4">
        <div class="flex items-center justify-between gap-4">
            <Heading title="News" description="Manage the published news" />
            <Button as-child>
                <Link :href="create()">Add news</Link>
            </Button>
        </div>

        <p v-if="news.length === 0" class="text-muted-foreground">
            There is no news yet.
        </p>

        <div
            v-else
            class="overflow-x-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
            <table class="w-full text-left text-sm">
                <thead class="border-b text-muted-foreground">
                    <tr>
                        <th class="px-4 py-3 font-medium">Title</th>
                        <th class="px-4 py-3 font-medium">Published at</th>
                        <th class="px-4 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in news"
                        :key="item.id"
                        class="border-b last:border-b-0"
                    >
                        <td class="px-4 py-3 font-medium">{{ item.title }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ item.published_at }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <Button variant="outline" size="sm" as-child>
                                    <Link :href="edit(item.id)">Edit</Link>
                                </Button>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="deleteNews(item)"
                                >
                                    Delete
                                </Button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
