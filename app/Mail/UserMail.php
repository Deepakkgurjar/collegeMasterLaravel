<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $email, $password;

    public function __construct($userEmail,$userPassword)
    {
        //
        $this->email = $userEmail;
        $this->password = $userPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('emails.email')
            ->with([
                'email' => $this->email,
                'password' => $this->password
            ]);
    }
}
