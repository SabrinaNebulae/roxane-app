import { InertiaLinkProps } from '@inertiajs/react';
import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    two_factor_enabled?: boolean;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface FlashMessages {
    success?: string;
    error?: string;
    warning?: string;
    info?: string;
}

export interface Plans {
    id: number;
    identifier: string;
    name: string;
    price: number;
    description?: string;
    months?: number | null;
}

export interface MembershipService {
    name: string;
    description: string;
}


export interface Service {
    title: string;
    colorTitle: string;
    bgTitle: string;
    bgColor: string;
    descriptionColor: string;
    description: string;
    link: string;
    illustration: string;
}

export interface DashboardService {
    identifier: string;
    name: string;
    description: string | null;
    url: string;
    icon: string | null;
    is_active: boolean;
}

export interface DashboardPackage {
    identifier: string;
    name: string;
    description: string | null;
    price: string;
}

export interface DashboardMembership {
    status: string;
    payment_status: string;
    start_date: string | null;
    end_date: string | null;
    amount: string;
    package: DashboardPackage | null;
    services: DashboardService[];
}

export interface DashboardMember {
    firstname: string | null;
    lastname: string | null;
    email: string;
    retzien_email: string;
    membership: DashboardMembership | null;
}

export interface PageProps {
    flash?: FlashMessages;
    auth?: Auth;
    plans?: Plans[];
    services?: MembershipService[];
    captcha_question?: string;
    member?: DashboardMember | null;

    [key: string]: unknown;
}

