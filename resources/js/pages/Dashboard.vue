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
                title: 'Panel de Control',
                href: dashboard(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Panel principal" />

    <div class="flex h-full flex-1 flex-col gap-6 p-4">
        <section>
            <h1 class="text-2xl font-semibold tracking-tight">
                Zar-Kruse-Access-Control
            </h1>
            <p class="mt-1 text-sm text-muted-foreground">
                Resumen de usuarios, roles y permisos configurados en el sistema.
            </p>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <article
                class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Usuarios
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
                        Usuarios registrados
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
                    Roles disponibles para la asignacion de acceso
                </p>
            </article>

            <article
                class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Permisos
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
                    Permisos disponibles en el sistema
                </p>
            </article>
        </section>

        <section
            class="rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm dark:border-sidebar-border"
        >
            <h2 class="text-lg font-semibold">
                Descripcion General del sistema
            </h2>

            <p class="mt-2 max-w-3xl text-sm leading-6 text-muted-foreground">
                    ZK es una aplicación web básica que permita realizar operaciones CRUD (Crear, Leer, Actualizar,
                    Eliminar) para usuarios y manejar el login de usuarios con control de permisos.
            </p>
        </section>
    </div>
</template>