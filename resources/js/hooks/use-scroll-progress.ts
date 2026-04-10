import { useEffect, useState } from 'react';

export function useScrollProgress(elementId: string): number {
    const [progress, setProgress] = useState(0);

    useEffect(() => {
        let rafId: number;
        let ticking = false;

        const update = () => {
            const el = document.getElementById(elementId);
            if (!el) {
                ticking = false;
                return;
            }

            const scrollY = window.scrollY;
            const elTop = el.offsetTop;
            const elHeight = el.offsetHeight;
            const computed = Math.max(0, Math.min(1, (scrollY - elTop) / elHeight));

            setProgress(computed);
            ticking = false;
        };

        const onScroll = () => {
            if (!ticking) {
                rafId = requestAnimationFrame(update);
                ticking = true;
            }
        };

        window.addEventListener('scroll', onScroll, { passive: true });
        update();

        return () => {
            window.removeEventListener('scroll', onScroll);
            cancelAnimationFrame(rafId);
        };
    }, [elementId]);

    return progress;
}
