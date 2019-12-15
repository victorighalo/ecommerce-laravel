<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AmazonSes extends Mailable
{
    use Queueable, SerializesModels;

    public $ref;
    public $trans;
    public $cart;

    /**
     * Create a new message instance.
     *
     * @param $ref
     * @param $trans
     * @param $cart
     */
    public function __construct($ref,$trans, $cart)
    {
        $this->ref = $ref;
        $this->trans = $trans;
        $this->cart = $cart;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@bigstanautos.com', env('APP_NAME'))->subject('Transaction Receipt - MandMOnlineStore.com')->view('emails.transaction.success',
            ['ref' => $this->ref, 'trans' => $this->trans, 'cart' => $this->cart]
        );
    }
}
