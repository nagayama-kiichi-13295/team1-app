<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();

        return view('character', compact('characters'));
    }

    public function store(Request $request)
    {
        session([
            'character_id' => $request->character_id
        ]);

        return redirect('/matching');
    }
}