<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $product;
    public $customer_email;

    /**
     * Create a new message instance.
     *
     * @param $product
     * @param $message
     * @param $customer_email
     */
    public function __construct($product,$message, $customer_email)
    {
        $this->product = $product;
        $this->message = $message;
        $this->customer_email = $customer_email;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
            return $this->subject('Product Request - ' . config('app.name'))
                ->view('emails.product_request',
                    ['product' => $this->product, 'message_body' => $this->message, 'customer_email' => $this->customer_email]
                );
    }
}
