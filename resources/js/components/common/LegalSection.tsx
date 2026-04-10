import { type ReactNode } from 'react';

interface Props {
    heading: string;
    children: ReactNode;
}

export function LegalSection({ heading, children }: Props) {
    return (
        <section className="flex flex-col gap-3">
            <h2 className="text-xl font-semibold text-accent border-b border-accent/20 pb-2">
                {heading}
            </h2>
            <div className="text-sm leading-relaxed text-foreground flex flex-col gap-2">
                {children}
            </div>
        </section>
    );
}
