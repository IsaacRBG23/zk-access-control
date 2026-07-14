<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    KeyRound,
    LayoutGrid,
    ShieldCheck,
    Users,
} from '@lucide/vue';
import { computed } from 'vue';
import AppLogo from '@/components/AppLogo.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import permissions from '@/routes/permissions';
import roles from '@/routes/roles';
import users from '@/routes/users';
import type { NavItem } from '@/types';

const page = usePage();

const userPermissions = computed<string[]>(
    () => page.props.auth.permissions ?? [],
);

const hasPermission = (permission: string): boolean => {
    return userPermissions.value.includes(permission);
};

const mainNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [
        {
            title: 'Panel de Control',
            href: dashboard(),
            icon: LayoutGrid,
        },
    ];

    if (hasPermission('users.view')) {
        items.push({
            title: 'Usuarios',
            href: users.index(),
            icon: Users,
        });
    }

    if (hasPermission('roles.view')) {
        items.push({
            title: 'Roles',
            href: roles.index(),
            icon: ShieldCheck,
        });
    }

    if (hasPermission('permissions.view')) {
        items.push({
            title: 'Permisos',
            href: permissions.index(),
            icon: KeyRound,
        });
    }

    return items;
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>

    <slot />
</template>