import { useState } from 'react';
import { Cloud, ExternalLink, Globe, Layers, Mail, Megaphone, Share2 } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { type DashboardService } from '@/types';

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

const iconMap: Record<string, typeof Mail> = {
    envelope: Mail,
    share: Share2,
    cloud: Cloud,
    megaphone: Megaphone,
    'globe-alt': Globe,
};

const colorSchemes = [
    {
        card: 'bg-secondary',
        titleBg: 'bg-accent',
        titleText: 'text-accent-foreground',
        linkText: 'text-foreground',
        iconText: 'text-foreground/10',
    },
    {
        card: 'bg-primary',
        titleBg: 'bg-white',
        titleText: 'text-black',
        linkText: 'text-foreground',
        iconText: 'text-foreground/10',
    },
    {
        card: 'bg-accent',
        titleBg: 'bg-primary',
        titleText: 'text-primary-foreground',
        linkText: 'text-accent-foreground',
        iconText: 'text-white/10',
    },
];

interface Props {
    service: DashboardService;
    index: number;
    onRequest: (identifier: string) => void;
}

export function ServiceCard({ service, index, onRequest }: Props) {
    const [alreadyRequested, setAlreadyRequested] = useState(() =>
        getRequestedServices().includes(service.identifier),
    );

    const scheme = colorSchemes[index % colorSchemes.length];
    const Icon = iconMap[service.icon ?? ''] ?? Layers;

    function handleRequest() {
        markServiceRequested(service.identifier);
        setAlreadyRequested(true);
        onRequest(service.identifier);
    }

    return (
        <div className={cn('nb-shadow flex items-center gap-4 rounded-4xl p-10', scheme.card)}>
            <div className="flex flex-col gap-3 flex-1 min-w-0">
                <div className="max-w-[200px]">
                    <h3 className={cn('inline text-2xl font-semibold rounded p-1 line-clamp-2', scheme.titleBg, scheme.titleText)}>
                        {service.name}
                    </h3>
                </div>
                {service.description && (
                    <p className="text-sm text-muted-foreground mt-2">{service.description}</p>
                )}
                <div className="mt-2">
                    {service.is_active ? (
                        <a
                            href={service.url}
                            target="_blank"
                            rel="noopener noreferrer"
                            className={cn('inline-flex items-center gap-1.5 text-sm font-medium underline hover:no-underline', scheme.linkText)}
                        >
                            Accéder au service <ExternalLink className="size-3.5" />
                        </a>
                    ) : (
                        <Button
                            variant="outline"
                            size="sm"
                            disabled={alreadyRequested}
                            onClick={handleRequest}
                            className="text-xs"
                        >
                            {alreadyRequested ? 'Demande envoyée' : "Demander l'activation"}
                        </Button>
                    )}
                </div>
            </div>
            <div className={cn('shrink-0', scheme.iconText)}>
                <Icon className="size-32" />
            </div>
        </div>
    );
}
