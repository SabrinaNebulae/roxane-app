import { type Service } from '@/types';
import { ServiceCard } from './ServiceCard';
import { SectionHeading } from '@/components/common/SectionHeading';
import { Container } from '@/components/common/Container';

import IllustrationMail from '@/img/utils/service-mail.svg';
import IllustrationCloud from '@/img/utils/service-cloud.svg';
import IllustrationHosting from '@/img/utils/service-webhosting.svg';
import IllustrationShare from '@/img/utils/service-share.svg';
import IllustrationMailing from '@/img/utils/service-mailing-marketing.svg';
import IllustrationSurvey from '@/img/utils/service-survey.svg';

const services: Service[] = [
    {
        title: 'Boîte mail',
        description: 'Service de messagerie électronique sécurisé et respectueux de votre vie privée',
        colorTitle: 'white',
        bgTitle: 'accent',
        bgColor: 'secondary',
        descriptionColor: 'black',
        link: '#',
        illustration: IllustrationMail
    },
    {
        title: 'Stockage Cloud',
        description: 'Stockage en ligne et collaboration avec vos données hébergées localement',
        colorTitle: 'black',
        bgTitle: 'white',
        bgColor: 'primary',
        descriptionColor: 'black',
        link: '#',
        illustration: IllustrationCloud
    },
    {
        title: 'Email Marketing',
        description: "Gérez vos communications de groupe efficacement",
        colorTitle: 'black',
        bgTitle: 'primary',
        bgColor: 'accent',
        descriptionColor: 'white',
        link: '#',
        illustration: IllustrationMailing
    },
    {
        title: 'Hébergement de site',
        description: "Solutions d'hébergement web éthiques et performantes",
        colorTitle: 'black',
        bgTitle: 'secondary',
        bgColor: 'gray',
        descriptionColor: 'black',
        link: '#',
        illustration: IllustrationHosting
    },
    {
        title: 'Partage de fichiers',
        description: 'Partager facielement vos fichiers en toute sécurité',
        colorTitle: 'black',
        bgTitle: 'white',
        bgColor: 'primary',
        descriptionColor: 'black',
        link: '#',
        illustration: IllustrationShare
    },
    {
        title: 'Outil de Sondage',
        description: 'Créez et partagez des sondages en ligne en toute confidentialité',
        colorTitle: 'black',
        bgTitle: 'primary',
        bgColor: 'accent',
        descriptionColor: 'white',
        link: '#',
        illustration: IllustrationSurvey
    },

];

export function ServicesSection() {
    return (
        <section id="first-section" className="relative overflow-hidden w-full bg-white py-16">
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
