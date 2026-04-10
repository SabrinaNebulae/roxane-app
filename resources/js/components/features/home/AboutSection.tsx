import {SectionHeading} from "@/components/common/SectionHeading";
import {Button} from '@/components/ui/button';

export function AboutSection() {
    return (
        <section id="about-section" className="w-full py-16">
            <div className="max-w-7xl mx-auto px-4">
                <SectionHeading title="Qui sommes-nous ?" color="secondary"
                                subtitle="Le Retzien Libre, c’est une association qui promeut l’auto-hébergement et la décentralisation des services en ligne depuis 2017."
                                align='left'/>
                <div
                    className="nb-shadow-static bg-white rounded-4xl mt-10 px-10 pt-20 pb-10">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div className="flex flex-col gap-3 lg:border-r-2 border-black lg:pr-10 border-0">
                            <h3 className="text-xl text-primary font-semibold">Une association locale</h3>
                            <p>
                                Nous voulons vous proposer à travers des outils libres, ouverts et solidaires, de
                                quitter l'industrie du G.A.F.A.M.
                            </p>
                        </div>
                        <div className="flex flex-col gap-3 border-r-2 border-black pr-10">
                            <h3 className="text-xl text-primary font-semibold">Notre mission</h3>
                            <p>
                                Nous nous positionnons comme "A.M.A.P. informatique", délivrant des services "bio",
                                "éthiques" et "locaux" dans le Pays de Retz et Nantes.
                            </p>
                        </div>
                        <div className="flex flex-col gap-3">
                            <h3 className="text-xl text-primary font-semibold">Notre solution</h3>
                            <p>
                                Pour seulement 12€/an, adhérez au Retzien Libre pour bénéficier des services de
                                l'association et reprenez le contrôle de vos données.
                            </p>
                        </div>
                    </div>
                    <div className="w-full flex justify-center mt-20">
                        <Button variant="default">En savoir plus en lisant notre Blog</Button>
                    </div>
                </div>
            </div>
        </section>
    );
}
