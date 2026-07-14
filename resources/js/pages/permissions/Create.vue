<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Permisos',
                href: '/permissions',
            },
            {
                title: 'Crear permisos',
                href: '/permissions/create',
            },
        ],
    },
});

const form = useForm({
    name: '',
});

const submit = (): void => {
    form.post('/permissions');
};
</script>

<template>
    <Head title="Crear permiso" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                Crear permiso
            </h1>
            <p class="text-sm text-muted-foreground">
                Añade un nuevo permiso para zk-access-control
            </p>
        </div>

        <form
            class="max-w-2xl space-y-6 rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
            @submit.prevent="submit"
        >
            <div class="space-y-2">
                <label for="name" class="text-sm font-medium">
                    Nombre del permiso
                </label>

                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full rounded-md border bg-background px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Example: reports.view"
                />

                <p class="text-sm text-muted-foreground">
                    Usa el formato recurso.accion, por ejemplo:
                    users.view.
                </p>

                <p v-if="form.errors.name" class="text-sm text-red-600">
                    {{ form.errors.name }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    Crear permiso
                </button>

                <Link
                    href="/permissions"
                    class="rounded-md border px-4 py-2 text-sm hover:bg-muted"
                >
                    Cancelar
                </Link>
            </div>
        </form>
    </div>
</template>