<?php

namespace App\Http\Controllers;

use Str;
use App\Models\User;
use App\Models\Sekolah;
use App\Jobs\CreateUser;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistered;
use App\Http\Requests\StoreUserRequest;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::select('id', 'nama_sekolah')->get();
        $roles = Role::select('id', 'name')->get();
        $permissions = Permission::select('id', 'name')->get();
        return view('user.index', compact('sekolah', 'roles', 'permissions'));
    }

    public function ajaxLoadUser(Request $request){
        $user = User::with(['sekolah' => function($query) {
            $query->select('id', 'nama_sekolah');
        }, 'roles', 'permissions'])->findOrFail($request->id);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function ajaxLoadUsers(Request $request)
    {
        $users = User::with(['sekolah'=>function($query) {
            $query->select('id', 'nama_sekolah');
        }]);
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('sekolah', function ($user) {
                return $user->sekolah->nama_sekolah;
            })
            ->addColumn('roles_permissions', function ($user) {
                $roles = '';
                foreach ($user->getRoleNames() as $role) {
                    $roles .= '<span class="badge badge-primary">' . $role . '</span> ';
                }
                $permissions = '';
                foreach ($user->getDirectPermissions() as $permission) {
                    $permissions .= '<span class="badge badge-secondary">' . $permission->name . '</span> ';
                }
                return $roles . $permissions;
            })
            ->addColumn('action', function ($user) {
                $editButton = '';
                if(Auth::user()->can('edit users')) {
                    $editButton = '<button class="btn btn-sm btn-primary edit-user" data-id="' . $user->id . '">Edit</button>';
                }

                if(Auth::user()->can('delete users')) {
                    $deleteButton = '<button class="btn btn-sm btn-danger delete-user" data-id="' . $user->id . '">Delete</button>';
                } else {
                    $deleteButton = '';
                }
                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['roles_permissions', 'action'])
            ->make(true);
    }

    public function store(StoreUserRequest $request) {
        if($request->has('id') && $request->id != '') {
            $user = User::findOrFail($request->id);
        } else {
            $user = new User();
            $pass = Str::random(12);
            $user->password = Hash::make($pass);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->sekolah_id = $request->sekolah_id;

        $user->save();
        if(!$request->has('id') && $request->id == '') {
            $user->notify(new UserRegistered($pass));
        }

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        return response()->json(['success' => true]);
    }

    public function storewithqueue(StoreUserRequest $request) {
        $name = $request->name;
        $email = $request->email;
        $sekolah_id = $request->sekolah_id;
        CreateUser::dispatch($name, $email, $sekolah_id);

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);
        if ($user->id == Auth::id()) {
            return response()->json(['success' => false, 'message' => 'You cannot delete your own account.']);
        }
        $user->delete();
        return response()->json(['success' => true]);
    }
}
