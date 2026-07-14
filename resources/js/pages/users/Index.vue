<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

type Role = {
    id: number;
    name: string;
};

type User = {
    id: number;
    name: string;
    email: string;
    role: string;
    roles: Role[];
    created_at: string | null;
};

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

type PaginatedUsers = {
    data: User[];
    links: PaginationLink[];
};

defineProps<{
    users: PaginatedUsers;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Usuarios',
                href: '/users',
            },
        ],
    },
});

const deleteUser = (user: User): void => {
    if (!confirm(`Desea eliminar el usuario "${user.name}"? Esta accion no se puede deshacer.`)) {
        return;
    }

    router.delete(`/users/${user.id}`);
};
</script>

<template>
    <Head title="Usuarios" />

    <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Usuarios</h1>
                <p class="text-sm text-muted-foreground">
                    Administre los usuarios de la aplicación y asigne sus roles
                </p>
            </div>

            <Link
                href="/users/create"
                class="inline-flex items-center justify-center rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow hover:bg-primary/90"
            >
                Nuevo Usuario
            </Link>
        </div>

        <div class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
            <table class="w-full text-left text-sm">
                <thead class="border-b bg-muted/40">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nombre</th>
                        <th class="px-4 py-3 font-medium">Correo</th>
                        <th class="px-4 py-3 font-medium">Role primario</th>
                        <th class="px-4 py-3 font-medium">Role Asignado</th>
                        <th class="px-4 py-3 font-medium">Fec. Creacion</th>
                        <th class="px-4 py-3 text-right font-medium">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="user in users.data"
                        :key="user.id"
                        class="border-b last:border-b-0"
                    >
                        <td class="px-4 py-3 font-medium">
                            {{ user.name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ user.email }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="rounded-full bg-muted px-2 py-1 text-xs font-medium">
                                {{ user.role }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                <span
                                    v-for="role in user.roles"
                                    :key="role.id"
                                    class="rounded-full border px-2 py-1 text-xs"
                                >
                                    {{ role.name }}
                                </span>

                                <span
                                    v-if="user.roles.length === 0"
                                    class="text-xs text-muted-foreground"
                                >
                                    Sin rol Asignado
                                </span>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-muted-foreground">
                            {{ user.created_at }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <Link
                                    :href="`/users/${user.id}/edit`"
                                    class="rounded-md border px-3 py-1.5 text-xs font-medium hover:bg-muted"
                                >
                                    Editar
                                </Link>

                                <button
                                    type="button"
                                    class="rounded-md border border-destructive/40 px-3 py-1.5 text-xs font-medium text-destructive hover:bg-destructive/10"
                                    @click="deleteUser(user)"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="users.data.length === 0">
                        <td
                            colspan="6"
                            class="px-4 py-8 text-center text-sm text-muted-foreground"
                        >
                            No se encontraron Usuarios
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            v-if="users.links.length > 3"
            class="flex flex-wrap items-center gap-2"
        >
            <template
                v-for="link in users.links"
                :key="link.label"
            >
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="rounded-md border px-3 py-1.5 text-sm"
                    :class="{ 'bg-primary text-primary-foreground': link.active }"
                    v-html="link.label"
                />

                <span
                    v-else
                    class="rounded-md border px-3 py-1.5 text-sm text-muted-foreground"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>