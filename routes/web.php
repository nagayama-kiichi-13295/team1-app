<?php
use App\Events\TestMessage;
use Illuminate\Support\Facades\Route;
use App\Events\HandPlayed;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/play/{player}/{hand}', function ($player, $hand) {

    event(new HandPlayed($player, $hand));

    return 'OK';
});