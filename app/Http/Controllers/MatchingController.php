<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Battle;
use App\Models\Character;

class MatchingController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $characterId = session('character_id');

        if (!$userId || !$characterId) {

            return redirect('/character');
        }

        // 自分が参加している部屋を探す
        $myRoom = Room::where('host_user_id', $userId)
            ->orWhere('guest_user_id', $userId)
            ->latest()
            ->first();


        // 対戦開始済みなら battle へ
        if ($myRoom && $myRoom->status == 1) {

            $battle = Battle::where(
                'room_id',
                $myRoom->id
            )->first();

            // 決着していないバトルだけ復帰させる
            if ($battle && !$battle->winner_user_id) {

                return redirect('/battle/' . $myRoom->id);
            }
        }



        // 空き部屋を探す
        $room = Room::whereNull('guest_user_id')
            ->where('status', 0)
            ->first();



        // 空き部屋が無いなら自分がホスト
        if (!$room) {


            Room::create([

                'host_user_id' => $userId,

                'host_character_id' => $characterId,

                'status' => 0,

            ]);


            return view('matching');
        }




        // 他人の部屋なら参加
        if ($room->host_user_id != $userId) {


            $room->guest_user_id = $userId;

            $room->guest_character_id = $characterId;

            $room->status = 1;

            $room->save();



            /*
            |--------------------------------------------------------------------------
            | キャラクター取得
            |--------------------------------------------------------------------------
            */


            $player1 = Character::find(
                $room->host_character_id
            );


            $player2 = Character::find(
                $room->guest_character_id
            );

            // どちらかのキャラが取得できない不正な部屋は破棄してやり直し
            if (!$player1 || !$player2) {

                $room->delete();

                return redirect('/character');
            }

            /*
            |--------------------------------------------------------------------------
            | Battle作成
            |--------------------------------------------------------------------------
            */


            Battle::create([

                'room_id' => $room->id,


                // DBのキャラクターHPをコピー
                'player1_hp' => $player1->hp,

                'player2_hp' => $player2->hp,


                // MP最大50
                'player1_mp' => 50,

                'player2_mp' => 50,


                // バフ初期値
                'player1_attack_buff' => 0,

                'player2_attack_buff' => 0,


                'player1_defense_buff' => 0,

                'player2_defense_buff' => 0,



                'turn_player' => $room->host_user_id,


                'player1_character_id' =>
                $room->host_character_id,


                'player2_character_id' =>
                $room->guest_character_id,

            ]);



            return redirect('/battle/' . $room->id);
        }



        return view('matching');
    }
}
