<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import {
    KeyRound,
    ShieldCheck,
    Users,
} from '@lucide/vue';
import { dashboard } from '@/routes';

type Metrics = {
    users: number;
    roles: number;
    permissions: number;
};

defineProps<{
    metrics: Metrics;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4">
        <section>
            <h1 class="text-2xl font-semibold tracking-tight">
                Access Control Dashboard
            </h1>
            <p class="mt-1 text-sm text-muted-foreground">
                Overview of users, roles, and permissions configured in the
                system.
            </p>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <article
                class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Users
                        </p>
                        <p class="mt-2 text-3xl font-bold">
                            {{ metrics.users }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-muted p-3">
                        <Users class="size-6" />
                    </div>
                </div>

                <p class="mt-4 text-sm text-muted-foreground">
                    Registered application users.
                </p>
            </article>

            <article
                class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Roles
                        </p>
                        <p class="mt-2 text-3xl font-bold">
                            {{ metrics.roles }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-muted p-3">
                        <ShieldCheck class="size-6" />
                    </div>
                </div>

                <p class="mt-4 text-sm text-muted-foreground">
                    Roles available for access assignment.
                </p>
            </article>

            <article
                class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Permissions
                        </p>
                        <p class="mt-2 text-3xl font-bold">
                            {{ metrics.permissions }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-muted p-3">
                        <KeyRound class="size-6" />
                    </div>
                </div>

                <p class="mt-4 text-sm text-muted-foreground">
                    Permission rules available in the system.
                </p>
            </article>
        </section>

        <section
            class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
        >
            <h2 class="text-lg font-semibold">
                System overview
            </h2>

            <p class="mt-2 max-w-3xl text-sm leading-6 text-muted-foreground">
                ZK Access Control provides centralized user, role, and permission
                management. Use the sidebar to administer access rules according
                to the permissions assigned to your account.
            </p>
        </section>
    </div>
</template>