<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\MatchingController;
use App\Http\Controllers\BattleController;
use App\Events\BattleUpdated;

use App\Models\Battle;

Route::get('/', [PlayerController::class, 'index']);
Route::post('/player', [PlayerController::class, 'store']);

Route::get('/character', [CharacterController::class, 'index']);
Route::post('/character', [CharacterController::class, 'store']);

Route::get('/matching', [MatchingController::class, 'index']);

Route::get('/battle/{roomId}', [BattleController::class, 'index']);

use App\Models\Character;
use Illuminate\Http\Request;
Route::post('/attack', function (Request $request) {

    $battle = Battle::where(
        'room_id',
        $request->room_id
    )->first();

    $room = \App\Models\Room::find(
        $battle->room_id
    );

    $userId = session('user_id');


    /*
    |--------------------------------------------------------------------------
    | ターン確認
    |--------------------------------------------------------------------------
    */

    if (
        $battle->turn_player != $userId
    ) {

        return back();

    }


    $isHost =
        $userId ==
        $room->host_user_id;


    /*
    |--------------------------------------------------------------------------
    | キャラクター取得
    |--------------------------------------------------------------------------
    */

    if ($isHost) {

        $attacker = Character::find(
            $battle->player1_character_id
        );

        $defender = Character::find(
            $battle->player2_character_id
        );


    } else {


        $attacker = Character::find(
            $battle->player2_character_id
        );

        $defender = Character::find(
            $battle->player1_character_id
        );

    }


    $skill = $request->skill;



    /*
    |--------------------------------------------------------------------------
    | 攻撃力UP
    |--------------------------------------------------------------------------
    */

    if ($skill == 'attack_up') {


        if ($isHost) {


            if ($battle->player1_mp >= 10) {


                $battle->player1_mp -= 10;

                $battle->player1_attack_buff += 10;


                $battle->last_message =
                    $attacker->character_name .
                    ' の攻撃力が上がった！';


            } else {


                $battle->last_message =
                    'MPが足りない！';


            }



        } else {



            if ($battle->player2_mp >= 10) {


                $battle->player2_mp -= 10;

                $battle->player2_attack_buff += 10;


                $battle->last_message =
                    $attacker->character_name .
                    ' の攻撃力が上がった！';



            } else {


                $battle->last_message =
                    'MPが足りない！';


            }


        }


        goto turnChange;


    }




    /*
    |--------------------------------------------------------------------------
    | 防御力UP
    |--------------------------------------------------------------------------
    */

    if ($skill == 'defense_up') {


        if ($isHost) {


            if ($battle->player1_mp >= 10) {


                $battle->player1_mp -= 10;

                $battle->player1_defense_buff += 10;


                $battle->last_message =
                    $attacker->character_name .
                    ' の防御力が上がった！';



            } else {


                $battle->last_message =
                    'MPが足りない！';



            }



        } else {


            if ($battle->player2_mp >= 10) {


                $battle->player2_mp -= 10;

                $battle->player2_defense_buff += 10;


                $battle->last_message =
                    $attacker->character_name .
                    ' の防御力が上がった！';



            } else {


                $battle->last_message =
                    'MPが足りない！';



            }


        }


        goto turnChange;


    }




    /*
    |--------------------------------------------------------------------------
    | 回復
    |--------------------------------------------------------------------------
    */

    if ($skill == 'heal') {



        if ($isHost) {



            if ($battle->player1_mp >= 15) {



                $battle->player1_mp -= 15;


                $battle->player1_hp += 30;



                if (
                    $battle->player1_hp >
                    $attacker->hp
                ) {


                    $battle->player1_hp =
                        $attacker->hp;


                }



                $battle->last_message =
                    $attacker->character_name .
                    ' は30回復した！';



            } else {


                $battle->last_message =
                    'MPが足りない！';


            }



        } else {



            if ($battle->player2_mp >= 15) {


                $battle->player2_mp -= 15;


                $battle->player2_hp += 30;



                if (
                    $battle->player2_hp >
                    $attacker->hp
                ) {


                    $battle->player2_hp =
                        $attacker->hp;


                }



                $battle->last_message =
                    $attacker->character_name .
                    ' は30回復した！';



            } else {


                $battle->last_message =
                    'MPが足りない！';



            }


        }



        goto turnChange;


    }    /*
    |--------------------------------------------------------------------------
    | 回避率
    |--------------------------------------------------------------------------
    */

    $hitRate =
        95 - ($defender->speed / 2);


    if ($hitRate < 30) {

        $hitRate = 30;

    }


    if (
        rand(1,100) > $hitRate
    ) {


        $battle->last_message =
            $defender->character_name .
            ' は攻撃を回避した！';


        goto turnChange;

    }



    /*
    |--------------------------------------------------------------------------
    | 必殺技
    |--------------------------------------------------------------------------
    */

    $power = 1;


    if ($skill == 'special') {


        if ($isHost) {


            if ($battle->player1_mp < 20) {


                $battle->last_message =
                    'MPが足りない！';


                goto turnChange;


            }


            $battle->player1_mp -= 20;



        } else {



            if ($battle->player2_mp < 20) {


                $battle->last_message =
                    'MPが足りない！';


                goto turnChange;


            }


            $battle->player2_mp -= 20;


        }



        $power = 2;


    }




    /*
    |--------------------------------------------------------------------------
    | 攻撃力・防御力計算
    |--------------------------------------------------------------------------
    */


    $attackerAttack =
        $attacker->attack
        +
        (
            $isHost
            ? $battle->player1_attack_buff
            : $battle->player2_attack_buff
        );



    $defenderDefense =
        $defender->defense
        +
        (
            $isHost
            ? $battle->player2_defense_buff
            : $battle->player1_defense_buff
        );




    /*
    |--------------------------------------------------------------------------
    | ダメージ計算
    |--------------------------------------------------------------------------
    */


    $damage =
        (
            rand(
                $attackerAttack - 5,
                $attackerAttack + 5
            )
            *
            $power
        )
        -
        $defenderDefense;



    if ($damage < 1) {

        $damage = 1;

    }




    /*
    |--------------------------------------------------------------------------
    | クリティカル 固定10%
    |--------------------------------------------------------------------------
    */


    $critical = false;


    if (
        rand(1,100) <= 10
    ) {


        $damage *= 2;

        $critical = true;


    }




    /*
    |--------------------------------------------------------------------------
    | HP減少
    |--------------------------------------------------------------------------
    */


    if ($isHost) {


        $battle->player2_hp -= $damage;


        if ($battle->player2_hp < 0) {


            $battle->player2_hp = 0;


        }



    } else {



        $battle->player1_hp -= $damage;


        if ($battle->player1_hp < 0) {


            $battle->player1_hp = 0;


        }


    }




    /*
    |--------------------------------------------------------------------------
    | バトルログ
    |--------------------------------------------------------------------------
    */


    if ($critical) {


        $battle->last_message =
            '会心の一撃！ '
            .
            $damage
            .
            ' ダメージ！';



    } else {


        $battle->last_message =
            $attacker->character_name
            .
            ' の攻撃！ '
            .
            $damage
            .
            ' ダメージ！';



    }





    /*
    |--------------------------------------------------------------------------
    | 勝利判定
    |--------------------------------------------------------------------------
    */


    if (
        $battle->player1_hp <= 0
        ||
        $battle->player2_hp <= 0
    ) {



        $battle->winner_user_id =
            $userId;



        $battle->last_message =
            $attacker->character_name
            .
            ' の勝利！！';



    }




turnChange:


    /*
    |--------------------------------------------------------------------------
    | ターン交代
    |--------------------------------------------------------------------------
    */


    if (
        $battle->turn_player ==
        $room->host_user_id
    ) {


        $battle->turn_player =
            $room->guest_user_id;



    } else {



        $battle->turn_player =
            $room->host_user_id;



    }





    /*
    |--------------------------------------------------------------------------
    | MP自然回復 +5
    |--------------------------------------------------------------------------
    */


    if ($battle->player1_mp < 50) {


        $battle->player1_mp += 3;


        if ($battle->player1_mp > 50) {


            $battle->player1_mp = 50;


        }


    }



    if ($battle->player2_mp < 50) {


        $battle->player2_mp += 3;


        if ($battle->player2_mp > 50) {


            $battle->player2_mp = 50;


        }


    }





    /*
    |--------------------------------------------------------------------------
    | 保存・リアルタイム通知
    |--------------------------------------------------------------------------
    */


    $battle->save();



    broadcast(
        new BattleUpdated($battle)
    );



    return back();


});