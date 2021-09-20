<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CashRetirementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Alter | Solicitud de Retiro de Dinero';
    public $value;
    public $date;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($value, $date, $type)
    {
        $this->value = $value;
        $this->date  = $date;
        $this->type  = $type;
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
