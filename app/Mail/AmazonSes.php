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
    public $type;

    /**
     * Create a new message instance.
     *
     * @param $ref
     * @param $trans
     * @param $cart
     * @param string $type
     */
    public function __construct($ref,$trans, $cart, $type = 'non_delivery')
    {
        $this->ref = $ref;
        $this->trans = $trans;
        $this->cart = $cart;
        $this->type = $type;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type == 'non_delivery') {
            return $this->from('support@bigstanautos.com', env('APP_NAME'))
                ->cc(['sales@mandmonlinestore.com'])
                ->subject('Transaction Receipt - MandMOnlineStore.com')
                ->view('emails.transaction.success',
                    ['ref' => $this->ref, 'trans' => $this->trans, 'cart' => $this->cart]
                );
        }else{
            return $this->from('support@bigstanautos.com', env('APP_NAME'))
                ->cc(['sales@mandmonlinestore.com'])
                ->subject('Transaction Receipt - MandMOnlineStore.com')
                ->view('emails.transaction.delivery',
                    ['ref' => $this->ref, 'trans' => $this->trans, 'cart' => $this->cart]
                );
        }
    }
}
