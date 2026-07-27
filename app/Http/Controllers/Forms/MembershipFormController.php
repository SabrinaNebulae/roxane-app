<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forms\MembershipRequest;
use App\Models\MemberType;
use App\Models\Package;
use App\Models\Service;
use App\Services\MemberService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MembershipFormController extends Controller
{
    public function __construct(protected MemberService $memberService) {}

    public function create(): Response
    {
        $remainingMonths = 13 - now()->month;
        $currentYear = now()->year;

        $plans = Package::query()
            ->where('is_active', true)
            ->select('id', 'identifier', 'name', 'price', 'description')
            ->get()
            ->map(function (Package $p) use ($remainingMonths, $currentYear) {
                $months = match ($p->identifier) {
                    'custom' => $remainingMonths,
                    'one-year' => $remainingMonths + 12,
                    'two-years' => $remainingMonths + 24,
                    default => null,
                };

                return [
                    'id' => $p->id,
                    'identifier' => $p->identifier,
                    'name' => $p->name,
                    'description' => $p->description,
                    'price' => $months ?? (float) $p->price,
                    'months' => $months,
                ];
            });

        $memberTypes = MemberType::query()
            ->select('id', 'identifier', 'name')
            ->get();

        return Inertia::render('forms/membership', [
            'plans' => $plans,
            'services' => Service::query()->select('name', 'description')->get(),
            'member_types' => $memberTypes,
            'current_year' => $currentYear,
            'captcha_question' => $this->generateCaptcha(),
        ]);
    }

    public function store(MembershipRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $this->memberService->registerNewMember($validated);
        } catch (\Throwable $e) {
            \Log::error('Erreur lors de la création d\'un membre', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validated,
            ]);

            return to_route('membership')
                ->with('error', __('memberships.fields.subscription.error'));
        }

        return to_route('membership')
            ->with('success', __('memberships.fields.subscription.success'));
    }

    private function generateCaptcha(): string
    {
        $a = random_int(1, 9);
        $b = random_int(1, 9);

        session(['captcha_membership' => (string) ($a + $b)]);

        return "Combien font {$a} + {$b} ?";
    }
}
