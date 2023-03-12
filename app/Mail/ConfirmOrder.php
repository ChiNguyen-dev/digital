<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmOrder extends Mailable
{
    use Queueable, SerializesModels;


    public $order;
    public $user;
    public $shopping;
    public $subTotal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(object $order, object $user, object $shopping, string $subTotal)
    {
        $this->order = $order;
        $this->user = $user;
        $this->shopping = $shopping;
        $this->subTotal = $subTotal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.confirmOrder')
            ->from('nguyendev2001@gmail.com', 'Võ Chí Nguyên')
            ->subject('[Digital.com] Thông tin đơn hàng');
    }
}
