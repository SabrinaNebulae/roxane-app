import { type DashboardMember } from '@/types';
import { cn } from '@/lib/utils';

interface Props {
    member: DashboardMember;
}

export function WelcomeCard({ member }: Props) {
    const membership = member.membership;

    return (
        <>
            <div>
                <p className="text-2xl text-black font-medium tracking-wide">
                    Bienvenue sur votre espace Retzien, {member.firstname}
                </p>
            </div>
            <div className="nb-shadow-static bg-white rounded-2xl p-6 flex flex-col gap-2">
                <h1 className="text-2xl font-bold">
                    {member.firstname} {member.lastname}
                </h1>
                <p className="text-sm text-muted-foreground">{member.retzien_email || member.email}</p>

                {membership ? (
                    <div className="mt-3 flex flex-wrap gap-4 text-sm">
                        <span className="inline-flex items-center gap-1.5 rounded-full bg-secondary/20 text-secondary-foreground px-3 py-1 font-medium border border-secondary/40">
                            {membership.package?.name ?? 'Adhésion'}
                        </span>
                        <span
                            className={cn(
                                'inline-flex items-center gap-1.5 rounded-full px-3 py-1 font-medium border',
                                membership.status === 'active'
                                    ? 'bg-green-100 text-green-800 border-green-300 dark:bg-green-900/20 dark:text-green-400 dark:border-green-700'
                                    : 'bg-orange-100 text-orange-800 border-orange-300 dark:bg-orange-900/20 dark:text-orange-400 dark:border-orange-700',
                            )}
                        >
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
        </>
    );
}
