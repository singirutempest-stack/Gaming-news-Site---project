<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;

class WelcomeMail extends Mailable
{

    public function __construct(public User $user)
    {
    }

    public function build(): self
    {
        return $this->subject('Welcome to Gaming News Portal')
            ->view('emails.welcome');
    }
}
