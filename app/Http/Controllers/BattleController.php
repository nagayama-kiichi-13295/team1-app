<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\Character;
use App\Models\User;
use App\Models\Room;

class BattleController extends Controller
{
    public function index($roomId)
    {
        $battle = Battle::where(
            'room_id',
            $roomId
        )->first();

        $player1 = Character::find(
            $battle->player1_character_id
        );

        $player2 = Character::find(
            $battle->player2_character_id
        );

        $room = Room::find(
            $battle->room_id
        );

        $hostUser = User::find(
            $room->host_user_id
        );

        $guestUser = User::find(
            $room->guest_user_id
        );

        return view(
            'battle',
            compact(
                'battle',
                'player1',
                'player2',
                'hostUser',
                'guestUser'
            )
        );
    }
}