<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ICustomerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminCustomerController extends Controller
{
    private ICustomerRepository $customerRepo;
    private $numberOfPage = 15;

    public function __construct(ICustomerRepository $iCustomerRepository)
    {
        $this->customerRepo = $iCustomerRepository;
    }

    public function index()
    {
        $customers = $this->customerRepo->getAllPaginateLatest($this->numberOfPage);
        $qtyDeleted = $this->customerRepo->countSoftDelete();
        return view('admin.orders.customer', compact('customers', 'qtyDeleted'));
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->customerRepo->delete($request->id);
            $quantityDeleted = $this->customerRepo->countSoftDelete();
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
