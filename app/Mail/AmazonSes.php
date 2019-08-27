<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AmazonSes extends Mailable
{
    use Queueable, SerializesModels;

    public $products;
    public $ref;
    public $trans;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products, $ref,$trans)
    {
        $this->products = $products;
        $this->ref = $ref;
        $this->trans = $trans;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@bigstanautos.com')->view('emails.transaction.success',
            ['products' => $this->products, 'ref' => $this->ref, 'trans' => $this->trans]
        );
    }
}
