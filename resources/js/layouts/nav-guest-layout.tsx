import {Link, router, usePage} from "@inertiajs/react";
import {dashboard, home, login, logout, register, contact, membership} from "@/routes";
import AppLogoIcon from "@/components/app-logo-icon";
import {Button} from "@/components/ui/button";
import type {SharedData} from "@/types";
import {useMobileNavigation} from "@/hooks/use-mobile-navigation";
import {LogOut} from "lucide-react";
import React, {useEffect, useState} from "react";

export default function NavGuestLayout() {
    const {auth} = usePage<SharedData>().props;

    const cleanup = useMobileNavigation();
    const handleLogout = () => {
        cleanup();
        router.flushAll();
    };

    const [dark, setDark] = useState(false);

    useEffect(() => {
        if (dark) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    }, [dark]);

    return (
        <>
            <header
                className="flex  justify-between my-6 w-full max-w-[335px]  text-sm not-has-[nav]:hidden lg:max-w-7xl">
                <div className="flex items-center justify-start">
                    <Link
                        href={home()}
                        className="flex items-center justify-start gap-2 font-medium no-underline"
                    >
                        <div className="mb-1 flex h-9 w-9 items-center justify-center rounded-md">
                            <AppLogoIcon className="size-9  text-[var(--foreground)] dark:text-white"/>
                        </div>
                        <h1 className="text-black">Le Retzien Libre</h1>
                    </Link>
                </div>
                <nav className="flex items-center justify-end gap-4">
                    <Link
                        href={home()}
                        className="inline-block px-5 py-1.5 text-lg leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b] no-underline"
                    >
                        Accueil
                    </Link>
                    <Link
                        href="#"
                        className="inline-block px-5 py-1.5 text-lg leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b] no-underline"
                    >
                        Nos Services
                    </Link>
                    <Link
                        href="#"
                        className="inline-block px-5 py-1.5 text-lg leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b] no-underline"
                    >
                        Le Blog
                    </Link>
                    <Link
                        href={contact()}
                        className="inline-block px-5 py-1.5 text-lg leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b] no-underline"
                    >
                        Contact
                    </Link>
                </nav>
                <nav className="flex items-center justify-end gap-4">
                    {auth.user ? (
                        <>
                            <Link
                                href={dashboard()}
                                className=" no-underline"
                            >
                                <Button variant="outline">Tableau de bord</Button>
                            </Link>

                            <Link
                                className="border-3 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2 shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-2 transition delay-50 duration-200 ease-in-out font-bold"
                                href={logout()}
                                onClick={handleLogout}
                                data-test="logout-button"
                            >
                                Se déconnecter
                            </Link>
                        </>
                    ) : (
                        <>
                            <Link
                                href={login()}
                            >
                                <Button variant="outline">Se connecter</Button>
                            </Link>
                            <Link
                                href={membership()}
                            >
                                <Button>Adhérer</Button>
                            </Link>
                        </>
                    )}
                </nav>
                <button
                    onClick={() => setDark(!dark)}
                    className="absolute top-4 right-4 px-3 py-1 rounded-xl border border-gray-400 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-800 transition"
                >
                    {dark ? "☀️ Mode clair" : "🌙 Mode sombre"}
                </button>
            </header>
        </>
    )
}
