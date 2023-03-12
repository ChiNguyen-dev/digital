<?php

namespace App\Http\Controllers;

use App\component\Recursive;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPermissionController extends Controller
{
    private $permission;
    private $recursive;

    public function __construct(Permission $permission, Recursive $recursive)
    {
        $this->permission = $permission;
        $this->recursive = $recursive;
    }

    public function index()
    {
        $permissions = $this->permission->latest()->paginate(15);
        $status = (object)[
            'permissionQty' => $this->permission->all()->count(),
            'deletedQty' => $this->permission->onlyTrashed()->count()
        ];
        return view('admin.permissions.index', compact('permissions', 'status'));
    }

    public function create()
    {
        $htmlOptions = $this->recursive->permissionRecursive();
        return view('admin.permissions.add', compact('htmlOptions'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $this->permission->create([
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
        $permission = $this->permission->find($id);
        $htmlOptions = $this->recursive->permissionRecursive($permission->parent_id);
        return view('admin.permissions.edit', compact('permission', 'htmlOptions'));
    }

    public function update(Request $request, $id)
    {
        $this->permission->find($id)->update([
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
            $this->permission->find($id)->delete();
            $quantityDeleted = $this->permission->onlyTrashed()->count();
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
