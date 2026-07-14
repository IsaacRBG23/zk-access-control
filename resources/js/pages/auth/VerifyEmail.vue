<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Spinner } from '@/components/ui/spinner';
import { logout } from '@/routes';
import { send } from '@/routes/verification';

defineOptions({
    layout: {
        title: 'correo de verificacion',
        description:
            'Por favor, verifique su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar.',
    },
});

defineProps<{
    status?: string;
}>();
</script>

<template>
    <Head title="Correo verificacion" />

    <div
        v-if="status === 'verification-link-sent'"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.
    </div>

    <Form
        v-bind="send.form()"
        class="space-y-6 text-center"
        v-slot="{ processing }"
    >
        <Button :disabled="processing" variant="secondary">
            <Spinner v-if="processing" />
          Reenviar el correo de verificacion
        </Button>

        <TextLink :href="logout()" as="button" class="mx-auto block text-sm">
            Cerrar Sesion
        </TextLink>
    </Form>
</template>
