<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendResetEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $signedUrl;

    public function __construct($user, $signedUrl)
    {
        $this->user = $user;
        $this->signedUrl = $signedUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Reset Email Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
{
    return $this->html("
    <html>
        <head>
            <title>Reset Email</title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h2>Halo, $this->user!</h2>
        <p>Anda telah meminta untuk mengubah alamat email pada akun Anda. Untuk melanjutkan proses perubahan email, silakan klik tautan di bawah ini:</p>
        
        <strong><a href='$this->signedUrl' class='btn'>Konfirmasi Perubahan Email</a></strong>

        <p>Harap diingat, tautan ini hanya berlaku selama <strong>10 menit</strong>. Jika Anda tidak mengajukan permintaan ini, harap abaikan email ini.</p>

        <div class='footer'>
            Terima kasih, <br>
            <strong>ANL e-commerce</strong>
        </div>
    </div>
    </html>
    ");
}
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
