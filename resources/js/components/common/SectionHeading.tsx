import {cn} from '@/lib/utils';

interface SectionHeadingProps {
    title: string;
    color?: string;
    subtitle?: string;
    align?: 'left' | 'center';
    className?: string;
}

export function SectionHeading({title, color, subtitle, align = 'center', className}: SectionHeadingProps) {
    return (
        <div className={cn(
            'flex gap-10 items-center ',
            align === 'center' && 'text-center',
            align === 'left' && 'text-left',
            className,
        )}>
            <h2 className={`text-3xl text-black font-medium bg-${color} rounded p-1`}>
                {title}
            </h2>
            {subtitle && (
                <p className="text-md text-muted-foreground max-w-2xl">{subtitle}</p>
            )}
        </div>
    );
}
