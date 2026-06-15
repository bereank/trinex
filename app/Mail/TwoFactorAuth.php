<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TwoFactorAuth extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;

    public $otp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $otp)
    {
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->
            subject('Express Way SAP Password Reset Verification')
            ->markdown('mail.TwoFactor')
            ->with('user', $this->user)
            ->with('opt', $this->otp);
    }
}
