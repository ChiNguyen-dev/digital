<?php

namespace App\Mappers;

use App\Builders\order\dashboard\OrderDashboardBuilder;
use App\Builders\order\OrderAdminBuilder;
use App\Dtos\order\admin\OrderAdminDTO;
use App\Models\CustomerVariant;
use App\Models\Order;

class OrderMapper
{
    public static function toOrderDashboard(CustomerVariant $customerVariant)
    {
        return $customerVariant->orders->map(function ($order) use ($customerVariant) {
            return (new OrderDashboardBuilder($order->id))
                ->orderCode($order->code)
                ->customerName($customerVariant->name)
                ->phoneNumber($customerVariant->phone_number)
                ->total($order->total)
                ->status($order->status)
                ->orderDate($order->created_at->format('d/m/Y h:i:s'))
                ->build();
        });
    }

    public static function toOrderAdminDTO(Order $order): OrderAdminDTO
    {
        $customer = $order->customer;
        return (new OrderAdminBuilder($order->id))
            ->orderCode($order->code)
            ->customerName($customer->name)
            ->total($order->total)
            ->status($order->status)
            ->orderDate($order->created_at->format('d/m/Y h:i:s'))
            ->phoneNumber($customer->phone_number)
            ->build();
    }
}
