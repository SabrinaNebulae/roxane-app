import { type ReactNode } from 'react';
import { Head } from '@inertiajs/react';
import NavGuestLayout from '@/layouts/nav-guest-layout';
import { Footer } from '@/components/footer';

interface Props {
    title: string;
    description?: string;
    children: ReactNode;
}

export function LegalLayout({ title, description, children }: Props) {
    return (
        <>
            <Head title={title} />
            <div className="flex flex-col min-h-screen bg-white text-[#1b1b18]">
                <div className="flex flex-col items-center px-4">
                    <NavGuestLayout />
                </div>
                <main className="flex-1 w-full max-w-3xl mx-auto px-6 py-16">
                    <div className="mb-12">
                        <h1 className="text-4xl font-bold text-accent">{title}</h1>
                        {description && (
                            <p className="mt-3 text-muted-foreground">{description}</p>
                        )}
                    </div>
                    <div className="flex flex-col gap-10">
                        {children}
                    </div>
                </main>
                <Footer />
            </div>
        </>
    );
}
