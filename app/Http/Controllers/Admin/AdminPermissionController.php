<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IPermissionService;

class AdminPermissionController extends Controller
{
    private IPermissionService $permissionService;
    public function __construct(IPermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->middleware(function ($request, $next) {
            session([
                'active' => 'permission',
            ]);
            return $next($request);
        });
    }

    public function index()
    {
        $permissions = $this->permissionService->getAllPaginateLatest(15);
        $status = (object)[
            'permissionQty' => $this->permissionService->count(),
            'deletedQty' => $this->permissionService->countSoftDelete(),
        ];
        return view('admin.permissions.index', compact('permissions', 'status'));
    }

    public function create()
    {
        $htmlOptions = $this->permissionService->getSelectionPermission();
        return view('admin.permissions.add', compact('htmlOptions'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->permissionService->create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'parent_id' => $request->parent_id,
                'key_code' => $request->key_code
            ]);
            DB::commit();
            return redirect()->route('permissions.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function edit($id)
    {
        $permission = $this->permissionService->find($id);
        $htmlOptions = $this->permissionService->getSelectionPermission($permission->parent_id);
        return view('admin.permissions.edit', compact('permission', 'htmlOptions'));
    }

    public function update(Request $request, $id)
    {
        $this->permissionService->update($id, [
            'name' => $request->name,
            'display_name' => $request->display_name,
            'parent_id' => $request->parent_id,
            'key_code' => $request->key_code
        ]);
        return redirect()->route('permissions.index');
    }

    public function delete($id)
    {
        try {
            $this->permissionService->delete($id);
            $quantityDeleted = $this->permissionService->countSoftDelete();
            return response()->json([
                'code' => 200,
                'message' => 'delete success',
                'quantityDeleted' => $quantityDeleted
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'delete fail'
            ], 500);
        }
    }
}
