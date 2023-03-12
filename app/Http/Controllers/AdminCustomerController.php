<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminCustomerController extends Controller
{
    private $customer;
    private $numberOfPage = 15;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function index()
    {
        $customers = $this->customer->latest()->paginate($this->numberOfPage);
        $qtyDeleted = $this->customer->onlyTrashed()->count();
        return view('admin.orders.customer', compact('customers', 'qtyDeleted'));
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->customer->find($request->id)->delete();
            $quantityDeleted = $this->customer->onlyTrashed()->count();
            return response()->json([
                'code' => 200,
                'message' => 'had deleted',
                'quantityDeleted' => $quantityDeleted
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Deleted fail'
            ], 500);
        }
    }
}
