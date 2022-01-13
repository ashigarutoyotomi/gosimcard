<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimCardActivated extends Mailable
{
    use Queueable, SerializesModels;
public $simCardActivated;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($simCardActivated)
    {
        $this->simCardActivated = $simCardActivated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('APP_NAME'))
                    ->text('emails.SimCardActivated');
    }
}
