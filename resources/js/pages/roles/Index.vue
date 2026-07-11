<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Roles',
                href: '/roles',
            },
        ],
    },
});

interface Role {
    id: number;
    name: string;
    users_count: number;
    permissions_count: number;
    created_at: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedRoles {
    data: Role[];
    links: PaginationLink[];
}

defineProps<{
    roles: PaginatedRoles;
}>();

const deleteRole = (role: Role): void => {
    if (!confirm(`Are you sure you want to delete the role "${role.name}"?`)) {
        return;
    }

    router.delete(`/roles/${role.id}`);
};
</script>

<template>
    <Head title="Roles" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Roles</h1>
                <p class="text-sm text-muted-foreground">
                    Manage system roles and their assigned permissions.
                </p>
            </div>

            <Link
                href="/roles/create"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
                Create role
            </Link>
        </div>

        <div class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <table class="w-full text-sm">
                <thead class="border-b bg-muted/50 text-left">
                    <tr>
                        <th class="px-4 py-3 font-medium">Name</th>
                        <th class="px-4 py-3 font-medium">Users</th>
                        <th class="px-4 py-3 font-medium">Permissions</th>
                        <th class="px-4 py-3 font-medium">Created at</th>
                        <th class="px-4 py-3 text-right font-medium">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="role in roles.data"
                        :key="role.id"
                        class="border-b last:border-b-0"
                    >
                        <td class="px-4 py-3 font-medium">
                            {{ role.name }}
                        </td>
                        <td class="px-4 py-3">
                            {{ role.users_count }}
                        </td>
                        <td class="px-4 py-3">
                            {{ role.permissions_count }}
                        </td>
                        <td class="px-4 py-3">
                            {{ role.created_at ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <Link
                                    :href="`/roles/${role.id}/edit`"
                                    class="rounded-md border px-3 py-1 text-sm hover:bg-muted"
                                >
                                    Edit
                                </Link>

                                <button
                                    type="button"
                                    class="rounded-md border px-3 py-1 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950"
                                    @click="deleteRole(role)"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="roles.data.length === 0">
                        <td
                            colspan="5"
                            class="px-4 py-8 text-center text-muted-foreground"
                        >
                            No roles found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap gap-2">
            <Link
                v-for="link in roles.links"
                :key="link.label"
                :href="link.url ?? '#'"
                class="rounded-md border px-3 py-1 text-sm"
                :class="{
                    'bg-primary text-primary-foreground': link.active,
                    'pointer-events-none opacity-50': !link.url,
                }"
                v-html="link.label"
            />
        </div>
    </div>
</template>