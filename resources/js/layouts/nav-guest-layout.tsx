import { useEffect, useState } from 'react';
import { Link, router, usePage } from '@inertiajs/react';
import { dashboard, home, login, logout, contact, membership } from '@/routes';
import AppLogoIcon from '@/components/app-logo-icon';
import { Button } from '@/components/ui/button';
import { type SharedData } from '@/types';
import { useMobileNavigation } from '@/hooks/use-mobile-navigation';
import { useAppearance } from '@/hooks/use-appearance';
import { Menu, Moon, Sun, X } from 'lucide-react';
import AppLogo from "@/components/app-logo";

export default function NavGuestLayout() {
    const { auth } = usePage<SharedData>().props;
    const cleanup = useMobileNavigation();
    const { appearance, updateAppearance } = useAppearance();
    const [isMenuOpen, setIsMenuOpen] = useState(false);

    const handleLogout = () => {
        cleanup();
        router.flushAll();
    };

    const toggleAppearance = () => {
        updateAppearance(appearance === 'dark' ? 'light' : 'dark');
    };

    const closeMenu = () => setIsMenuOpen(false);

    // Fermer sur navigation Inertia
    useEffect(() => {
        return router.on('navigate', closeMenu);
    }, []);

    // Fermer sur touche Escape
    useEffect(() => {
        const handleKeyDown = (e: KeyboardEvent) => {
            if (e.key === 'Escape') closeMenu();
        };
        document.addEventListener('keydown', handleKeyDown);
        return () => document.removeEventListener('keydown', handleKeyDown);
    }, []);

    // Bloquer le scroll quand menu ouvert
    useEffect(() => {
        document.body.style.overflow = isMenuOpen ? 'hidden' : '';
        return () => { document.body.style.overflow = ''; };
    }, [isMenuOpen]);

    return (
        <>
            <header className="flex justify-between items-center my-6 w-full max-w-[335px] lg:max-w-7xl text-sm">
                {/* Logo */}
                <Link href={home()} className="flex items-center gap-2 font-medium no-underline">
                    <div className="flex items-center justify-center rounded-md">
                        <AppLogo className="max-w-[200px] max-h-[42px] w-full h-auto" />
                    </div>
                    {/*@todo: gérer l'accessibilité de l'image'*/}
                    {/*<span className="font-bold text-black dark:text-white">Le Retzien Libre</span>*/}
                </Link>

                {/* Navigation desktop */}
                <nav className="hidden lg:flex items-center gap-1">
                    <Link href={home()} className="px-5 py-1.5 text-lg text-[#1b1b18] dark:text-[#EDEDEC] no-underline hover:underline">
                        Accueil
                    </Link>
                    <Link href="#services" className="px-5 py-1.5 text-lg text-[#1b1b18] dark:text-[#EDEDEC] no-underline hover:underline">
                        Nos Services
                    </Link>
                    <Link href="#" className="px-5 py-1.5 text-lg text-[#1b1b18] dark:text-[#EDEDEC] no-underline hover:underline">
                        Le Blog
                    </Link>
                    <Link href={contact()} className="px-5 py-1.5 text-lg text-[#1b1b18] dark:text-[#EDEDEC] no-underline hover:underline">
                        Contact
                    </Link>
                </nav>

                {/* Actions desktop */}
                <div className="hidden lg:flex items-center gap-3">

                    {auth.user ? (
                        <>
                            <Link href={dashboard()} className="no-underline">
                                <Button variant="outline">Tableau de bord</Button>
                            </Link>
                            <Link
                                href={logout()}
                                onClick={handleLogout}
                                className="border-3 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-2 transition delay-50 duration-200 ease-in-out font-bold no-underline"
                                data-test="logout-button"
                            >
                                Se déconnecter
                            </Link>
                        </>
                    ) : (
                        <>
                            <Link href={login()} className="no-underline">
                                <Button variant="outline">Se connecter</Button>
                            </Link>
                            <Link href={membership()} className="no-underline">
                                <Button variant="secondary">Adhérer</Button>
                            </Link>
                        </>
                    )}
                    <button
                        onClick={toggleAppearance}
                        className="border-3 bg-primary text-secondary-foreground hover:bg-primary/80 h-10 px-4 py-2 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-2 transition delay-50 duration-200 ease-in-out font-bold no-underline"
                        aria-label="Changer le thème"
                    >
                        {appearance === 'dark' ? <Sun className="size-4" /> : <Moon className="size-4" />}
                    </button>
                </div>

                {/* Actions mobile : thème + hamburger */}
                <div className="flex lg:hidden items-center gap-2">
                    <button
                        onClick={() => setIsMenuOpen(!isMenuOpen)}
                        className="border-3 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-2 transition delay-50 duration-200 ease-in-out font-bold no-underline"
                        aria-label={isMenuOpen ? 'Fermer le menu' : 'Ouvrir le menu'}
                        aria-expanded={isMenuOpen}
                    >
                        {isMenuOpen ? <X className="size-5" /> : <Menu className="size-5" />}
                    </button>
                    <button
                        onClick={toggleAppearance}
                        className="border-3 bg-primary text-secondary-foreground hover:bg-primary/80 h-10 px-4 py-2 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-2 transition delay-50 duration-200 ease-in-out font-bold no-underline"
                        aria-label="Changer le thème"
                    >
                        {appearance === 'dark' ? <Sun className="size-4" /> : <Moon className="size-4" />}
                    </button>
                </div>
            </header>

            {/* Menu mobile */}
            {isMenuOpen && (
                <>
                    {/* Backdrop */}
                    <div
                        className="fixed inset-0 z-40 bg-black/30 lg:hidden"
                        onClick={closeMenu}
                        aria-hidden="true"
                    />

                    {/* Panel */}
                    <div className="fixed inset-x-0 top-0 z-50 lg:hidden bg-[#F5F5F5] dark:bg-[#0a0a0a] border-b-4 border-black flex flex-col gap-6 p-6">
                        {/* En-tête du panel */}
                        <div className="flex justify-between items-center">
                            <Link href={home()} onClick={closeMenu} className="flex items-center gap-2 no-underline">
                                <AppLogoIcon className="size-8 text-[var(--foreground)] dark:text-white" />
                                <span className="font-bold text-black dark:text-white">Le Retzien Libre</span>
                            </Link>
                            <button
                                onClick={closeMenu}
                                className="p-2 rounded-md border border-black/20 dark:border-white/20 hover:bg-black/5 dark:hover:bg-white/5 transition"
                                aria-label="Fermer le menu"
                            >
                                <X className="size-5" />
                            </button>
                        </div>

                        {/* Liens de navigation */}
                        <nav className="flex flex-col">
                            <Link href={home()} onClick={closeMenu} className="text-lg py-3 border-b border-black/10 dark:border-white/10 no-underline">
                                <span className="text-black hover:underline">Accueil</span>
                            </Link>
                            <Link href="#services" onClick={closeMenu} className="text-lg py-3 border-b border-black/10 dark:border-white/10 no-underline">
                                <span className="text-black hover:underline">Nos Services</span>
                            </Link>
                            <Link href="#" onClick={closeMenu} className="text-lg py-3 border-b border-black/10 dark:border-white/10 no-underline">
                                <span className="text-black hover:underline">Le Blog</span>
                            </Link>
                            <Link href={contact()} onClick={closeMenu} className="text-lg py-3 no-underline">
                                <span className="text-black hover:underline">Contact</span>
                            </Link>
                        </nav>

                        {/* Boutons auth */}
                        <div className="flex flex-col gap-3">
                            {auth.user ? (
                                <>
                                    <Link href={dashboard()} onClick={closeMenu} className="no-underline mx-auto mb-4">
                                        <Button variant="outline" className="max-w-[150px]">Tableau de bord</Button>
                                    </Link>
                                    <Link
                                        href={logout()}
                                        method="post"
                                        as="button"
                                        onClick={() => { closeMenu(); handleLogout(); }}
                                        className="inline-flex items-center justify-center max-w-[150px] mx-auto gap-2 whitespace-nowrap rounded-md text-sm font-bold cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2 border-3 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-2 transition delay-50 duration-200 ease-in-out w-full no-underline"
                                        data-test="logout-button"
                                    >
                                        Se déconnecter
                                    </Link>
                                </>
                            ) : (
                                <>
                                    <Link href={login()} onClick={closeMenu} className="no-underline">
                                        <Button variant="outline" className="w-full">Se connecter</Button>
                                    </Link>
                                    <Link href={membership()} onClick={closeMenu} className="no-underline">
                                        <Button variant="secondary" className="w-full">Adhérer</Button>
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </>
            )}
        </>
    );
}
