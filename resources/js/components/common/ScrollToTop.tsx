import { useEffect, useState } from 'react';
import { ChevronUp } from 'lucide-react';

export function ScrollToTop() {
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        const hero = document.getElementById('hero');
        if (!hero) return;

        const observer = new IntersectionObserver(
            ([entry]) => setIsVisible(!entry.isIntersecting),
            { threshold: 0 },
        );

        observer.observe(hero);
        return () => observer.disconnect();
    }, []);

    const scrollToTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });

    if (!isVisible) return null;

    return (
        <button
            onClick={scrollToTop}
            aria-label="Retour en haut"
            className="nb-shadow fixed bottom-6 right-6 z-50 p-3 rounded-full bg-primary"
        >
            <ChevronUp className="size-5" />
        </button>
    );
}