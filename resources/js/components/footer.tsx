import { Link } from '@inertiajs/react';
import { contact, home, membership } from '@/routes';
import AppLogoIcon from '@/components/app-logo-icon';

export function Footer() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className="w-full border-t-4 border-black py-10 mt-auto">
            <div className="max-w-7xl mx-auto px-4 flex flex-col gap-8">
                <div className="flex flex-col lg:flex-row justify-between gap-8">
                    <div className="flex flex-col gap-3">
                        <Link href={home()} className="flex items-center gap-2 no-underline">
                            <AppLogoIcon className="size-8 text-[var(--foreground)] dark:text-white" />
                            <span className="font-bold text-lg">Le Retzien Libre</span>
                        </Link>
                        <p className="text-sm max-w-xs">
                            Une association locale pour un internet éthique, libre et respectueux.
                        </p>
                    </div>
                    <nav className="flex flex-col gap-3">
                        <span className="font-semibold">Navigation</span>
                        <Link href={home()} className="text-sm no-underline hover:underline">Accueil</Link>
                        <Link href={contact()} className="text-sm no-underline hover:underline">Contact</Link>
                        <Link href={membership()} className="text-sm no-underline hover:underline">Adhérer</Link>
                    </nav>
                </div>
                <div className="border-t border-black/20 pt-6 text-sm text-center">
                    &copy; {currentYear} Le Retzien Libre. Tous droits réservés.
                </div>
            </div>
        </footer>
    );
}
