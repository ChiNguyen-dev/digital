<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    private $user;
    private $role;
    private $userRepo;

    public function __construct(User $user, Role $role, IUserRepository $userRepo)
    {
        $this->user = $user;
        $this->role = $role;
        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $users = $this->user->where('name', 'Like', "%{$request->search}%")
                ->orWhere('email', 'Like', "%{$request->search}%")
                ->latest()->paginate(15);
        } else {
            $users = $this->user->latest()->paginate(15);
        }
        $status = (object)[
            'quantity' => $this->user->where('deleted_at', '=', null)->count(),
            'deleted' => $this->user->onlyTrashed()->count(),
        ];
        return view('admin.users.index', compact('users', 'status'));
    }

    public function create(): View
    {
        $roles = $this->role->all();
        return view('admin.users.add', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $insertedUser = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $insertedUser->roles()->attach($request->role_id);
            DB::commit();
            return redirect()->route('users.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function edit($id): View
    {
        $user = $this->user->find($id);
        $roles = $this->role->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = $this->user->find($id);
        $user->update(['name' => $request->name, 'email' => $request->email,]);
        $user->roles()->sync($request->role_id);
        return redirect()->route('users.index');
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->user->find($id)->delete();
            $countUserDeleted = $this->user->onlyTrashed()->count();
            return response()->json([
                'code' => 200,
                'message' => 'Delete success',
                'quantity' => $countUserDeleted
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Delete fail'
            ], 500);
        }
    }

    public function account(): View
    {
        $user = $this->user->find(Auth::id());
        return view('admin.users.account', compact('user'));
    }

    public function accountUpdate(Request $request, $id): RedirectResponse
    {
        $user = $this->user->find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);
        return redirect()->route('admin.dashboard');
    }


    public function changePassword(UserRequest $request, $id): RedirectResponse
    {
        $user = $this->user->find($id);
        $oldPass = $request->passCurrent;
        if (Hash::check($oldPass, $user->password)) {
            if ($request->password == $request->passConfirm) {
                $this->user->find($id)->update(['password' => bcrypt($request->password)]);
                return redirect()->route('admin.logout');
            }
        }
        return redirect()->route('users.editPassword');
    }
}
