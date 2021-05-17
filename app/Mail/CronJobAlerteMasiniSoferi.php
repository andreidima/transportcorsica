<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CronJobAlerteMasiniSoferi extends Mailable
{
    use Queueable, SerializesModels;

    public $mesaj;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mesaj)
    {
        $this->mesaj = $mesaj;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mesaj = $this->mesaj;

        $message = $this->markdown('emailuri.cronjob_alerte_masini_soferi');
        $message->subject('Alerte mașini și șoferi');

        return $message;

        // return $this->view('view.name');
    }
}
