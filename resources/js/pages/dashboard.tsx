import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type DashboardMember, type DashboardService, type PageProps } from '@/types';
import { Head, router, usePage } from '@inertiajs/react';
import DashboardController from '@/actions/App/Http/Controllers/DashboardController';
import { ExternalLink, KeyRound, Loader2 } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { FlashMessage } from '@/components/flash-message';
import { useEffect, useState } from 'react';
import { cn } from '@/lib/utils';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tableau de bord',
        href: DashboardController.index().url,
    },
];

const ACTIVATION_REQUESTED_KEY = 'service_activation_requested';

function getRequestedServices(): string[] {
    try {
        return JSON.parse(localStorage.getItem(ACTIVATION_REQUESTED_KEY) ?? '[]');
    } catch {
        return [];
    }
}

function markServiceRequested(identifier: string): void {
    const current = getRequestedServices();
    if (!current.includes(identifier)) {
        localStorage.setItem(ACTIVATION_REQUESTED_KEY, JSON.stringify([...current, identifier]));
    }
}

function WelcomeCard({ member }: { member: DashboardMember }) {
    const membership = member.membership;

    return (
        <div className="nb-shadow-static bg-primary rounded-2xl p-6 flex flex-col gap-2">
            <p className="text-sm text-muted-foreground font-medium uppercase tracking-wide">Bienvenue</p>
            <h1 className="text-2xl font-bold">
                {member.firstname} {member.lastname}
            </h1>
            <p className="text-sm text-muted-foreground">{member.retzien_email || member.email}</p>

            {membership ? (
                <div className="mt-3 flex flex-wrap gap-4 text-sm">
                    <span className="inline-flex items-center gap-1.5 rounded-full bg-secondary/20 text-secondary-foreground px-3 py-1 font-medium border border-secondary/40">
                        {membership.package?.name ?? 'Adhésion'}
                    </span>
                    <span className={cn(
                        'inline-flex items-center gap-1.5 rounded-full px-3 py-1 font-medium border',
                        membership.status === 'active'
                            ? 'bg-green-100 text-green-800 border-green-300 dark:bg-green-900/20 dark:text-green-400 dark:border-green-700'
                            : 'bg-orange-100 text-orange-800 border-orange-300 dark:bg-orange-900/20 dark:text-orange-400 dark:border-orange-700',
                    )}>
                        {membership.status === 'active' ? 'Actif' : 'En attente'}
                    </span>
                    {membership.end_date && (
                        <span className="text-muted-foreground">
                            Valide jusqu'au {new Date(membership.end_date).toLocaleDateString('fr-FR')}
                        </span>
                    )}
                </div>
            ) : (
                <p className="mt-2 text-sm text-muted-foreground">Aucune adhésion active.</p>
            )}
        </div>
    );
}

function NoMemberCard() {
    return (
        <div className="nb-shadow-static bg-white dark:bg-[#171717] rounded-2xl p-8 flex flex-col items-center gap-4 text-center max-w-lg mx-auto">
            <KeyRound className="size-10 text-primary" />
            <h2 className="text-xl font-bold">Pas encore membre ?</h2>
            <p className="text-muted-foreground text-sm">
                Votre compte n'est pas encore associé à une adhésion. Rejoignez l'association pour accéder aux services.
            </p>
            <Button variant="secondary" className="nb-shadow" onClick={() => router.visit('/formulaires/adhesion')}>
                Adhérer au Retzien Libre
            </Button>
        </div>
    );
}

function ServiceCard({ service, onRequest }: { service: DashboardService; onRequest: (identifier: string) => void }) {
    const [alreadyRequested, setAlreadyRequested] = useState(() =>
        getRequestedServices().includes(service.identifier),
    );

    function handleRequest() {
        markServiceRequested(service.identifier);
        setAlreadyRequested(true);
        onRequest(service.identifier);
    }

    return (
        <div className={cn(
            'nb-shadow-static bg-white dark:bg-[#171717] rounded-2xl p-5 flex flex-col gap-3',
            !service.is_active && 'opacity-80',
        )}>
            <div className="flex items-start justify-between gap-2">
                <div>
                    <h3 className="font-semibold text-base">{service.name}</h3>
                    {service.description && (
                        <p className="text-xs text-muted-foreground mt-0.5">{service.description}</p>
                    )}
                </div>
                <span className={cn(
                    'shrink-0 text-xs rounded-full px-2 py-0.5 font-medium border',
                    service.is_active
                        ? 'bg-green-100 text-green-800 border-green-300 dark:bg-green-900/20 dark:text-green-400 dark:border-green-700'
                        : 'bg-gray-100 text-gray-600 border-gray-300 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600',
                )}>
                    {service.is_active ? 'Actif' : 'Inactif'}
                </span>
            </div>

            {service.is_active ? (
                <a
                    href={service.url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:underline"
                >
                    Accéder au service <ExternalLink className="size-3.5" />
                </a>
            ) : (
                <Button
                    variant="outline"
                    size="sm"
                    disabled={alreadyRequested}
                    onClick={handleRequest}
                    className="self-start text-xs"
                >
                    {alreadyRequested ? 'Demande envoyée' : 'Demander l\'activation'}
                </Button>
            )}
        </div>
    );
}

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
                            <div className="flex flex-col gap-4">
                                <h2 className="text-lg font-semibold">Vos services</h2>
                                {submitting && (
                                    <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                        <Loader2 className="size-4 animate-spin" /> Envoi en cours…
                                    </div>
                                )}
                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    {services.map((service) => (
                                        <ServiceCard
                                            key={service.identifier}
                                            service={service}
                                            onRequest={handleActivationRequest}
                                        />
                                    ))}
                                </div>
                            </div>
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
