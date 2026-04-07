<?php

namespace App\Services;

use App\Models\Contact;
use App\Notifications\ContactNewRequestNotification;
use Illuminate\Support\Facades\Notification;

class ContactService
{
    public function __construct() {}

    public function registerNewContactRequest(array $data): Contact
    {
        $contact = new Contact;
        $contact->fill($data);
        $contact->save();

        Notification::route('mail', config('app.admin_email'))
            ->notify(new ContactNewRequestNotification($contact));

        return $contact;
    }
}
