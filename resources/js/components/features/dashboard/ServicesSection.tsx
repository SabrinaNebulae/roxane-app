import { Loader2 } from 'lucide-react';
import { type DashboardService } from '@/types';
import { ServiceCard } from './ServiceCard';

interface Props {
    services: DashboardService[];
    submitting: boolean;
    onRequest: (identifier: string) => void;
}

export function ServicesSection({ services, submitting, onRequest }: Props) {
    return (
        <div className="flex flex-col gap-4">
            <h2 className="text-lg font-semibold">Vos services</h2>
            {submitting && (
                <div className="flex items-center gap-2 text-sm text-muted-foreground">
                    <Loader2 className="size-4 animate-spin" /> Envoi en cours…
                </div>
            )}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {services.map((service, index) => (
                    <ServiceCard
                        key={service.identifier}
                        service={service}
                        index={index}
                        onRequest={onRequest}
                    />
                ))}
            </div>
        </div>
    );
}
