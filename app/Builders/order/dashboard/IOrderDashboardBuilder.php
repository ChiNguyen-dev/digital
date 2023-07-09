<?php

namespace App\Builders\order\dashboard;

use App\Dtos\order\admin\OrderDashBoardDTO;

interface IOrderDashboardBuilder
{
    function orderCode(string $order_code): OrderDashboardBuilder;

    function customerName(string $customer_name): OrderDashboardBuilder;

    function phoneNumber(string $phone_number): OrderDashboardBuilder;

    function total(int $total): OrderDashboardBuilder;

    function status(bool $status): OrderDashboardBuilder;

    function orderDate(string $order_date): OrderDashboardBuilder;

    function build(): OrderDashBoardDTO;
}
