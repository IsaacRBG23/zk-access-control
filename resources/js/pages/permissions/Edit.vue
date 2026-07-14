<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Permissions',
                href: '/permissions',
            },
            {
                title: 'Edit permission',
                href: '/permissions',
            },
        ],
    },
});

interface Permission {
    id: number;
    name: string;
}

const props = defineProps<{
    permission: Permission;
}>();

const form = useForm({
    name: props.permission.name,
});

const submit = (): void => {
    form.put(`/permissions/${props.permission.id}`);
};
</script>

<template>
    <Head title="Edit permission" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">
                Edit permission
            </h1>
            <p class="text-sm text-muted-foreground">
                Update the selected permission.
            </p>
        </div>

        <form
            class="max-w-2xl space-y-6 rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
            @submit.prevent="submit"
        >
            <div class="space-y-2">
                <label for="name" class="text-sm font-medium">
                    Permission name
                </label>

                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full rounded-md border bg-background px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-ring"
                />

                <p class="text-sm text-muted-foreground">
                    Use the format resource.action, for example:
                    permissions.update.
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
                    Update permission
                </button>

                <Link
                    href="/permissions"
                    class="rounded-md border px-4 py-2 text-sm hover:bg-muted"
                >
                    Cancel
                </Link>
            </div>
        </form>
    </div>
</template>