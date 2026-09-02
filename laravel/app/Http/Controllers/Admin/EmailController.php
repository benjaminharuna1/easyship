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

    public function testForm()
    {
        return view('admin.test_email');
    }

    public function testSend(Request $request)
    {
        $request->validate([
            'test_email' => ['required', 'email'],
        ]);

        $sent = (new MailService())->send(
            $request->test_email,
            'Test Email - SMTP Configuration',
            'emails.test_email'
        );

        if ($sent) {
            session()->flash('success_message', 'Test email sent successfully to ' . $request->test_email);
        } else {
            session()->flash('error_message', 'Failed to send test email. Please check your SMTP settings and logs.');
        }

        return redirect()->route('admin.email.test-form');
    }
}
