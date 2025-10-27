<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Divisi;

class UserDivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::all();

        return view('user.divisi', compact('divisis'));
    }

    public function show(Divisi $divisi)
    {
        return view('user.divisi-show', compact('divisi'));
    }
}
