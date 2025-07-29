<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display users
        return view('user.index'); // Assuming you have a user/index.blade.php view
    }
}
