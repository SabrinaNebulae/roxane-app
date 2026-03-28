import { Link, usePage } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { dashboard, register } from '@/routes';
import { type SharedData } from '@/types';
import illustrationImage from '@/img/utils/lrl-illustration.png';

export function AlternativeSection() {
    const { auth } = usePage<SharedData>().props;

    return (
        <section className="w-full py-16">
            <div className="max-w-7xl mx-auto px-4">
                <div className="flex flex-col lg:flex-row items-center gap-12">
                    <div className="flex flex-col gap-6 lg:w-1/2">
                        <h2 className="text-3xl font-bold">
                            Notre alternative : Le Retzien Libre
                        </h2>
                        <p>
                            Une association locale engagée pour la promotion du logiciel libre
                            et la protection de vos données personnelles.
                        </p>
                        {auth.user ? (
                            <Link href={dashboard()}>
                                <Button variant="default">Accéder à mon espace</Button>
                            </Link>
                        ) : (
                            <Link href={register()}>
                                <Button variant="default">Rejoignez-nous</Button>
                            </Link>
                        )}
                    </div>
                    <div className="lg:w-1/2 flex justify-center">
                        <img
                            src={illustrationImage}
                            alt="Le Retzien Libre"
                            className="rounded-lg max-w-md w-full"
                        />
                    </div>
                </div>
            </div>
        </section>
    );
}
