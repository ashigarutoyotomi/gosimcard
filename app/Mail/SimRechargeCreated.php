<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SimRechargeCreated extends Mailable
{
    use Queueable, SerializesModels;
public $simRecharge;
public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($simRecharge,$user)
    {
        $this->simRecharge = $simRecharge;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from(env('APP_NAME')
        ->text('emails.SimRechargeCreated'));
    }
}
