<?php

namespace App\Builders\order\dashboard;

use App\Dtos\order\admin\OrderDashBoardDTO;

class OrderDashboardBuilder implements IOrderDashboardBuilder
{
    protected int $id;
    protected string $order_code;
    protected string $customer_name;
    protected string $phone_number;
    protected int $total;
    protected bool $status;
    protected string $order_date;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function orderCode(string $order_code): OrderDashboardBuilder
    {
        $this->order_code = $order_code;
        return $this;
    }

    public function customerName(string $customer_name): OrderDashboardBuilder
    {
        $this->customer_name = $customer_name;
        return $this;
    }

    public function phoneNumber(string $phone_number): OrderDashboardBuilder
    {
        $this->phone_number = $phone_number;
        return $this;
    }

    public function total(int $total): OrderDashboardBuilder
    {
        $this->total = $total;
        return $this;
    }

    function status(bool $status): OrderDashboardBuilder
    {
        $this->status = $status;
        return $this;
    }

    function orderDate(string $order_date): OrderDashboardBuilder
    {
        $this->order_date = $order_date;
        return $this;
    }

    function build(): OrderDashBoardDTO
    {
        return new OrderDashBoardDTO(
            $this->id,
            $this->order_code,
            $this->customer_name,
            $this->phone_number,
            $this->total,
            $this->status,
            $this->order_date
        );
    }
}
