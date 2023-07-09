<?php

namespace App\Builders\order;

use App\Dtos\order\admin\OrderAdminDTO;

class OrderAdminBuilder implements IOrderAdminBuilder
{
    protected int $id;
    protected string $orderCode;
    protected string $customerName;
    protected string $total;
    protected bool $status;
    protected string $orderDate;
    protected string $phoneNumber;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    function orderCode(string $orderCode): OrderAdminBuilder
    {
        $this->orderCode = $orderCode;
        return $this;
    }

    function customerName(string $customerName): OrderAdminBuilder
    {
        $this->customerName = $customerName;
        return $this;
    }

    function total(string $total): OrderAdminBuilder
    {
        $this->total = $total;
        return $this;
    }

    function status(string $status): OrderAdminBuilder
    {
        $this->status = $status;
        return $this;
    }

    function orderDate(string $orderDate): OrderAdminBuilder
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    function phoneNumber(string $phoneNumber): OrderAdminBuilder
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    function build(): OrderAdminDTO
    {
        return new OrderAdminDTO(
            $this->id,
            $this->orderCode,
            $this->customerName,
            $this->total,
            $this->status,
            $this->orderDate,
            $this->phoneNumber
        );
    }


}
