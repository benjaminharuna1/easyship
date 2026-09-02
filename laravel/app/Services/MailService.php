<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Address;

class MailService
{
    /**
     * Send a templated HTML email using the SMTP settings stored in the
     * settings table. Returns true on success.
     *
     * @param string $email Recipient address
     * @param string $subject Email subject
     * @param string $view Blade view name (e.g. 'emails.shipment_creation', 'emails.custom')
     * @param array $data Data passed to the view
     * @param array $attachmentPaths Array of absolute file paths to attach
     */
    public function send(string $email, string $subject, string $view, array $data = [], array $attachmentPaths = []): bool
    {
        $settings = Setting::find(1);
        if (!$settings) {
            return false;
        }

        $fromName = $settings->email_name ?: 'EasyShip';
        $fromEmail = $settings->smtp_username ?: $settings->email_address;

        try {
            // Temporarily swap the default mailer's SMTP config for this request.
            config([
                'mail.mailers.smtp.host' => $settings->smtp_host,
                'mail.mailers.smtp.username' => $settings->smtp_username,
                'mail.mailers.smtp.password' => $settings->smtp_password,
                'mail.mailers.smtp.port' => (int) $settings->smtp_port,
                'mail.mailers.smtp.encryption' => $settings->smtp_secure ?: null,
            ]);

            Mail::send($view, $data, function ($message) use ($email, $subject, $fromName, $fromEmail, $attachmentPaths) {
                $message->to($email)
                    ->subject($subject)
                    ->from($fromEmail, $fromName);

                foreach ($attachmentPaths as $path) {
                    if (is_file($path)) {
                        $message->attach($path);
                    }
                }
            });

            return true;
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }
}
