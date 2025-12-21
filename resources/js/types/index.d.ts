import { InertiaLinkProps, PageProps as InertiaPageProps } from '@inertiajs/vue3';
import { type ZiggyConfig } from 'ziggy-js';
import type { LucideIcon } from 'lucide-vue-next';

// Add Ziggy route function definition
declare global {
    var route: (name?: string, params?: any, absolute?: boolean, config?: ZiggyConfig) => string;
}

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
