<?php

namespace App\Http\Controllers;

use Str;
use App\Models\User;
use App\Models\Sekolah;
use App\Jobs\CreateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistered;
use App\Http\Requests\StoreUserRequest;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::select('id', 'nama_sekolah')->get();
        return view('user.index', compact('sekolah'));
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
            ->addColumn('action', function ($user) {
                return '1';
            })
            ->make(true);
    }

    public function store(StoreUserRequest $request) {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->sekolah_id = $request->sekolah_id;
        $pass = Str::random(12);
        $user->password = Hash::make($pass);
        $user->save();

        $user->notify(new UserRegistered($pass));

        return response()->json(['success' => true]);
    }

    public function storewithqueue(StoreUserRequest $request) {
        $name = $request->name;
        $email = $request->email;
        $sekolah_id = $request->sekolah_id;
        CreateUser::dispatch($name, $email, $sekolah_id);

        return response()->json(['success' => true]);
    }
}
