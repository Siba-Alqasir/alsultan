<?php

namespace App\Observers;

use App\Mail\ContactUsMail;
use App\Models\ContactEmails;
use App\Models\Events;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactObserver
{
    public function created(Inquiry $inquiry)
    {
        $details = [
            'name' => $inquiry->name,
            'email' => $inquiry->email,
            'message' => $inquiry->message,
            'phone' => $inquiry->phone,
            'company' => $inquiry->company,
            'category' => $inquiry->category,
            'type' => $inquiry->type,
        ];

        $contact_email = 'bash@plana.ae';
        Log::info('Email:' . $contact_email);
        Mail::to($contact_email)->send(new ContactUsMail($details));

    }
}
