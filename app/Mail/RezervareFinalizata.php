<?php

namespace App\Mail;

use App\Models\Rezervare;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RezervareFinalizata extends Mailable
{
    use Queueable, SerializesModels;

    public $rezervare_tur;
    public $rezervare_retur;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Rezervare $rezervare_tur)
    {
        $this->rezervare_tur = $rezervare_tur;

        if (!$rezervare_tur->retur) {
            $this->rezervare_retur = null;
        } else {
            $this->rezervare_retur = Rezervare::find($rezervare_tur->retur);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $rezervare_tur = $this->rezervare_tur;
        $rezervare_retur = $this->rezervare_retur;

        $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervare_tur', 'rezervare_retur'))
            ->setPaper('a4');

        $message = $this->markdown('emailuri.rezervare-finalizata');

        $message->subject('Rezervare MRW Transport');

        $message->attachData($pdf->output(), 'Rezervare MRW Transport Corsica.pdf');

        if ($rezervare_tur->factura){
            $factura = $rezervare_tur->factura;
            $factura_pdf = \PDF::loadView('facturi.export.factura', compact('factura'))
                ->setPaper('a4');
            $message->attachData( $factura_pdf->output(), 'Factura MRW Transport Corsica.pdf');
        }

        return $message;
    }
}
