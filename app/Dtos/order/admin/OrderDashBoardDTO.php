<?php

namespace App\Dtos\order\admin;

use App\Dtos\AbstractDTO;

class OrderDashBoardDTO extends AbstractDTO
{
    private string $order_code;
    private string $customer_name;
    private string $phone_number;
    private int $total;
    private bool $status;
    private string $order_date;

    /**
     * @param string $order_code
     * @param string $customer_name
     * @param string $phone_number
     * @param int $total
     * @param bool $status
     * @param string $order_date
     */
    public function __construct(
        int    $id,
        string $order_code,
        string $customer_name,
        string $phone_number,
        int    $total,
        bool   $status,
        string $order_date)
    {
        parent::setId($id);
        $this->order_code = $order_code;
        $this->customer_name = $customer_name;
        $this->phone_number = $phone_number;
        $this->total = $total;
        $this->status = $status;
        $this->order_date = $order_date;
    }

    /**
     * @return string
     */
    public function getOrderCode(): string
    {
        return $this->order_code;
    }

    /**
     * @param string $order_code
     */
    public function setOrderCode(string $order_code): void
    {
        $this->order_code = $order_code;
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        return $this->customer_name;
    }

    /**
     * @param string $customer_name
     */
    public function setCustomerName(string $customer_name): void
    {
        $this->customer_name = $customer_name;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber(string $phone_number): void
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getOrderDate(): string
    {
        return $this->order_date;
    }

    /**
     * @param string $order_date
     */
    public function setOrderDate(string $order_date): void
    {
        $this->order_date = $order_date;
    }

}
