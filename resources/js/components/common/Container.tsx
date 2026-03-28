import { cn } from '@/lib/utils';
import React from "react";

export function Container({ className, ...props }: React.ComponentProps<'div'>) {
    return (
        <div className={cn('w-full max-w-7xl mx-auto px-4', className)} {...props} />
    );
}
