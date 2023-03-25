<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IPermissionRepository;
use App\Repositories\Interfaces\IRoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRoleController extends Controller
{
    private $roleRepo;
    private $permissionRepo;

    public function __construct(IRoleRepository $iRoleRepository, IPermissionRepository $iPermissionRepository)
    {
        $this->roleRepo = $iRoleRepository;
        $this->permissionRepo = $iPermissionRepository;
    }

    public function index()
    {
        $roles = $this->roleRepo->getAllPaginateLatest(15);
        $status = (object)[
            'roleQty' => $this->roleRepo->count(),
            'deletedQty' => $this->roleRepo->countSoftDelete(),
        ];
        return view('admin.roles.index', compact('roles', 'status'));
    }

    public function create()
    {
        $permissionsParent = $this->permissionRepo->getAllByWhere('parent_id', 0)->load('permissions');
        return view('admin.roles.add', compact('permissionsParent'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $insertedRole = $this->roleRepo->create(['name' => $request->name, 'display_name' => $request->display_name]);
            if (!empty($request->action_role)) $this->roleRepo->addPermissionToRole($insertedRole->id, $request->action_role);
            DB::commit();
            return redirect()->route('roles.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function edit($id)
    {
        $role = $this->roleRepo->find($id);
        $permissionsParent = $this->permissionRepo->getAllByWhere('parent_id', 0)->load('permissions');
        return view('admin.roles.edit', compact('permissionsParent', 'role'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->roleRepo->update($id, ['name' => $request->name, 'display_name' => $request->display_name]);
            $this->roleRepo->updatePermissionToRole($id, $request->action_role);
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
            $this->roleRepo->delete($id);
            $deletedQty = $this->roleRepo->countSoftDelete();
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
