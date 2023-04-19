<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IPermissionService;
use App\Services\Interfaces\IRoleService;

class AdminRoleController extends Controller
{
    private IRoleService $roleService;
    private IPermissionService $permissionService;

    public function __construct(IRoleService $roleService, IPermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
        $this->middleware(function ($request, $next) {
            session([
                'active' => 'role',
            ]);
            return $next($request);
        });
    }

    public function index()
    {
        $roles = $this->roleService->getAllPaginateLatest(15);
        $status = (object)[
            'roleQty' => $this->roleService->count(),
            'deletedQty' => $this->roleService->countSoftDelete(),
        ];
        return view('admin.roles.index', compact('roles', 'status'));
    }

    public function create()
    {
        $permissionsParent = $this->permissionService->getAllByWhere('parent_id', 0)->load('permissions');
        return view('admin.roles.add', compact('permissionsParent'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $insertedRole = $this->roleService->create(['name' => $request->name, 'display_name' => $request->display_name]);
            if (!empty($request->action_role)) $this->roleService->addPermissionToRole($insertedRole->id, $request->action_role);
            DB::commit();
            return redirect()->route('roles.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function edit($id)
    {
        $role = $this->roleService->find($id);
        $permissionsParent = $this->permissionService->getAllByWhere('parent_id', 0)->load('permissions');
        return view('admin.roles.edit', compact('permissionsParent', 'role'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->roleService->update($id, ['name' => $request->name, 'display_name' => $request->display_name]);
            $this->roleService->updatePermissionToRole($id, $request->action_role);
            DB::commit();
            return redirect()->route('roles.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->roleService->delete($id);
            $deletedQty = $this->roleService->countSoftDelete();
            return response()->json([
                'code' => 200,
                'message' => 'deleted success',
                'deletedQty' => $deletedQty
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
