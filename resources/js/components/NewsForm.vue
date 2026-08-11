<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import type { RouteFormDefinition } from '@/wayfinder';

type Props = {
    action: RouteFormDefinition<'post'>;
    submitLabel: string;
    news?: {
        title: string;
        content: string;
        published_at: string;
    };
};

const { news } = defineProps<Props>();
</script>

<template>
    <Form
        v-bind="action"
        class="flex max-w-2xl flex-col gap-6"
        v-slot="{ errors, processing }"
    >
        <div class="grid gap-2">
            <Label for="title">Title</Label>
            <Input
                id="title"
                name="title"
                :default-value="news?.title"
                required
                autofocus
            />
            <InputError :message="errors.title" />
        </div>

        <div class="grid gap-2">
            <Label for="content">Content</Label>
            <textarea
                id="content"
                name="content"
                rows="12"
                :value="news?.content"
                required
                class="min-h-32 w-full rounded-md border border-input bg-transparent px-3 py-2 text-base shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm dark:bg-input/30"
            />
            <InputError :message="errors.content" />
        </div>

        <div class="grid gap-2">
            <Label for="published_at">Published at</Label>
            <Input
                id="published_at"
                type="datetime-local"
                name="published_at"
                :default-value="news?.published_at"
                required
                class="w-fit"
            />
            <InputError :message="errors.published_at" />
        </div>

        <div>
            <Button type="submit" :disabled="processing">
                <Spinner v-if="processing" />
                {{ submitLabel }}
            </Button>
        </div>
    </Form>
</template>
