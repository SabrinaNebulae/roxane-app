import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type PageProps } from '@/types';
import { Head, router, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import DashboardController from '@/actions/App/Http/Controllers/DashboardController';
import { FlashMessage } from '@/components/flash-message';
import { WelcomeCard } from '@/components/features/dashboard/WelcomeCard';
import { NoMemberCard } from '@/components/features/dashboard/NoMemberCard';
import { ServicesSection } from '@/components/features/dashboard/ServicesSection';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tableau de bord',
        href: DashboardController.index().url,
    },
];

export default function Dashboard() {
    const { flash, member } = usePage<PageProps>().props;
    const [showFlash, setShowFlash] = useState(!!flash);
    const [submitting, setSubmitting] = useState(false);

    useEffect(() => {
        if (flash) {
            setShowFlash(true);
            const timer = setTimeout(() => setShowFlash(false), 5000);
            return () => clearTimeout(timer);
        }
    }, [flash]);

    function handleActivationRequest(identifier: string) {
        setSubmitting(true);
        router.post(
            DashboardController.requestServiceActivation().url,
            { service_identifier: identifier },
            {
                preserveScroll: true,
                onFinish: () => setSubmitting(false),
            },
        );
    }

    const membership = member?.membership ?? null;
    const services = membership?.services ?? [];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Tableau de bord" />

            <div className="flex flex-col gap-6 p-4 md:p-6">
                {showFlash && flash && <FlashMessage messages={flash} />}

                {member ? (
                    <>
                        <WelcomeCard member={member} />

                        {services.length > 0 && (
                            <ServicesSection
                                services={services}
                                submitting={submitting}
                                onRequest={handleActivationRequest}
                            />
                        )}

                        {services.length === 0 && membership && (
                            <div className="nb-shadow-static bg-white dark:bg-[#171717] rounded-2xl p-6 text-center text-muted-foreground text-sm">
                                Aucun service associé à votre adhésion pour le moment.
                            </div>
                        )}

                        {!membership && (
                            <div className="nb-shadow-static bg-white dark:bg-[#171717] rounded-2xl p-6 text-center text-muted-foreground text-sm">
                                Votre demande d'adhésion est en cours de traitement.
                            </div>
                        )}
                    </>
                ) : (
                    <NoMemberCard />
                )}
            </div>
        </AppLayout>
    );
}
