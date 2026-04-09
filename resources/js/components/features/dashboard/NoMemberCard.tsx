import { KeyRound } from 'lucide-react';
import { router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

export function NoMemberCard() {
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
