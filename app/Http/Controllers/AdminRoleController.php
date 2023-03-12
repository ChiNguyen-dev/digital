<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRoleController extends Controller
{
    private $role;
    private $permission;

    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index()
    {
        $roles = $this->role->latest()->paginate(15);
        $status = (object)[
            'roleQty' => count($roles),
            'deletedQty' => $this->role->onlyTrashed()->count()
        ];
        return view('admin.roles.index', compact('roles', 'status'));
    }

    public function create()
    {
        $permissionsParent = $this->permission->where('parent_id', 0)->get();
        return view('admin.roles.add', compact('permissionsParent'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $insertedRole = $this->role->create(['name' => $request->name, 'display_name' => $request->display_name]);
            if (!empty($request->action_role)) $insertedRole->permissions()->attach($request->action_role);
            DB::commit();
            return redirect()->route('roles.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function edit($id)
    {
        $role = $this->role->find($id);
        $permissionsParent = $this->permission->where('parent_id', 0)->get();
        return view('admin.roles.edit', compact('permissionsParent', 'role'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $role = $this->role->find($id);
            $role->update(['name' => $request->name, 'display_name' => $request->display_name]);
            if (!empty($request->action_role)) $role->permissions()->sync($request->action_role);
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
            $this->role->find($id)->delete();
            $deletedQty = $this->role->onlyTrashed()->count();
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
