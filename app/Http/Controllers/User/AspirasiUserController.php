<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AspirasiUserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pesan' => 'required|string',
        ]);

        Aspirasi::create($request->all());

        return back()->with('ok', 'Terima kasih, aspirasi Anda telah kami terima.')->withFragment('aspirasi-form');
    }
}
