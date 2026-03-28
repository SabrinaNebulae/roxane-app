import { useEffect, useRef } from 'react';

export function useParallax<T extends HTMLElement>(speed: number = 0.15) {
    const ref = useRef<T>(null);

    useEffect(() => {
        const el = ref.current;
        if (!el) return;

        let rafId: number;
        let ticking = false;

        const update = () => {
            el.style.transform = `translateY(${window.scrollY * speed}px)`;
            ticking = false;
        };

        const onScroll = () => {
            if (!ticking) {
                rafId = requestAnimationFrame(update);
                ticking = true;
            }
        };

        window.addEventListener('scroll', onScroll, { passive: true });

        return () => {
            window.removeEventListener('scroll', onScroll);
            cancelAnimationFrame(rafId);
        };
    }, [speed]);

    return ref;
}
