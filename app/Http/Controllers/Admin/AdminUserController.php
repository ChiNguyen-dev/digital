<?php

namespace App\Http\Controllers\Admin;

use App\Traits\StatisticTrait;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\Interfaces\IRoleService;
use App\Services\Interfaces\IUserService;

class AdminUserController extends Controller
{
    use StatisticTrait;
    private IRoleService $roleService;
    private IUserService $userService;

    public function __construct(IRoleService $roleService, IUserService $userService)
    {
        $this->roleService = $roleService;
        $this->userService = $userService;
        $this->middleware(function ($request, $next) {
            session(['active' => 'user']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $users = $request->has('search') ?
            $this->userService->searchUsers($request->search) :
            $this->userService->getUsers(15);
        $statistic = $this->statistic('user');
        $status = (object)[
            'quantity' => $statistic->user_amount,
            'deleted' => $statistic->user_cancel,
        ];
        return view(
            'admin.users.index',
            compact(
                'users',
                'status'
            )
        );
    }

    public function create(): View
    {
        $roles = $this->roleService->getAll();
        return view('admin.users.add', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $this->userService->addRoleToUser($user->id, $request->role_id);
            DB::commit();
            return redirect()->route('users.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function edit($id): View
    {
        $user = $this->userService->find($id);
        $roles = $this->roleService->getAll();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->userService->update($id, $request->all());
        return redirect()->route('users.index');
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->userService->delete($id);
            $statistic = $this->statistic('user');
            $countUserDeleted = $statistic->user_cancel;
            return response()->json([
                'code' => 200,
                'message' => 'Deleted successfully',
                'quantity' => $countUserDeleted
            ]);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Deleted failed'
            ], 500);
        }
    }

    public function account(): View
    {
        $user = $this->userService->find(Auth::id());
        return view('admin.users.account', compact('user'));
    }

    public function accountUpdate(Request $request, $id): RedirectResponse
    {
        $user = $this->userService->update($id, [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);
        return redirect()->route('admin.dashboard');
    }


    public function changePassword(UserRequest $request, $id): RedirectResponse
    {
        $user = $this->userService->find($id);
        $oldPass = $request->passCurrent;
        if (Hash::check($oldPass, $user->password)) {
            if ($request->password == $request->passConfirm) {
                $this->userService->update($id, ['password' => bcrypt($request->password)]);
                return redirect()->route('admin.logout');
            }
        }
        return redirect()->route('users.editPassword');
    }
}
