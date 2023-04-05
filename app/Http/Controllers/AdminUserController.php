<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserRequest;
use App\Repositories\Interfaces\IRoleRepository;
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
    private $roleRepo;
    private $userRepo;

    public function __construct(IRoleRepository $iRoleRepositorye, IUserRepository $userRepo)
    {
        $this->roleRepo = $iRoleRepositorye;
        $this->userRepo = $userRepo;
        $this->middleware(function ($request, $next) {
            session([
                'active' => 'user',
            ]);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $users = $request->has('search') ?
            $this->userRepo->searchUsers($request->search) :
            $this->userRepo->getAllPaginateLatest(15);
        $status = (object)[
            'quantity' =>  $this->userRepo->count(),
            'deleted' =>  $this->userRepo->countSoftDelete(),
        ];
        return view('admin.users.index', compact('users', 'status'));
    }

    public function create(): View
    {
        $roles = $this->roleRepo->getAll();
        return view('admin.users.add', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $insertedUser = $this->userRepo->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $this->userRepo->addRoleToUser($insertedUser->id, $request->role_id);
            DB::commit();
            return redirect()->route('users.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function edit($id): View
    {
        $user = $this->userRepo->find($id);
        $roles = $this->roleRepo->getAll();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->userRepo->update($id, ['name' => $request->name, 'email' => $request->email,]);
        $this->userRepo->updateRoleToUser($id, $request->role_id);
        return redirect()->route('users.index');
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->userRepo->delete($id);
            $countUserDeleted = $this->userRepo->countSoftDeletedUsers();
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
        $user = $this->userRepo->find(Auth::id());
        return view('admin.users.account', compact('user'));
    }

    public function accountUpdate(Request $request, $id): RedirectResponse
    {
        $user = $this->userRepo->update($id, [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);
        return redirect()->route('admin.dashboard');
    }


    public function changePassword(UserRequest $request, $id): RedirectResponse
    {
        $user = $this->userRepo->find($id);
        $oldPass = $request->passCurrent;
        if (Hash::check($oldPass, $user->password)) {
            if ($request->password == $request->passConfirm) {
                $this->userRepo->update($id, ['password' => bcrypt($request->password)]);
                return redirect()->route('admin.logout');
            }
        }
        return redirect()->route('users.editPassword');
    }
}
