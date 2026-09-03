<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MailService;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendForm()
    {
        return view('admin.send-email');
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient' => ['required', 'email'],
            'subject' => ['required', 'string'],
            'body' => ['required', 'string'],
            'attachments.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,txt', 'max:5120'],
        ]);

        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('temp_attachments', 'local');
                $attachmentPaths[] = storage_path('app/private/' . $path);
            }
        }

        $sent = (new MailService())->send(
            $request->recipient,
            $request->subject,
            'emails.custom',
            ['body' => $request->body],
            $attachmentPaths
        );

        foreach ($attachmentPaths as $path) {
            if (is_file($path)) {
                @unlink($path);
            }
        }

        if ($sent) {
            session()->flash('success_message', 'Email sent successfully to ' . $request->recipient);
        } else {
            session()->flash('error_message', 'Failed to send email. Please check your SMTP settings and logs.');
        }

        return redirect()->route('admin.email.send-form');
    }

    public function testSend(Request $request)
    {
        $request->validate([
            'test_email' => ['required', 'email'],
            'smtp-host' => ['nullable', 'string'],
            'smtp-port' => ['nullable', 'integer'],
            'smtp-username' => ['nullable', 'string'],
            'smtp-password' => ['nullable', 'string'],
            'smtp-secure' => ['nullable', 'string'],
        ]);

        $smtpOverride = [
            'host' => $request->input('smtp-host'),
            'port' => $request->input('smtp-port'),
            'username' => $request->input('smtp-username'),
            'password' => $request->input('smtp-password'),
            'encryption' => $request->input('smtp-secure'),
        ];

        $sent = (new MailService())->send(
            $request->test_email,
            'Test Email - SMTP Configuration',
            'emails.test_email',
            [],
            [],
            $smtpOverride
        );

        if ($sent) {
            session()->flash('success_message', 'Test email sent successfully to ' . $request->test_email);
            if ($request->wantsJson()) {
                return response()->json(['status' => 'success', 'message' => 'Test email sent successfully to ' . $request->test_email]);
            }
        } else {
            session()->flash('error_message', 'Failed to send test email. Please check your SMTP settings and logs.');
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Failed to send test email. Please check your SMTP settings and logs.'], 422);
            }
        }

        return redirect()->route('admin.settings')->with('anchor', 'email-settings');
    }
}
