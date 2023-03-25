<?php

namespace App\Http\Controllers;

use App\Helpers\Recursive;
use App\Repositories\Interfaces\IPermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminPermissionController extends Controller
{
    private $permissionRepo;
    private $recursive;

    public function __construct(IPermissionRepository $iPermissionRepository, Recursive $recursive)
    {
        $this->permissionRepo = $iPermissionRepository;
        $this->recursive = $recursive;
    }

    public function index()
    {
        $permissions = $this->permissionRepo->getAllPaginateLatest(15);
        $status = (object)[
            'permissionQty' => $this->permissionRepo->count(),
            'deletedQty' => $this->permissionRepo->countSoftDelete(),
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
            $this->permissionRepo->create([
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
        $permission = $this->permissionRepo->find($id);
        $htmlOptions = $this->recursive->permissionRecursive($permission->parent_id);
        return view('admin.permissions.edit', compact('permission', 'htmlOptions'));
    }

    public function update(Request $request, $id)
    {
        $this->permissionRepo->update($id, [
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
            $this->permissionRepo->delete($id);
            $quantityDeleted = $this->permissionRepo->countSoftDelete();
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
