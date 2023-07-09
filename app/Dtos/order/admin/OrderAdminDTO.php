<?php

namespace App\Dtos\order\admin;

use App\Dtos\AbstractDTO;

class OrderAdminDTO extends AbstractDTO
{
    private string $orderCode;
    private string $customerName;
    private string $total;
    private bool $status;
    private string $phoneNumber;
    private string $orderDate;

    /**
     * @param string $orderCode
     * @param string $customerName
     * @param string $total
     * @param bool $status
     * @param string $orderDate
     */
    public function __construct(
        int    $id,
        string $orderCode,
        string $customerName,
        string $total,
        bool   $status,
        string $orderDate,
        string $phoneNumber
    )
    {
        parent::setId($id);
        $this->orderCode = $orderCode;
        $this->customerName = $customerName;
        $this->total = $total;
        $this->status = $status;
        $this->orderDate = $orderDate;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getOrderCode(): string
    {
        return $this->orderCode;
    }

    /**
     * @param string $orderCode
     */
    public function setOrderCode(string $orderCode): void
    {
        $this->orderCode = $orderCode;
    }

    /**
     * @return string
     */
    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     */
    public function setCustomerName(string $customerName): void
    {
        $this->customerName = $customerName;
    }

    /**
     * @return string
     */
    public function getTotal(): string
    {
        return $this->total;
    }

    /**
     * @param string $total
     */
    public function setTotal(string $total): void
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
        return $this->orderDate;
    }

    /**
     * @param string $orderDate
     */
    public function setOrderDate(string $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }


}
