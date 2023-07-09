<?php

namespace App\Builders\order;

use App\Dtos\order\admin\OrderAdminDTO;

interface IOrderAdminBuilder
{
    function orderCode(string $orderCode): OrderAdminBuilder;

    function customerName(string $customerName): OrderAdminBuilder;

    function total(string $total): OrderAdminBuilder;

    function status(string $status): OrderAdminBuilder;

    function orderDate(string $orderDate): OrderAdminBuilder;
    function phoneNumber(string $phoneNumber): OrderAdminBuilder;

    function build(): OrderAdminDTO;
}
