<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICustomerService;

class AdminCustomerController extends Controller
{
    private ICustomerService $customerService;
    private $numberOfPage = 15;

    public function __construct(ICustomerService $customerService)
    {
        $this->customerService = $customerService;
        $this->middleware(function ($request, $next) {
            session([
                'active' => 'sell',
            ]);
            return $next($request);
        });
    }

    public function index()
    {
        $customers = $this->customerService->getAllPaginateLatest($this->numberOfPage);
        $qtyDeleted = $this->customerService->countSoftDelete();
        return view('admin.orders.customer', compact('customers', 'qtyDeleted'));
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->customerService->delete($request->id);
            $quantityDeleted = $this->customerService->countSoftDelete();
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
