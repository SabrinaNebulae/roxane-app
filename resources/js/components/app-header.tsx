import { Breadcrumbs } from '@/components/breadcrumbs';
import { Icon } from '@/components/icon';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuList,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu';
import { UserMenuContent } from '@/components/user-menu-content';
import { useAppearance } from '@/hooks/use-appearance';
import { useInitials } from '@/hooks/use-initials';
import { useMobileNavigation } from '@/hooks/use-mobile-navigation';
import { cn } from '@/lib/utils';
import { dashboard, logout } from '@/routes';
import { type BreadcrumbItem, type NavItem, type SharedData } from '@/types';
import { Link, router, usePage } from '@inertiajs/react';
import { LayoutGrid, LogOut, Menu, Moon, Settings, Sun, X } from 'lucide-react';
import { useEffect, useState } from 'react';
import AppLogo from './app-logo';
import AppLogoIcon from './app-logo-icon';

const mainNavItems: NavItem[] = [
    {
        title: 'Tableau de Bord',
        href: dashboard(),
        icon: LayoutGrid,
    },
];

interface AppHeaderProps {
    breadcrumbs?: BreadcrumbItem[];
}

export function AppHeader({ breadcrumbs = [] }: AppHeaderProps) {
    const page = usePage<SharedData>();
    const { auth } = page.props;
    const getInitials = useInitials();
    const cleanup = useMobileNavigation();
    const { appearance, updateAppearance } = useAppearance();
    const [isMenuOpen, setIsMenuOpen] = useState(false);

    const toggleAppearance = () => {
        updateAppearance(appearance === 'dark' ? 'light' : 'dark');
    };

    const closeMenu = () => setIsMenuOpen(false);

    const handleLogout = () => {
        cleanup();
        router.flushAll();
    };

    useEffect(() => {
        return router.on('navigate', closeMenu);
    }, []);

    useEffect(() => {
        const handleKeyDown = (e: KeyboardEvent) => {
            if (e.key === 'Escape') closeMenu();
        };
        document.addEventListener('keydown', handleKeyDown);
        return () => document.removeEventListener('keydown', handleKeyDown);
    }, []);

    useEffect(() => {
        document.body.style.overflow = isMenuOpen ? 'hidden' : '';
        return () => { document.body.style.overflow = ''; };
    }, [isMenuOpen]);

    return (
        <>
            <div className="border-b border-border bg-background">
                <div className="mx-auto flex h-16 items-center px-4 md:max-w-7xl">

                    {/* Logo */}
                    <Link href={dashboard()} prefetch className="flex items-center no-underline text-foreground">
                        <AppLogo className="h-8 w-auto max-w-[180px]" />
                    </Link>

                    {/* Desktop nav */}
                    <div className="ml-6 hidden h-full items-center lg:flex">
                        <NavigationMenu className="flex h-full items-stretch">
                            <NavigationMenuList className="flex h-full items-stretch gap-1">
                                {mainNavItems.map((item, index) => (
                                    <NavigationMenuItem key={index} className="relative flex h-full items-center">
                                        <Link
                                            href={item.href}
                                            className={cn(
                                                navigationMenuTriggerStyle(),
                                                'h-9 cursor-pointer px-3 text-foreground no-underline',
                                                page.url === (typeof item.href === 'string' ? item.href : item.href.url) &&
                                                    'font-semibold',
                                            )}
                                        >
                                            {item.icon && <Icon iconNode={item.icon} className="mr-2 h-4 w-4" />}
                                            {item.title}
                                        </Link>
                                        {page.url === (typeof item.href === 'string' ? item.href : item.href.url) && (
                                            <div className="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-primary" />
                                        )}
                                    </NavigationMenuItem>
                                ))}
                            </NavigationMenuList>
                        </NavigationMenu>
                    </div>

                    {/* Right actions */}
                    <div className="ml-auto flex items-center gap-2">
                        {/* Theme toggle — desktop only */}
                        <button
                            onClick={toggleAppearance}
                            className="hidden lg:flex nb-shadow bg-primary text-secondary-foreground hover:bg-primary/80 h-10 px-4 py-2 font-bold"
                            aria-label="Changer le thème"
                        >
                            {appearance === 'dark' ? <Sun className="size-4" /> : <Moon className="size-4" />}
                        </button>

                        {/* Avatar dropdown — always visible */}
                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="secondary" className="size-10 rounded-full mr-2">
                                    <Avatar className="size-8 overflow-hidden rounded-full">
                                        <AvatarFallback className="rounded-full bg-secondary text-secondary-foreground font-semibold text-sm">
                                            {getInitials(auth.user.name)}
                                        </AvatarFallback>
                                    </Avatar>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent className="w-56" align="end">
                                <UserMenuContent user={auth.user} />
                            </DropdownMenuContent>
                        </DropdownMenu>

                        {/* Hamburger — mobile only */}
                        <button
                            onClick={() => setIsMenuOpen(!isMenuOpen)}
                            className="flex lg:hidden nb-shadow bg-primary text-secondary-foreground hover:bg-primary/80 h-10 px-4 py-2 font-bold"
                            aria-label={isMenuOpen ? 'Fermer le menu' : 'Ouvrir le menu'}
                            aria-expanded={isMenuOpen}
                        >
                            {isMenuOpen ? <X className="size-5" /> : <Menu className="size-5" />}
                        </button>
                    </div>
                </div>
            </div>

            {/* Mobile menu */}
            {isMenuOpen && (
                <>
                    <div
                        className="fixed inset-0 z-40 bg-black/30 lg:hidden"
                        onClick={closeMenu}
                        aria-hidden="true"
                    />
                    <div className="fixed inset-x-0 top-0 z-50 lg:hidden bg-[#F5F5F5] dark:bg-[#0a0a0a] border-b-4 border-black flex flex-col gap-6 p-6">
                        {/* Header du panel */}
                        <div className="flex justify-between items-center">
                            <Link href={dashboard()} onClick={closeMenu} className="flex items-center gap-2 no-underline text-foreground">
                                <AppLogoIcon className="size-8" />
                                <span className="font-bold text-foreground">Le Retzien Libre</span>
                            </Link>
                            <button
                                onClick={closeMenu}
                                className="p-2 rounded-md border border-black/20 dark:border-white/20 hover:bg-black/5 dark:hover:bg-white/5 transition"
                                aria-label="Fermer le menu"
                            >
                                <X className="size-5" />
                            </button>
                        </div>

                        {/* Nav links */}
                        <nav className="flex flex-col">
                            {mainNavItems.map((item) => (
                                <Link
                                    key={item.title}
                                    href={item.href}
                                    onClick={closeMenu}
                                    className="flex items-center gap-2 text-lg py-3 border-b border-black/10 dark:border-white/10 no-underline text-foreground hover:underline"
                                >
                                    {item.icon && <Icon iconNode={item.icon} className="size-5" />}
                                    <span>{item.title}</span>
                                </Link>
                            ))}
                        </nav>

                        {/* Theme toggle */}
                        <button
                            onClick={toggleAppearance}
                            className="flex items-center gap-2 text-lg py-3 border-b border-black/10 dark:border-white/10 text-foreground hover:underline w-full"
                            aria-label="Changer le thème"
                        >
                            {appearance === 'dark' ? <Sun className="size-5" /> : <Moon className="size-5" />}
                            <span>{appearance === 'dark' ? 'Mode clair' : 'Mode sombre'}</span>
                        </button>

                        {/* User actions */}
                        <div className="flex flex-col gap-3">
                            <div className="flex items-center gap-3 py-2 border-b border-black/10 dark:border-white/10">
                                <Avatar className="size-8 rounded-full">
                                    <AvatarFallback className="rounded-full bg-secondary text-secondary-foreground font-semibold text-sm">
                                        {getInitials(auth.user.name)}
                                    </AvatarFallback>
                                </Avatar>
                                <div className="flex flex-col">
                                    <span className="text-sm font-semibold text-foreground">{auth.user.name}</span>
                                    <span className="text-xs text-muted-foreground">{auth.user.email}</span>
                                </div>
                            </div>
                            <Link
                                href="/profile/edit"
                                onClick={closeMenu}
                                className="flex items-center gap-2 text-lg py-3 border-b border-black/10 dark:border-white/10 no-underline text-foreground hover:underline"
                            >
                                <Settings className="size-5" />
                                <span>Paramètres</span>
                            </Link>
                            <Link
                                href={logout()}
                                method="post"
                                as="button"
                                onClick={() => { closeMenu(); handleLogout(); }}
                                className="flex bg-primary items-center gap-2 text-lg py-3 no-underline text-foreground hover:underline border-black border-3 shadow-[4px_4px_0px_rgba(0,0,0,1)]"
                                data-test="logout-button"
                            >
                                <LogOut className="size-5" />
                                <span>Se déconnecter</span>
                            </Link>
                        </div>
                    </div>
                </>
            )}

            {breadcrumbs.length > 1 && (
                <div className="flex w-full border-b border-border">
                    <div className="mx-auto flex h-12 w-full items-center justify-start px-4 text-muted-foreground md:max-w-7xl">
                        <Breadcrumbs breadcrumbs={breadcrumbs} />
                    </div>
                </div>
            )}
        </>
    );
}
