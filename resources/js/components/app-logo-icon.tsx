import { ImgHTMLAttributes } from 'react';
import { cn } from '@/lib/utils';
import logoDark from '@/img/utils/logo-icon.svg';
import logoWhite from '@/img/utils/logo-icon-white.svg';

interface Props extends ImgHTMLAttributes<HTMLImageElement> {
    variant?: 'dark' | 'white';
}

export default function AppLogoIcon({ variant = 'dark', className, alt = '', ...props }: Props) {
    const src = variant === 'white' ? logoWhite : logoDark;

    return <img src={src} alt={alt} className={cn('object-contain', className)} {...props} />;
}
