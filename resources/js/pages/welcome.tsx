import { Head } from '@inertiajs/react';
import NavGuestLayout from '@/layouts/nav-guest-layout';
import { HeroSection } from '@/components/features/home/HeroSection';
import { ServicesSection } from '@/components/features/home/ServicesSection';
import { AboutSection } from '@/components/features/home/AboutSection';
import { AlternativeSection } from '@/components/features/home/AlternativeSection';
import { Footer } from '@/components/footer';
import { ScrollToTop } from '@/components/common/ScrollToTop';

export default function Welcome() {
    return (
        <>
            <Head title="Bienvenue sur le site du Retzien Libre" />
            <div className="flex flex-col min-h-screen bg-white text-[#1b1b18] dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
                <div className="flex flex-col items-center px-4">
                    <NavGuestLayout />
                </div>
                <main className="flex flex-col items-center">
                    <HeroSection />
                    <ServicesSection />
                    <AlternativeSection />
                    <AboutSection />
                </main>
                <Footer />
            </div>
            <ScrollToTop />
        </>
    );
}
