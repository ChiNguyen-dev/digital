<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
    }

    public function searchOrders(Request $request)
    {
        $keyword = $request->input('keyword');
        $orderQuery = Order::query();
        $CustomerVariantQuery = Customer::query()
            ->orWhere('name', 'LIKE', "%$keyword%")
            ->orWhere('phone_number', 'LIKE', "%$keyword%")
            ->orWhere('email', 'LIKE', "%$keyword%")
            ->get();
        if (!$CustomerVariantQuery->isEmpty()) {
            $orderQuery =  $orderQuery->whereIn('customer_id', $CustomerVariantQuery->modelKeys())
                ->paginate(15);
        }
        return response()->json([
            'message' => $orderQuery
        ]);
    }
}
