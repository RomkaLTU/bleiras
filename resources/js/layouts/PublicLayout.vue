<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import PublicFooter from '@/components/PublicFooter.vue';
import { Button } from '@/components/ui/button';
import { home, login } from '@/routes';
import { index } from '@/routes/admin/news';

const page = usePage();

const accountLink = computed(() =>
    page.props.auth.user
        ? { href: index(), label: 'Admin' }
        : { href: login(), label: 'Log in' },
);
</script>

<template>
    <div class="flex min-h-svh flex-col bg-background text-foreground">
        <header class="border-b">
            <div
                class="mx-auto flex w-full max-w-3xl items-center justify-between gap-4 px-6 py-4"
            >
                <Link :href="home()" class="text-lg font-semibold">
                    {{ page.props.name }}
                </Link>
                <Button variant="outline" size="sm" as-child>
                    <Link :href="accountLink.href">{{
                        accountLink.label
                    }}</Link>
                </Button>
            </div>
        </header>
        <main class="mx-auto w-full max-w-3xl flex-1 px-6 py-10">
            <slot />
        </main>
        <PublicFooter />
    </div>
</template>
