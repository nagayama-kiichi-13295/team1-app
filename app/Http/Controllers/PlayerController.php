<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        return view('player');
    }

    public function store(Request $request)
    {
        $request->validate([
            'player_name' => 'required|max:50'
        ]);

        $user = User::create([
            'user_name' => $request->player_name
        ]);

        session([
            'user_id' => $user->id,
            'user_name' => $user->user_name
        ]);

        return redirect('/character');
    }
}