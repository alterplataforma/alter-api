<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShippingPinMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Alter | Envio de Dinero';

    public $name;
    public $pin;
    public $document;
    public $type;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $document, $pin, $type)
    {
        $this->name     = $name;
        $this->document = $document;
        $this->pin      = $pin;
        $this->type     = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.CashEmail');
    }
}
