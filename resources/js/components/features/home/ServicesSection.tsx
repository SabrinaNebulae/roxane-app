import { type Service } from '@/types';
import { ServiceCard } from './ServiceCard';
import { SectionHeading } from '@/components/common/SectionHeading';
import { Container } from '@/components/common/Container';
import PawsDecoration from '@/components/common/PawsDecoration';
import { useParallax } from '@/hooks/use-parallax';

const services: Service[] = [
    {
        title: 'Boîte mail',
        description: 'Service de messagerie électronique sécurisé et respectueux de votre vie privée',
        colorTitle: 'white',
        bgTitle: 'accent',
        bgColor: 'secondary',
        link: '#',
        illustration: '../../img/utils/lrl-logo.svg'
    },
    {
        title: 'Stockage Cloud',
        description: 'Stockage en ligne et collaboration avec vos données hébergées localement',
        colorTitle: 'black',
        bgTitle: 'white',
        bgColor: 'primary',
        link: '#',
        illustration: '../../img/utils/lrl-logo.svg'
    },
    {
        title: 'Hébergement de site',
        description: "Solutions d'hébergement web éthiques et performantes",
        colorTitle: 'black',
        bgTitle: 'primary',
        bgColor: 'accent',
        link: '#',
        illustration: '../../img/utils/lrl-logo.svg'
    },
    {
        title: 'Email Marketing',
        description: "Gérez vos communications de groupe efficacement",
        colorTitle: 'black',
        bgTitle: 'secondary',
        bgColor: 'gray',
        link: '#',
        illustration: '../../img/utils/lrl-logo.svg'
    },
    {
        title: 'Partage de fichiers',
        description: 'Partager facielement vos fichiers en toute sécurité',
        colorTitle: 'black',
        bgTitle: 'white',
        bgColor: 'primary',
        link: '#',
        illustration: '../../img/utils/lrl-logo.svg'
    },
    {
        title: 'Outil de Sondage',
        description: 'Créez et partagez des sondages en ligne en toute confidentialité',
        colorTitle: 'black',
        bgTitle: 'primary',
        bgColor: 'accent',
        link: '#',
        illustration: '../../img/utils/lrl-logo.svg'
    },

];

export function ServicesSection() {
    const pawsRef = useParallax<HTMLDivElement>(0.08);

    return (
        <section id="first-section" className="relative overflow-hidden w-full bg-white py-16">
            <div ref={pawsRef} className="absolute -top-4 left-0 pointer-events-none hidden lg:block w-48 opacity-30">
                <PawsDecoration className="w-full h-auto" />
            </div>
            <Container className="flex flex-col gap-10">
                <SectionHeading
                    title="Nos services"
                    color="primary"
                    subtitle="Nous vous proposons, à travers des outils libres, ouverts et solidaires, de quitter l’industrie du G.A.F.A.M. N’acceptons plus d’être leur produit !"
                    align="left"
                />
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {services.map((service) => (
                        <ServiceCard key={service.title} {...service} />
                    ))}
                </div>
            </Container>
        </section>
    );
}
