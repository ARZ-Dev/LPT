<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

class MailService {

    public function notify($user, $subject, $body)
    {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = config('mail.mailers.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.mailers.smtp.username');
            $mail->Password = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = config('mail.mailers.smtp.encryption');
            $mail->Port = config('mail.mailers.smtp.port');
            // $mail->SMTPDebug  = 1;

            // Recipients
            $mail->setFrom(config('mail.mailers.smtp.username'), 'LPT');
            $mail->addAddress($user->email, $user->username);

            // Content
            $mail->isHTML();
            $mail->Subject = $subject;

            $mail->Body = view('email-templates.default', ['user' => $user, 'subject' => $subject, 'body' => $body])->render();

            $mail->send();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
