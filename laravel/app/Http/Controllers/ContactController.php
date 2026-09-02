<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SupportMessage;
use App\Services\MailService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __invoke(Request $request)
    {
        $settings = Setting::find(1);

        if ($request->ajax()) {
            return $this->submitAjax($request);
        }

        return view('contact', compact('settings'));
    }

    protected function submitAjax(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string'],
        ]);

        $message = SupportMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->number ?? null,
            'company' => $request->company ?? null,
            'message' => $request->message,
        ]);

        $settings = Setting::find(1);
        $sent = true;
        if ($settings) {
            $body = view('emails.contact_notification', [
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->number ?? '',
                'company' => $request->company ?? '',
                'message' => $request->message,
            ])->render();

            $sent = (new MailService())->send(
                $settings->email_address,
                "New Contact Form Message from " . $request->name,
                'emails.custom',
                ['body' => $body]
            );
        }

        if ($sent) {
            return response()->json(['status' => 'success', 'message' => 'Your message has been sent successfully. We will get back to you shortly.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to send message due to a mail server error. Please try again later.']);
    }
}
