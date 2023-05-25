<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmOrder extends Mailable
{
    use Queueable, SerializesModels;

    public object $order;
    public object $user;
    public object $cartItems;
    public int $subTotal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(object $order, object $user, object $cartItems, int $subTotal)
    {
        $this->order = $order;
        $this->user = $user;
        $this->cartItems = $cartItems;
        $this->subTotal = $subTotal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ConfirmOrder
    {
        return $this->view('mails.confirmOrder')
            ->from('nguyendev2001@gmail.com', 'Võ Chí Nguyên')
            ->subject('[Digital.com] Thông tin đơn hàng');
    }
}
