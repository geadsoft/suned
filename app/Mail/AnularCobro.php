<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnularCobro extends Mailable
{
    use Queueable, SerializesModels;

    public $correo;
    public $usuario;
    public $documento;
    public $motivo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail,$user,$documento,$motivo)
    {
        $this->correo = $mail;
        $this->usuario = $user;
        $this->documento = $documento;
        $this->motivo = $motivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail')->from("sams@americanschool.edu.ec",$this->usuario)->subject('Recibo N° '.$this->documento.' anulado..');
    }
}
