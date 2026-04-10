import { LegalLayout } from '@/components/common/LegalLayout';
import { LegalSection } from '@/components/common/LegalSection';

export default function Cgu() {
    return (
        <LegalLayout
            title="Conditions Générales d'Utilisation"
            description="Les présentes conditions générales d'utilisation régissent l'accès et l'utilisation du site et des services proposés par Le Retzien Libre."
        >
            <LegalSection heading="Acceptation des conditions">
                <p>
                    En accédant et en utilisant ce site, vous acceptez sans réserve les présentes
                    conditions générales d'utilisation. Si vous n'acceptez pas ces conditions,
                    veuillez ne pas utiliser ce site.
                </p>
            </LegalSection>

            <LegalSection heading="Accès au site">
                <p>
                    Le site est accessible gratuitement à tout utilisateur disposant d'un accès
                    à internet. Tous les frais liés à cet accès sont à la charge de l'utilisateur.
                </p>
                <p>
                    L'accès à certaines fonctionnalités nécessite la création d'un compte et
                    une adhésion à l'association Le Retzien Libre.
                </p>
            </LegalSection>

            <LegalSection heading="Création de compte">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. La création d'un compte
                    implique la fourniture d'informations exactes et à jour. L'utilisateur est
                    responsable de la confidentialité de ses identifiants de connexion.
                </p>
                <p>
                    L'association se réserve le droit de suspendre ou supprimer tout compte en cas
                    de non-respect des présentes conditions.
                </p>
            </LegalSection>

            <LegalSection heading="Utilisation des services">
                <p>Les services proposés sont destinés à un usage personnel et non commercial.</p>
                <p>Il est notamment interdit de :</p>
                <ul className="list-disc pl-5 flex flex-col gap-1">
                    <li>Utiliser les services à des fins illicites ou contraires aux bonnes mœurs</li>
                    <li>Porter atteinte aux droits de tiers</li>
                    <li>Tenter de perturber le bon fonctionnement des services</li>
                    <li>Diffuser des contenus illégaux, offensants ou trompeurs</li>
                </ul>
            </LegalSection>

            <LegalSection heading="Disponibilité des services">
                <p>
                    L'association s'efforce d'assurer la disponibilité des services 24h/24 et 7j/7,
                    mais ne peut garantir une disponibilité sans interruption. Des maintenances
                    peuvent être effectuées et entraîner des interruptions temporaires.
                </p>
            </LegalSection>

            <LegalSection heading="Modification des CGU">
                <p>
                    L'association se réserve le droit de modifier les présentes conditions à tout
                    moment. Les utilisateurs seront informés des modifications par tout moyen
                    approprié. La poursuite de l'utilisation du site vaut acceptation des nouvelles
                    conditions.
                </p>
            </LegalSection>

            <LegalSection heading="Droit applicable">
                <p>
                    Les présentes CGU sont soumises au droit français. Tout litige relatif à leur
                    interprétation ou exécution relève de la compétence exclusive des tribunaux français.
                </p>
            </LegalSection>
        </LegalLayout>
    );
}
