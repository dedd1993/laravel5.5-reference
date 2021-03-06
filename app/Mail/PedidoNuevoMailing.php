<?php

namespace App\Mail;

use App\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PedidoNuevoMailing extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;
    public $envio;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pedido $pedido, $envio)
    {
        $this->pedido = $pedido;
        $this->envio = $envio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->pedido->detalles[0]['is_giftcard'])
            $subject = "Craftimes: Tu compra se ha realizado con éxito";
        else
            $subject = "Craftimes: Tu suscripción se ha realizado con éxito";

        return $this->from('contacto@craftimes.com', 'Craftimes')
                    ->to($this->pedido->cliente['email'])
                    ->cc([env('CRAFTIMES_EMAIL_CC_PEDIDO')])
                    ->subject($subject)
                    ->view('email.pedidonuevo');
    }
}
