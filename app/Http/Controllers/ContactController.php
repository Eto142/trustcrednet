<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:150'],
            'email'         => ['required', 'email', 'max:150'],
            'message'       => ['required', 'string', 'max:2000'],
        ]);

        Mail::raw(
            "New signup enquiry\n\nBusiness Name: {$validated['business_name']}\nEmail: {$validated['email']}\n\nMessage:\n{$validated['message']}",
            function ($mail) use ($validated) {
                $mail->to(config('mail.from.address', 'support@trustcrednet.com'))
                     ->replyTo($validated['email'], $validated['business_name'])
                     ->subject("Signup Enquiry – {$validated['business_name']}");
            }
        );

        return back()->with('success', "Thanks, {$validated['business_name']}! We've received your message and will be in touch shortly.");
    }
}
