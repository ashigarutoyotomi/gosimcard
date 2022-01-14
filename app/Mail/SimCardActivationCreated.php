<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimCardActivationCreated extends Mailable
{
    use Queueable, SerializesModels;
public $simCardActivation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($simCardActivation)
    {
        $this->simCardActivation = $simCardActivation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('APP_NAME'))
                    ->text('emails.SimCardActivaionCreated');
    }
}
