<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\ContactRequest;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactFormController extends Controller
{
    public function __construct(protected ContactService $contactService) {}

    public function create(): Response
    {
        return Inertia::render('forms/contact', [
            'captcha_question' => $this->generateCaptcha(),
        ]);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $this->contactService->registerNewContactRequest($validated);
        } catch (\Throwable $e) {
            \Log::error('Erreur lors de la création d\'un contact', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated,
            ]);

            return to_route('contact')->with('error', __('contacts.responses.error'));
        }

        return to_route('contact')->with('success', __('contacts.responses.success'));
    }

    private function generateCaptcha(): string
    {
        $a = random_int(1, 9);
        $b = random_int(1, 9);

        session(['captcha_contact' => (string) ($a + $b)]);

        return "Combien font {$a} + {$b} ?";
    }
}
