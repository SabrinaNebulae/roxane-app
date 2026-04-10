import {Link} from '@inertiajs/react';
import {contact, home, membership} from '@/routes';
import AppLogoIcon from '@/components/app-logo-icon';

export function Footer() {
    const currentYear = new Date().getFullYear();

    return (
            <footer className="gap-10 bg-accent dark:bg-primary rounded-t-4xl text-white py-10 px-20 mt-auto mx-5">
                <div className="max-w-7xl mx-auto px-4 flex flex-col gap-8">
                    <div className="flex flex-col lg:flex-row justify-between gap-8">
                        <div className="flex flex-col gap-3">
                            <Link href={home()} className="flex items-center gap-2 no-underline">
                                <AppLogoIcon variant="white" className="size-8" />
                                <span className="font-bold text-white text-lg">Le Retzien Libre</span>
                            </Link>
                            <p className="text-sm max-w-xs">
                                Une association locale pour un internet éthique, libre et respectueux.
                            </p>
                        </div>
                        <nav className="flex flex-col gap-3">
                            <span className="font-semibold">Navigation</span>
                            <Link href={home()} className="text-sm text-white no-underline hover:underline">Accueil</Link>
                            <Link href={contact()} className="text-sm text-white no-underline hover:underline">Contact</Link>
                            <Link href={membership()} className="text-sm text-white no-underline hover:underline">Adhérer</Link>
                        </nav>
                    </div>
                    <div className="flex justify-between border-t border-black/20 pt-6 text-sm text-center">
                        <div className="text-left">
                            &copy; {currentYear} Le Retzien Libre. Tous droits réservés.
                        </div>
                        <div className="flex items-stretch text-right">
                            <Link href="/mentions-legales" className="text-sm text-white underline mx-4 hover:no-underline">Mentions légales</Link>
                            <Link href="/conditions-generales" className="text-sm text-white underline mx-4 hover:no-underline">CGU</Link>
                            <Link href="/confidentialite" className="text-sm text-white underline mx-4 hover:no-underline">Confidentialité</Link>
                        </div>

                    </div>
                </div>
            </footer>
    );
}
