<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import NewsForm from '@/components/NewsForm.vue';
import { create, index, store } from '@/routes/admin/news';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'News',
                href: index(),
            },
            {
                title: 'Add news',
                href: create(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Add news" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4">
        <Heading title="Add news" />

        <NewsForm :action="store.form()" submit-label="Create news" />
    </div>
</template>
