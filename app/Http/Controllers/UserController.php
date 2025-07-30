<?php

namespace App\Http\Controllers;

use Str;
use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        $pass = Hash::make(Str::random(12));
        $user->password = $pass;
        $user->save();

        return response()->json(['success' => true]);
    }
}
