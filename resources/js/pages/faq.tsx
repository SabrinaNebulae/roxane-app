import { Head } from '@inertiajs/react';
import NavGuestLayout from '@/layouts/nav-guest-layout';
import { Footer } from '@/components/footer';
import { Container } from '@/components/common/Container';
import { SectionHeading } from '@/components/common/SectionHeading';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from '@/components/ui/accordion';

const faqItems = [
    {
        question: "Qu'est-ce que Le Retzien Libre ?",
        answer: "Le Retzien Libre est une association locale engagée pour un internet éthique, libre et respectueux de la vie privée. Nous proposons des services numériques basés sur des logiciels libres, hébergés localement, en alternative aux géants du numérique.",
    },
    {
        question: "Comment adhérer à l'association ?",
        answer: "Vous pouvez adhérer directement en ligne via notre formulaire d'adhésion. Choisissez votre formule (année en cours, 1 an ou 2 ans), remplissez vos informations et validez. Notre équipe traitera votre demande dans les meilleurs délais.",
    },
    {
        question: "Quels services sont inclus dans l'adhésion ?",
        answer: "L'adhésion inclut l'accès à l'ensemble de nos services : boîte mail @retzien.fr, stockage cloud via NextCloud, hébergement web, listes de diffusion et bien plus. Consultez notre documentation pour la liste complète des services disponibles.",
    },
    {
        question: "Combien coûte l'adhésion ?",
        answer: "L'adhésion est à 1€ par mois. Le montant est calculé en fonction de la durée choisie : reste de l'année en cours, année en cours + 1 an, ou année en cours + 2 ans. Les adhésions sont basées sur l'année civile (janvier à décembre).",
    },
    {
        question: "Comment fonctionne ma boîte mail @retzien.fr ?",
        answer: "Lors de votre adhésion, vous pouvez indiquer le nom de boîte mail souhaité (ex : prenom.nom@retzien.fr). Une fois votre adhésion validée, votre boîte sera créée et vous recevrez vos identifiants de connexion. Vous pouvez la consulter via webmail ou la configurer dans votre client mail préféré.",
    },
    {
        question: "Que se passe-t-il à l'expiration de mon adhésion ?",
        answer: "Vous recevrez un rappel par e-mail avant l'expiration de votre adhésion. Si vous ne renouvelez pas, vos services seront suspendus. Vos données sont conservées pendant une période raisonnable pour vous permettre de renouveler sans perte.",
    },
    {
        question: "Comment contacter l'association ?",
        answer: "Vous pouvez nous joindre via le formulaire de contact disponible sur le site, ou directement par e-mail. Pour les questions techniques, consultez d'abord notre documentation en ligne.",
    },
    {
        question: "Où trouver la documentation technique ?",
        answer: "Notre documentation complète est disponible à l'adresse doc.retzien.fr. Vous y trouverez des guides de configuration pour tous nos services, des tutoriels et une base de connaissances.",
    },
];

export default function Faq() {
    return (
        <>
            <Head title="Foire aux questions" />
            <div className="flex flex-col min-h-screen bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
                <div className="flex flex-col items-center px-4">
                    <NavGuestLayout />
                </div>

                <main className="flex-1 py-12">
                    <Container className="flex flex-col gap-10 max-w-4xl mx-auto">
                        <SectionHeading
                            title="Foire aux questions"
                            color="primary"
                            subtitle="Retrouvez les réponses aux questions les plus fréquentes sur notre association et nos services."
                            align="left"
                        />

                        <Accordion type="single" collapsible className="w-full flex flex-col gap-3">
                            {faqItems.map((item, index) => (
                                <AccordionItem
                                    key={index}
                                    value={`item-${index}`}
                                    className="nb-shadow-static rounded-2xl border-3 border-black px-5 overflow-hidden"
                                >
                                    <AccordionTrigger className="text-left font-semibold text-base py-4 hover:no-underline">
                                        {item.question}
                                    </AccordionTrigger>
                                    <AccordionContent className="text-muted-foreground pb-4">
                                        {item.answer}
                                    </AccordionContent>
                                </AccordionItem>
                            ))}
                        </Accordion>

                        <div className="bg-primary dark:bg-[#171717] nb-shadow-static rounded-2xl p-6 text-center">
                            <p className="text-accent font-semibold mb-2">Vous n'avez pas trouvé votre réponse ?</p>
                            <p className="text-sm text-muted-foreground mb-4">
                                Consultez notre documentation complète ou contactez-nous directement.
                            </p>
                            <div className="flex flex-wrap justify-center gap-3">
                                <a
                                    href="https://doc.retzien.fr"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    className="nb-shadow inline-flex items-center justify-center rounded-md text-sm font-bold bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 px-4 py-2 no-underline"
                                >
                                    Documentation
                                </a>
                                <a
                                    href="/contact"
                                    className="nb-shadow inline-flex items-center justify-center rounded-md text-sm font-bold bg-accent text-white hover:bg-accent/80 h-10 px-4 py-2 no-underline"
                                >
                                    Nous contacter
                                </a>
                            </div>
                        </div>
                    </Container>
                </main>

                <Footer />
            </div>
        </>
    );
}
