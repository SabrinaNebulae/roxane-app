import { Link, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { dashboard, register } from '@/routes';
import { type SharedData } from '@/types';
import IllustrationLogo from '@/img/utils/lrl-logo-full.svg';

export function AlternativeSection() {
    const { auth } = usePage<SharedData>().props;

    return (
        <section id="alternative" className="w-full py-16">
            <div className="bg-gray-100 rounded-4xl max-w-7xl mx-auto px-4">
                <div className="flex flex-col lg:flex-row items-center gap-12">
                    <div className="lg:w-1/2 flex justify-center">
                        <img
                            src={IllustrationLogo}
                            alt="Le Retzien Libre"
                            className="rounded-lg max-w-md w-full"
                        />
                    </div>
                    <div className="flex flex-col gap-6 lg:w-1/2">
                        <h2 className="text-3xl text-black font-medium">
                            Notre alternative : Le Retzien Libre
                        </h2>
                        <p>
                            Ici, pas d’exploitation des vos données personnelles à des fins commerciales, ni de dépense aux services centralisés.<br/>
                            Le Retzien Libre, c’est une association locale engagée pour la promotion du logiciel libre et la protection de vos données personnelles.
                        </p>
                        {auth.user ? (
                            <Link href={dashboard()}>
                                <Button variant="default">Accéder à mon espace</Button>
                            </Link>
                        ) : (
                            <Link href={register()}>
                                <Button variant="secondary">Rejoignez-nous</Button>
                            </Link>
                        )}
                    </div>
                </div>
            </div>
        </section>
    );
}
