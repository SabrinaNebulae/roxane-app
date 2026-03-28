import { Link, usePage } from '@inertiajs/react';
import { ChevronDown } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { dashboard, membership } from '@/routes';
import { type SharedData } from '@/types';
import illustrationImage from '@/img/utils/lrl-illustration.png';

export function HeroSection() {
    const { auth } = usePage<SharedData>().props;

    const scrollToFirstSection = () => {
        document.getElementById('first-section')?.scrollIntoView({ behavior: 'smooth' });
    };

    return (
        <section
            id="hero"
            className="flex flex-col w-full max-w-[335px] lg:max-w-7xl mx-auto min-h-[calc(100vh-80px)] px-4"
        >
            {/* Contenu principal */}
            <div className="flex flex-1 items-center justify-center gap-4 w-full">
                <div className="flex flex-col w-full items-center text-center lg:items-start lg:text-left justify-center gap-4">
                    <h1 className="text-5xl text-accent max-w-[450px] mb-5">
                        Pour un internet éthique !
                    </h1>
                    <p className="text-xl mb-5">
                        "Dégooglisons"<br />
                        nos ordinateurs, nos tablettes et nos smartphones.<br />
                        <i>"Le chemin est long, mais la voie est libre"</i>
                    </p>
                    {auth.user ? (
                        <Link href={dashboard()}>
                            <Button variant="secondary">Mon espace</Button>
                        </Link>
                    ) : (
                        <Link href={membership()}>
                            <Button variant="secondary">Adhérer dès maintenant</Button>
                        </Link>
                    )}
                </div>
                <div className="hidden lg:flex w-full items-center justify-center">
                    <img src={illustrationImage} alt="Illustration Le Retzien Libre" className="max-w-md w-full" />
                </div>
            </div>

            {/* Flèche vers la première section */}
            <div className="flex justify-center pb-8">
                <button
                    onClick={scrollToFirstSection}
                    aria-label="Voir nos services"
                    className="p-2 rounded-full border-3 border-black animate-bounce hover:animate-none transition"
                >
                    <ChevronDown className="size-6" />
                </button>
            </div>
        </section>
    );
}
