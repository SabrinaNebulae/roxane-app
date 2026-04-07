import { Form, Head, usePage } from '@inertiajs/react';
import { cn } from '@/lib/utils';
import { CheckIcon, LoaderCircle } from 'lucide-react';
import MembershipFormController from '@/actions/App/Http/Controllers/Forms/MembershipFormController';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import NavGuestLayout from '@/layouts/nav-guest-layout';
import { Checkbox } from '@/components/ui/checkbox';
import { useEffect, useState } from 'react';
import { PageProps } from '@/types';
import { FlashMessage } from '@/components/flash-message';
import { Container } from '@/components/common/Container';
import { SectionHeading } from '@/components/common/SectionHeading';
import { Footer } from '@/components/footer';

export default function Membership() {
    const { flash, plans, services, captcha_question } = usePage().props as PageProps;
    const [showFlashMessage, setFlashMessage] = useState(!!flash);
    const [selectedPlan, setSelectedPlan] = useState(plans?.[0]?.identifier ?? null);
    const [amount, setAmount] = useState(plans?.[0]?.price ?? 0);

    useEffect(() => {
        if (plans && selectedPlan) {
            const plan = plans.find((p) => p.identifier === selectedPlan);
            if (plan) setAmount(plan.price);
        }
    }, [selectedPlan, plans]);

    useEffect(() => {
        if (flash) {
            setFlashMessage(true);
            const timer = setTimeout(() => setFlashMessage(false), 5000);
            return () => clearTimeout(timer);
        }
    }, [flash]);

    return (
        <>
            <Head title="Adhérer au Retzien Libre" />
            <div className="flex flex-col min-h-screen bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
                <div className="flex flex-col items-center px-4">
                    <NavGuestLayout />
                </div>

                <main className="flex-1 py-12">
                    <Container className="flex flex-col gap-10">
                        <SectionHeading
                            title="Adhérer au Retzien Libre"
                            color="primary"
                            subtitle="Rejoignez notre association et accédez à des outils libres, éthiques et respectueux de vos données."
                            align="left"
                        />

                        {showFlashMessage && (
                            <FlashMessage messages={flash ?? {}} />
                        )}

                        <Form
                            {...MembershipFormController.store.form()}
                            resetOnSuccess
                            disableWhileProcessing
                        >
                            {({ processing, errors }) => (
                                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">

                                    {/* Left — Personal info */}
                                    <div className="bg-white dark:bg-[#171717] rounded-2xl border-3 border-black p-6 shadow-[4px_4px_0px_rgba(0,0,0,1)] flex flex-col gap-4">
                                        <h2 className="text-lg font-semibold text-primary">Vos informations</h2>

                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div className="grid gap-1">
                                                <Label htmlFor="lastname">Nom*</Label>
                                                <Input id="lastname" name="lastname" type="text" required tabIndex={1} autoComplete="family-name" placeholder="Votre nom" />
                                                <InputError message={errors.lastname} />
                                            </div>
                                            <div className="grid gap-1">
                                                <Label htmlFor="firstname">Prénom*</Label>
                                                <Input id="firstname" name="firstname" type="text" required tabIndex={2} autoComplete="given-name" placeholder="Votre prénom" />
                                                <InputError message={errors.firstname} />
                                            </div>
                                        </div>

                                        <div className="grid gap-1">
                                            <Label htmlFor="email">Adresse e-mail*</Label>
                                            <Input id="email" name="email" type="email" required tabIndex={3} autoComplete="email" placeholder="email@exemple.com" />
                                            <InputError message={errors.email} />
                                        </div>

                                        <div className="grid gap-1">
                                            <Label htmlFor="phone1">Téléphone*</Label>
                                            <Input id="phone1" name="phone1" type="tel" required tabIndex={4} autoComplete="tel" placeholder="Votre numéro de téléphone" />
                                            <InputError message={errors.phone1} />
                                        </div>

                                        <div className="grid gap-1">
                                            <Label htmlFor="company">Société <span className="text-muted-foreground text-xs">(facultatif)</span></Label>
                                            <Input id="company" name="company" type="text" tabIndex={5} autoComplete="organization" placeholder="Votre société" />
                                            <InputError message={errors.company} />
                                        </div>

                                        <div className="grid gap-1">
                                            <Label htmlFor="address">Adresse*</Label>
                                            <Input id="address" name="address" type="text" required tabIndex={6} autoComplete="street-address" placeholder="Votre adresse" />
                                            <InputError message={errors.address} />
                                        </div>

                                        <div className="grid grid-cols-2 gap-4">
                                            <div className="grid gap-1">
                                                <Label htmlFor="zipcode">Code postal*</Label>
                                                <Input id="zipcode" name="zipcode" type="text" required tabIndex={7} autoComplete="postal-code" placeholder="Code postal" />
                                                <InputError message={errors.zipcode} />
                                            </div>
                                            <div className="grid gap-1">
                                                <Label htmlFor="city">Ville*</Label>
                                                <Input id="city" name="city" type="text" required tabIndex={8} autoComplete="address-level2" placeholder="Ville" />
                                                <InputError message={errors.city} />
                                            </div>
                                        </div>
                                    </div>

                                    {/* Right — Plan, services, captcha, submit */}
                                    <div className="flex flex-col gap-6">

                                        {/* Plan selection */}
                                        <div className="bg-white dark:bg-[#171717] rounded-2xl border-3 border-black p-6 shadow-[4px_4px_0px_rgba(0,0,0,1)] flex flex-col gap-4">
                                            <h2 className="text-lg font-semibold text-primary">Choisissez votre formule</h2>

                                            <div className="flex flex-col gap-3">
                                                {plans?.map((plan) => (
                                                    <button
                                                        key={plan.id}
                                                        type="button"
                                                        tabIndex={9}
                                                        onClick={() => setSelectedPlan(plan.identifier)}
                                                        className={cn(
                                                            'flex items-center justify-between rounded-xl border-3 border-black px-5 py-4 text-left transition-all duration-150',
                                                            'shadow-[3px_3px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5',
                                                            selectedPlan === plan.identifier
                                                                ? 'bg-primary text-black'
                                                                : 'bg-white dark:bg-[#1a1a1a] hover:bg-primary/20',
                                                        )}
                                                    >
                                                        <div className="flex flex-col">
                                                            <span className="font-bold text-base">{plan.name}</span>
                                                            {plan.months != null ? (
                                                                <span className="text-xs text-muted-foreground">
                                                                    {plan.months} mois × 1€/mois
                                                                </span>
                                                            ) : (
                                                                <span className="text-xs text-muted-foreground">{plan.description}</span>
                                                            )}
                                                        </div>
                                                        <span className="text-2xl font-black">{plan.price}€</span>
                                                    </button>
                                                ))}
                                            </div>

                                            <input type="hidden" name="package" value={selectedPlan ?? ''} />
                                            <input type="hidden" name="amount" value={amount} />
                                            <InputError message={errors.package} />

                                            <p className="text-center text-sm text-muted-foreground border-t border-border pt-3">
                                                Montant total : <strong className="text-primary text-lg">{amount}€</strong>
                                            </p>
                                        </div>

                                        {/* Services included */}
                                        <div className="bg-white dark:bg-[#171717] rounded-2xl border-3 border-black p-6 shadow-[4px_4px_0px_rgba(0,0,0,1)] flex flex-col gap-4">
                                            <h2 className="text-lg font-semibold text-primary">Services inclus</h2>
                                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                {services?.map((service) => (
                                                    <div key={service.name} className="flex items-start gap-2">
                                                        <CheckIcon className="h-4 w-4 mt-0.5 shrink-0 text-accent" />
                                                        <div>
                                                            <p className="text-sm font-medium leading-tight">{service.name}</p>
                                                            <p className="text-xs text-muted-foreground">{service.description}</p>
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>

                                        {/* Captcha + CGU + Submit */}
                                        <div className="bg-white dark:bg-[#171717] rounded-2xl border-3 border-black p-6 shadow-[4px_4px_0px_rgba(0,0,0,1)] flex flex-col gap-5">
                                            <div className="grid gap-1">
                                                <Label htmlFor="captcha" className="font-semibold">{captcha_question}</Label>
                                                <Input
                                                    id="captcha"
                                                    name="captcha"
                                                    type="text"
                                                    tabIndex={10}
                                                    placeholder="Votre réponse"
                                                    autoComplete="off"
                                                    className="max-w-[180px]"
                                                />
                                                <InputError message={errors.captcha} />
                                            </div>

                                            <div className="flex flex-col gap-1">
                                                <div className="flex items-start gap-3">
                                                    <Checkbox id="cgu" name="cgu" tabIndex={11} required className="mt-0.5" />
                                                    <Label htmlFor="cgu" className="text-sm leading-snug cursor-pointer">
                                                        J'ai lu et j'accepte les <a href="#">C.G.U.</a> et je comprends la
                                                        nécessité des enregistrements de mes données personnelles.
                                                    </Label>
                                                </div>
                                                <InputError message={errors.cgu} />
                                            </div>

                                            <Button
                                                type="submit"
                                                variant="secondary"
                                                tabIndex={12}
                                                className="w-full border-3 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 font-bold text-base py-5"
                                            >
                                                {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                                Envoyer ma demande d'adhésion
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                            )}
                        </Form>
                    </Container>
                </main>

                <Footer />
            </div>
        </>
    );
}
