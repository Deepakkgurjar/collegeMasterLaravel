<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotOtp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $email, $otp;
    public function __construct($UserEmail, $UserOtp)
    {
        $this->email = $UserEmail;
        $this->otp = $UserOtp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.emailOtp')
            ->with([
                'email' => $this->email,
                'otp' => $this->otp
            ]);
    }


}
