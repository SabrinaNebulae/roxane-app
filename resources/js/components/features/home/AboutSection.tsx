import {SectionHeading} from "@/components/common/SectionHeading";

export function AboutSection() {
    return (
        <section className="w-full py-16">
            <div className="max-w-7xl mx-auto px-4">
                <SectionHeading title="Qui sommes-nous ?" color="secondary" subtitle="Le Retzien Libre, c’est une association qui promeut l’auto-hébergement et la décentralisation des services en ligne depuis 2017." align='left' />
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mt-5">
                    <div className="flex flex-col gap-3">
                        <h3 className="text-xl font-semibold">Une association locale</h3>
                        <p>
                            Le Retzien Libre est une association engagée pour la promotion du logiciel libre
                            et la protection de vos données personnelles sur le territoire du Pays de Retz.
                        </p>
                    </div>
                    <div className="flex flex-col gap-3">
                        <h3 className="text-xl font-semibold">Notre mission</h3>
                        <p>
                            Nous sensibilisons et accompagnons les citoyens vers des pratiques numériques
                            plus respectueuses, libres et indépendantes des grandes plateformes commerciales.
                        </p>
                    </div>
                    <div className="flex flex-col gap-3">
                        <h3 className="text-xl font-semibold">Surveillance massive</h3>
                        <p>
                            Les GAFAM collectent et exploitent vos données personnelles à des fins commerciales,
                            sans transparence sur l'usage qui en est fait.
                        </p>
                    </div>
                    <div className="flex flex-col gap-3">
                        <h3 className="text-xl font-semibold">Monopole numérique</h3>
                        <p>
                            Concentration excessive du pouvoir et dépendance aux services centralisés.
                            Il existe des alternatives libres, locales et respectueuses.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    );
}
