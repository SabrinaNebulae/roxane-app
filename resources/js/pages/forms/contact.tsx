import { useEffect, useState } from 'react';
import { Form, Head, usePage } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import ContactFormController from '@/actions/App/Http/Controllers/Forms/ContactFormController';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import NavGuestLayout from '@/layouts/nav-guest-layout';
import { PageProps } from '@/types';
import { FlashMessage } from '@/components/flash-message';
import { Container } from '@/components/common/Container';
import { SectionHeading } from '@/components/common/SectionHeading';
import { Footer } from '@/components/footer';
import IllustrationLogo from "@/img/utils/lrl-logo-full.svg";

export default function Contact() {
    const { flash, captcha_question } = usePage().props as PageProps;
    const [showFlashMessage, setFlashMessage] = useState(!!flash);

    useEffect(() => {
        if (flash) {
            setFlashMessage(true);
            const timer = setTimeout(() => setFlashMessage(false), 5000);
            return () => clearTimeout(timer);
        }
    }, [flash]);

    return (
        <>
            <Head title="Nous contacter" />
            <div className="flex flex-col min-h-screen bg-white dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC]">
                <div className="flex flex-col items-center px-4">
                    <NavGuestLayout />
                </div>

                <main className="flex-1 py-12">
                    <Container className="flex flex-col gap-10">
                        <SectionHeading
                            title="Nous contacter"
                            color="primary"
                            subtitle="Une question, une remarque ? Remplissez le formulaire ci-dessous, nous vous répondrons dans les plus brefs délais."
                            align="left"
                            className="mx-auto"
                        />

                        {showFlashMessage && <FlashMessage messages={flash ?? {}} />}

                        <Form
                            {...ContactFormController.store.form()}
                            resetOnSuccess
                            disableWhileProcessing
                        >
                            {({ processing, errors }) => (
                                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-4xl mx-auto">

                                    {/* Left — Identité + adresse */}
                                    <div className="nb-shadow-static bg-primary dark:bg-[#171717] rounded-2xl p-6 flex flex-col gap-4">
                                        <div className="lg:w-1/2 flex justify-center mx-auto">
                                            <img
                                                src={IllustrationLogo}
                                                alt="Le Retzien Libre"
                                                className="rounded-lg max-w-md w-full"
                                            />
                                        </div>
                                        <h2 className="text-lg text-accent font-semibold">Vos informations</h2>

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
                                            <Label htmlFor="address">
                                                Adresse postale <span className="text-muted-foreground text-xs">(facultatif)</span>
                                            </Label>
                                            <Input id="address" name="address" type="text" tabIndex={4} autoComplete="street-address" placeholder="Votre adresse postale" />
                                            <InputError message={errors.address} />
                                        </div>
                                    </div>

                                    {/* Right — Message + captcha + submit */}
                                    <div className="flex flex-col gap-6">
                                        <div className="bg-white dark:bg-[#171717] nb-shadow-static rounded-2xl p-6 flex flex-col gap-4">
                                            <h2 className="text-lg font-semibold text-primary">Votre message</h2>

                                            <div className="grid gap-1">
                                                <Label htmlFor="subject">Objet*</Label>
                                                <Select name="subject" required>
                                                    <SelectTrigger tabIndex={5}>
                                                        <SelectValue placeholder="Sélectionnez un objet" />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        <SelectGroup>
                                                            <SelectLabel>Objets</SelectLabel>
                                                            <SelectItem value="info-request">Demande d'informations</SelectItem>
                                                            <SelectItem value="service-request">Services</SelectItem>
                                                            <SelectItem value="other">Autres</SelectItem>
                                                        </SelectGroup>
                                                    </SelectContent>
                                                </Select>
                                                <InputError message={errors.subject} />
                                            </div>

                                            <div className="grid gap-1">
                                                <Label htmlFor="message">Message*</Label>
                                                <Textarea id="message" name="message" tabIndex={6} required placeholder="Entrez votre message ici..." className="h-32 resize-none" />
                                                <InputError message={errors.message} />
                                            </div>
                                        </div>

                                        <div className="bg-white dark:bg-[#171717] nb-shadow-static rounded-2xl p-6 flex flex-col gap-5">
                                            <div className="grid gap-1">
                                                <Label htmlFor="captcha" className="font-semibold">{captcha_question}</Label>
                                                <Input
                                                    id="captcha"
                                                    name="captcha"
                                                    type="text"
                                                    tabIndex={7}
                                                    placeholder="Votre réponse"
                                                    autoComplete="off"
                                                    className="max-w-[180px]"
                                                />
                                                <InputError message={errors.captcha} />
                                            </div>

                                            <Button
                                                type="submit"
                                                variant="secondary"
                                                tabIndex={8}
                                                className="nb-shadow w-full font-bold text-base py-5"
                                            >
                                                {processing && <LoaderCircle className="h-4 w-4 animate-spin" />}
                                                Envoyer mon message
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
