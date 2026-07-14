<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Rol',
                href: '/roles',
            },
            {
                title: 'Editar rol',
                href: '/roles',
            },
        ],
    },
});

interface Role {
    id: number;
    name: string;
    permissions: number[];
}

interface Permission {
    id: number;
    name: string;
}

const props = defineProps<{
    role: Role;
    permissions: Permission[];
}>();

const form = useForm({
    name: props.role.name,
    permissions: [...props.role.permissions],
});

const togglePermission = (permissionId: number): void => {
    if (form.permissions.includes(permissionId)) {
        form.permissions = form.permissions.filter((id) => id !== permissionId);
        return;
    }

    form.permissions = [...form.permissions, permissionId];
};

const submit = (): void => {
    form.put(`/roles/${props.role.id}`);
};
</script>

<template>
    <Head title="Editar rol" />

    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Editar rol</h1>
            <p class="text-sm text-muted-foreground">
                Actualice la información del rol y los permisos asignados
            </p>
        </div>

        <form
            class="max-w-3xl space-y-6 rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
            @submit.prevent="submit"
        >
            <div class="space-y-2">
                <label for="name" class="text-sm font-medium">Nombre</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full rounded-md border bg-background px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-ring"
                />
                <p v-if="form.errors.name" class="text-sm text-red-600">
                    {{ form.errors.name }}
                </p>
            </div>

            <div class="space-y-3">
                <div>
                    <h2 class="text-sm font-medium">Permisos</h2>
                    <p class="text-sm text-muted-foreground">
                        Selecciona los permisos asignados al rol
                    </p>
                </div>

                <div class="grid gap-3 md:grid-cols-2">
                    <label
                        v-for="permission in permissions"
                        :key="permission.id"
                        class="flex cursor-pointer items-center gap-3 rounded-md border p-3 text-sm hover:bg-muted"
                    >
                        <input
                            type="checkbox"
                            :checked="form.permissions.includes(permission.id)"
                            @change="togglePermission(permission.id)"
                        />
                        <span>{{ permission.name }}</span>
                    </label>
                </div>

                <p v-if="form.errors.permissions" class="text-sm text-red-600">
                    {{ form.errors.permissions }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    Actualizar rol
                </button>

                <Link
                    href="/roles"
                    class="rounded-md border px-4 py-2 text-sm hover:bg-muted"
                >
                    Cancelar
                </Link>
            </div>
        </form>
    </div>
</template>