import { LegalLayout } from '@/components/common/LegalLayout';
import { LegalSection } from '@/components/common/LegalSection';

export default function Confidentialite() {
    return (
        <LegalLayout
            title="Politique de confidentialité"
            description="Le Retzien Libre s'engage à protéger vos données personnelles conformément au Règlement Général sur la Protection des Données (RGPD)."
        >
            <LegalSection heading="Responsable du traitement">
                <p>
                    Le responsable du traitement des données est l'association <strong>Le Retzien Libre</strong>,
                    joignable à l'adresse : contact@retzien.fr
                </p>
            </LegalSection>

            <LegalSection heading="Données collectées">
                <p>Dans le cadre de l'utilisation du site et de l'adhésion, nous collectons :</p>
                <ul className="list-disc pl-5 flex flex-col gap-1">
                    <li>Nom et prénom</li>
                    <li>Adresse email</li>
                    <li>Adresse postale</li>
                    <li>Données de connexion (logs techniques)</li>
                    <li>Informations relatives à l'adhésion</li>
                </ul>
            </LegalSection>

            <LegalSection heading="Finalités du traitement">
                <p>Les données collectées sont utilisées pour :</p>
                <ul className="list-disc pl-5 flex flex-col gap-1">
                    <li>Gérer votre adhésion à l'association</li>
                    <li>Vous fournir accès aux services membres</li>
                    <li>Vous envoyer des communications liées à l'association</li>
                    <li>Assurer la sécurité et le bon fonctionnement du site</li>
                </ul>
            </LegalSection>

            <LegalSection heading="Base légale">
                <p>
                    Le traitement de vos données repose sur votre consentement explicite lors de
                    l'adhésion, ainsi que sur l'exécution du contrat d'adhésion qui nous lie.
                </p>
            </LegalSection>

            <LegalSection heading="Durée de conservation">
                <p>
                    Vos données sont conservées pendant toute la durée de votre adhésion et
                    supprimées dans un délai de 3 ans après la fin de celle-ci, sauf obligation
                    légale contraire.
                </p>
            </LegalSection>

            <LegalSection heading="Partage des données">
                <p>
                    Vos données personnelles ne sont jamais vendues ni cédées à des tiers à des
                    fins commerciales. Elles peuvent être partagées uniquement avec les prestataires
                    techniques nécessaires au fonctionnement des services, dans le respect du RGPD.
                </p>
            </LegalSection>

            <LegalSection heading="Vos droits">
                <p>Conformément au RGPD, vous disposez des droits suivants :</p>
                <ul className="list-disc pl-5 flex flex-col gap-1">
                    <li><strong>Droit d'accès</strong> : obtenir une copie de vos données</li>
                    <li><strong>Droit de rectification</strong> : corriger des données inexactes</li>
                    <li><strong>Droit à l'effacement</strong> : demander la suppression de vos données</li>
                    <li><strong>Droit d'opposition</strong> : vous opposer à certains traitements</li>
                    <li><strong>Droit à la portabilité</strong> : recevoir vos données dans un format lisible</li>
                </ul>
                <p>
                    Pour exercer ces droits, contactez-nous à : <strong>contact@retzien.fr</strong>
                </p>
            </LegalSection>

            <LegalSection heading="Cookies">
                <p>
                    Le site utilise uniquement des cookies strictement nécessaires à son fonctionnement
                    (session, sécurité). Aucun cookie de tracking ou publicitaire n'est utilisé.
                </p>
            </LegalSection>

            <LegalSection heading="Contact & réclamations">
                <p>
                    Pour toute question relative à cette politique, contactez-nous à contact@retzien.fr.
                    Vous disposez également du droit d'introduire une réclamation auprès de la
                    CNIL (www.cnil.fr).
                </p>
            </LegalSection>
        </LegalLayout>
    );
}
