import { LegalLayout } from '@/components/common/LegalLayout';
import { LegalSection } from '@/components/common/LegalSection';

export default function MentionsLegales() {
    return (
        <LegalLayout
            title="Mentions légales"
            description="Conformément aux dispositions de la loi n° 2004-575 du 21 juin 2004 pour la confiance en l'économie numérique."
        >
            <LegalSection heading="Éditeur du site">
                <p>Le présent site est édité par l'association <strong>Le Retzien Libre</strong>.</p>
                <p>Adresse : Lorem ipsum dolor sit amet, 44000 Nantes, France</p>
                <p>Email : contact@retzien.fr</p>
                <p>SIRET : 000 000 000 00000</p>
            </LegalSection>

            <LegalSection heading="Hébergement">
                <p>
                    Le site est hébergé par Lorem Ipsum Hosting, société au capital de XX XXX €,
                    dont le siège social est situé au 00 rue de l'Exemple, 75000 Paris, France.
                </p>
                <p>Téléphone : +33 (0)1 00 00 00 00</p>
            </LegalSection>

            <LegalSection heading="Propriété intellectuelle">
                <p>
                    L'ensemble du contenu de ce site (textes, images, logos, icônes) est la propriété
                    exclusive de l'association Le Retzien Libre, sauf mention contraire.
                </p>
                <p>
                    Toute reproduction, représentation, modification ou exploitation du contenu du site,
                    à quelque titre et sur quelque support que ce soit, sans autorisation expresse et
                    préalable de l'éditeur, est strictement interdite.
                </p>
            </LegalSection>

            <LegalSection heading="Responsabilité">
                <p>
                    L'association Le Retzien Libre ne pourra être tenue responsable des dommages directs
                    ou indirects causés au matériel de l'utilisateur lors de l'accès au site.
                </p>
                <p>
                    Des liens hypertextes peuvent renvoyer vers d'autres sites. L'association décline
                    toute responsabilité concernant le contenu de ces sites tiers.
                </p>
            </LegalSection>

            <LegalSection heading="Droit applicable">
                <p>
                    Les présentes mentions légales sont régies par le droit français. En cas de litige,
                    les tribunaux français seront seuls compétents.
                </p>
            </LegalSection>
        </LegalLayout>
    );
}
