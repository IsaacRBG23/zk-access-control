<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Permisos',
                href: '/permissions',
            },
        ],
    },
});

interface Permission {
    id: number;
    name: string;
    roles_count: number;
    created_at: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedPermissions {
    data: Permission[];
    links: PaginationLink[];
}

defineProps<{
    permissions: PaginatedPermissions;
}>();

const deletePermission = (permission: Permission): void => {
    if (
        !confirm(
            `Estas seguro que deseas borrar el siguiente permiso "${permission.name}"?`,
        )
    ) {
        return;
    }

    router.delete(`/permissions/${permission.id}`);
};
</script>

<template>
    <Head title="Permisos" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    Permisos
                </h1>
                <p class="text-sm text-muted-foreground">
                  Control de permisos disponible en el sistema
                </p>
            </div>

            <Link
                href="/permissions/create"
                class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90"
            >
                Nuevo permiso
            </Link>
        </div>

        <div
            class="overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
        >
            <table class="w-full text-sm">
                <thead class="border-b bg-muted/50 text-left">
                    <tr>
                        <th class="px-4 py-3 font-medium">Nombre</th>
                        <th class="px-4 py-3 font-medium">Roles asignados</th>
                        <th class="px-4 py-3 font-medium">Creado</th>
                        <th class="px-4 py-3 text-right font-medium">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="permission in permissions.data"
                        :key="permission.id"
                        class="border-b last:border-b-0"
                    >
                        <td class="px-4 py-3 font-medium">
                            {{ permission.name }}
                        </td>

                        <td class="px-4 py-3">
                            {{ permission.roles_count }}
                        </td>

                        <td class="px-4 py-3">
                            {{ permission.created_at ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <Link
                                    :href="`/permissions/${permission.id}/edit`"
                                    class="rounded-md border px-3 py-1 text-sm hover:bg-muted"
                                >
                                    Editar
                                </Link>

                                <button
                                    type="button"
                                    class="rounded-md border px-3 py-1 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950"
                                    @click="deletePermission(permission)"
                                >
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="permissions.data.length === 0">
                        <td
                            colspan="4"
                            class="px-4 py-8 text-center text-muted-foreground"
                        >
                           Permisos no encontrados
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-wrap gap-2">
            <Link
                v-for="link in permissions.links"
                :key="link.label"
                :href="link.url ?? '#'"
                class="rounded-md border px-3 py-1 text-sm"
                :class="{
                    'bg-primary text-primary-foreground': link.active,
                    'pointer-events-none opacity-50': !link.url,
                }"
            >
                <span v-html="link.label" />
            </Link>
        </div>
    </div>
</template>