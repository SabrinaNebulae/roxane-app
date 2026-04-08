<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Notifications\ServiceActivationRequestNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $member = $request->user()
            ->members()
            ->with([
                'lastActiveMembership.package',
                'lastActiveMembership.services',
            ])
            ->first();

        return Inertia::render('dashboard', [
            'member' => $member ? new MemberResource($member) : null,
        ]);
    }

    public function requestServiceActivation(Request $request): RedirectResponse
    {
        $request->validate([
            'service_identifier' => ['required', 'string'],
        ]);

        $member = $request->user()->members()->first();

        if ($member === null) {
            return back()->with('flash', ['error' => 'Aucun compte membre associé.']);
        }

        Notification::route('mail', config('app.admin_email'))
            ->notify(new ServiceActivationRequestNotification($member, $request->string('service_identifier')));

        return back()->with('flash', ['success' => "Votre demande d'activation a bien été envoyée."]);
    }
}
