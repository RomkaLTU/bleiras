<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { home, login } from '@/routes';

const page = usePage();

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="border-t">
        <div class="mx-auto w-full max-w-3xl px-6 py-10">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-3">
                <div class="flex flex-col gap-2">
                    <h2 class="text-sm font-semibold">{{ page.props.name }}</h2>
                    <p class="text-sm text-muted-foreground">
                        A small site for news and updates. Everything worth
                        knowing about, published as it happens.
                    </p>
                </div>

                <div class="flex flex-col gap-2">
                    <h2 class="text-sm font-semibold">Links</h2>
                    <nav
                        aria-label="Footer"
                        class="flex flex-col items-start gap-2 text-sm text-muted-foreground"
                    >
                        <Link :href="home()" class="hover:underline">Home</Link>
                        <Link :href="login()" class="hover:underline">
                            Log in
                        </Link>
                    </nav>
                </div>

                <div class="flex flex-col gap-2">
                    <h2 class="text-sm font-semibold">Contact</h2>
                    <a
                        href="mailto:romas@salonradar.com"
                        class="text-sm text-muted-foreground hover:underline"
                    >
                        romas@salonradar.com
                    </a>
                </div>
            </div>

            <p class="mt-8 border-t pt-6 text-xs text-muted-foreground">
                © {{ currentYear }} {{ page.props.name }}
            </p>
        </div>
    </footer>
</template>
