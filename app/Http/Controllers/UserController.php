<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
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
}
