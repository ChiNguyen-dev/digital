<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CategoryRecursive;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\ICustomerService;
use App\Services\Interfaces\IProDisWardService;

class AccountController extends Controller
{
    private CategoryRecursive $categoryRecursive;
    private IProDisWardService $proDisWardService;
    private ICustomerService $customerService;

    public function __construct(
        CategoryRecursive $categoryRecursive,
        IProDisWardService $proDisWardService,
        ICustomerService $customerService
    ) {
        $this->categoryRecursive = $categoryRecursive;
        $this->proDisWardService = $proDisWardService;
        $this->customerService = $customerService;
    }

    public function account()
    {
        ['megaMenuHeader' => $megaMenuHeader, 'menuResponse' => $menuResponse]
            = $this->categoryRecursive->menu('megaMenuHeader', 'menuResponse');
        $provinces = $this->proDisWardService->getProvinces();
        return
            View(
                'client.account.index',
                compact(
                    'megaMenuHeader',
                    'menuResponse',
                    'provinces',
                )
            );
    }

    public function updateAccount(Request $request)
    {
        if ($request->province != null) {
            $province = $this->proDisWardService->getProvinceByMatp($request->province);
            $district = $this->proDisWardService->getDistrictByMaqh($request->district);
            $ward = $this->proDisWardService->getWardByXaid($request->ward);
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => "$ward->name , $district->name ,$province->name .",
                'phone_number' => $request->phone_number,
            ];
            $this->customerService->update(Auth::guard('client')->id(), $data);
        }
        return redirect()->back();
    }

    public function validation(Request $request)
    {
        try {
            $code = 200;
            $message =  "Email address isn't registered";
            if ($this->customerService->findByEmail($request->email)) {
                $code = 422;
                $message = 'Địa chỉ email đã được đăng ký';
            }
            return response()->json([
                'message' => $message,
            ], $code);
        } catch (\Exception $exception) {
            Log::error("Message: " . $exception->getMessage() . " Line: " . $exception->getLine());
            return response()->json([
                'error' => 'Internal Server Error',
            ], 500);
        }
    }

    public function chooseAddress(Request $request)
    {
        try {
            $data = null;
            $id = $request->id;
            if (Str::upper($request->key) == 'PROVINCE') {
                $data = $this->proDisWardService->getDistrictsByMatp($id);
            }
            if (Str::upper($request->key) == 'DISTRICT') {
                $data = $this->proDisWardService->getWardsByMaqh($id);
            }
            return response()->json([
                'message' => 'Successfully',
                'data' => $data
            ], 200);
        } catch (\Exception $exception) {
            Log::error("Message: " . $exception->getMessage() . " Line: " . $exception->getLine());
            return response()->json([
                'error' => 'Internal Server Error',
            ], 500);
        }
    }
}
