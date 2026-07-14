<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

type Role = {
    id: number;
    name: string;
};

type User = {
    id: number;
    name: string;
    email: string;
    role: string;
    roles: number[];
};

const props = defineProps<{
    user: User;
    roles: Role[];
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Usuarios',
                href: '/users',
            },
            {
                title: 'Editar usuario',
                href: '/users',
            },
        ],
    },
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    role: props.user.role,
    roles: props.user.roles,
});

const submit = (): void => {
    form.put(`/users/${props.user.id}`);
};
</script>

<template>
    <Head title="Editar usuario" />

    <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Editar usuario</h1>
            <p class="text-sm text-muted-foreground">
                Actualizar la informacion y el rol del usuario
            </p>
        </div>

        <form
            class="max-w-2xl space-y-6 rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border"
            @submit.prevent="submit"
        >
            <div class="space-y-2">
                <label
                    for="name"
                    class="text-sm font-medium"
                >
                    Nombre
                </label>

                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="w-full rounded-md border bg-background px-3 py-2 text-sm"
                    autocomplete="name"
                />

                <p
                    v-if="form.errors.name"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.name }}
                </p>
            </div>

            <div class="space-y-2">
                <label
                    for="email"
                    class="text-sm font-medium"
                >
                    Correo
                </label>

                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="w-full rounded-md border bg-background px-3 py-2 text-sm"
                    autocomplete="email"
                />

                <p
                    v-if="form.errors.email"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.email }}
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label
                        for="password"
                        class="text-sm font-medium"
                    >
                        Nueva contraseña
                    </label>

                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="w-full rounded-md border bg-background px-3 py-2 text-sm"
                        autocomplete="new-password"
                    />

                    <p class="text-xs text-muted-foreground">
                        Este espacio no puede permanecer en blanco
                    </p>

                    <p
                        v-if="form.errors.password"
                        class="text-sm text-destructive"
                    >
                        {{ form.errors.password }}
                    </p>
                </div>

                <div class="space-y-2">
                    <label
                        for="password_confirmation"
                        class="text-sm font-medium"
                    >
                        Confirmar la nueva contraseña
                    </label>

                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="w-full rounded-md border bg-background px-3 py-2 text-sm"
                        autocomplete="new-password"
                    />
                </div>
            </div>

            <div class="space-y-2">
                <label
                    for="role"
                    class="text-sm font-medium"
                >
                    Rol primario
                </label>

                <select
                    id="role"
                    v-model="form.role"
                    class="w-full rounded-md border bg-background px-3 py-2 text-sm"
                >
                    <option
                        v-for="role in props.roles"
                        :key="role.id"
                        :value="role.name"
                    >
                        {{ role.name }}
                    </option>
                </select>

                <p
                    v-if="form.errors.role"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.role }}
                </p>
            </div>

            <div class="space-y-3">
                <p class="text-sm font-medium">Asignacion de rol</p>

                <div class="grid gap-2 md:grid-cols-2">
                    <label
                        v-for="role in props.roles"
                        :key="role.id"
                        class="flex items-center gap-2 rounded-md border p-3 text-sm"
                    >
                        <input
                            v-model="form.roles"
                            type="checkbox"
                            :value="role.id"
                        />

                        <span>{{ role.name }}</span>
                    </label>
                </div>

                <p
                    v-if="form.errors.roles"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.roles }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    Actualizar usuario
                </button>

                <Link
                    href="/users"
                    class="rounded-md border px-4 py-2 text-sm font-medium hover:bg-muted"
                >
                    Cancelar
                </Link>
            </div>
        </form>
    </div>
</template>