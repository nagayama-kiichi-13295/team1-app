<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>バケモンバトル2</title>

    @vite([
        'resources/js/app.js'
    ])
</head>

<body class="battle-page">

@php
    // ログイン中のユーザーが host か guest かで
    // 「自分」と「相手」を入れ替える
    $isHost = session('user_id') == $hostUser->id;

    $meUser        = $isHost ? $hostUser : $guestUser;
    $meChar        = $isHost ? $player1  : $player2;
    $meHp          = $isHost ? $battle->player1_hp : $battle->player2_hp;
    $meMp          = $isHost ? $battle->player1_mp : $battle->player2_mp;
    $meAtkBuff     = $isHost ? $battle->player1_attack_buff  : $battle->player2_attack_buff;
    $meDefBuff     = $isHost ? $battle->player1_defense_buff : $battle->player2_defense_buff;

    $opUser        = $isHost ? $guestUser : $hostUser;
    $opChar        = $isHost ? $player2   : $player1;
    $opHp          = $isHost ? $battle->player2_hp : $battle->player1_hp;
    $opMp          = $isHost ? $battle->player2_mp : $battle->player1_mp;
    $opAtkBuff     = $isHost ? $battle->player2_attack_buff  : $battle->player1_attack_buff;
    $opDefBuff     = $isHost ? $battle->player2_defense_buff : $battle->player1_defense_buff;

    // HP割合（0除算を避ける）
    $meRate = $meChar->hp > 0 ? ($meHp / $meChar->hp) * 100 : 0;
    $opRate = $opChar->hp > 0 ? ($opHp / $opChar->hp) * 100 : 0;

    // 残量によってバーの色を変える
    $hpClass = function ($rate) {
        if ($rate <= 20) return 'hp-low';
        if ($rate <= 50) return 'hp-mid';
        return 'hp-high';
    };

    $isMyTurn = session('user_id') == $battle->turn_player;
@endphp

    <div class="battle-screen">

        {{-- ================= フィールド ================= --}}
        <div class="field">

            {{-- ---- 相手（奥・右） ---- --}}
            <div class="side side-enemy">

                <div class="status-box">

                    <div class="status-name">
                        {{ $opUser->user_name }}
                        <span class="status-char">
                            {{ $opChar->character_name }}
                        </span>
                    </div>

                    <div class="hp-line">
                        <span class="hp-label">HP</span>
                        <div class="hp-bar">
                            <div
                                class="hp-fill {{ $hpClass($opRate) }}"
                                style="width: {{ $opRate }}%;"></div>
                        </div>
                    </div>

                    <div class="hp-text">
                        {{ $opHp }} / {{ $opChar->hp }}
                    </div>

                    <div class="mp-line">
                        <span class="mp-label">MP</span>
                        <div class="mp-bar">
                            <div
                                class="mp-fill"
                                style="width: {{ ($opMp / 50) * 100 }}%;"></div>
                        </div>
                        <span class="mp-text">{{ $opMp }}</span>
                    </div>

                    @if($opAtkBuff > 0 || $opDefBuff > 0)
                        <div class="buff-line">
                            @if($opAtkBuff > 0)
                                <span class="buff atk">攻 +{{ $opAtkBuff }}</span>
                            @endif
                            @if($opDefBuff > 0)
                                <span class="buff def">防 +{{ $opDefBuff }}</span>
                            @endif
                        </div>
                    @endif

                </div>

                <div class="monster monster-enemy">

                    <div class="platform"></div>

                    @if($opChar->image)
                        <img
                            src="{{ asset('images/characters/' . $opChar->image) }}"
                            alt="{{ $opChar->character_name }}">
                    @else
                        <div class="no-image">?</div>
                    @endif

                </div>

            </div>


            {{-- ---- 自分（手前・左） ---- --}}
            <div class="side side-mine">

                <div class="monster monster-mine">

                    <div class="platform"></div>

                    @if($meChar->image)
                        <img
                            src="{{ asset('images/characters/' . $meChar->image) }}"
                            alt="{{ $meChar->character_name }}">
                    @else
                        <div class="no-image">?</div>
                    @endif

                </div>

                <div class="status-box">

                    <div class="status-name">
                        {{ $meUser->user_name }}
                        <span class="status-char">
                            {{ $meChar->character_name }}
                        </span>
                    </div>

                    <div class="hp-line">
                        <span class="hp-label">HP</span>
                        <div class="hp-bar">
                            <div
                                class="hp-fill {{ $hpClass($meRate) }}"
                                style="width: {{ $meRate }}%;"></div>
                        </div>
                    </div>

                    <div class="hp-text">
                        {{ $meHp }} / {{ $meChar->hp }}
                    </div>

                    <div class="mp-line">
                        <span class="mp-label">MP</span>
                        <div class="mp-bar">
                            <div
                                class="mp-fill"
                                style="width: {{ ($meMp / 50) * 100 }}%;"></div>
                        </div>
                        <span class="mp-text">{{ $meMp }}</span>
                    </div>

                    @if($meAtkBuff > 0 || $meDefBuff > 0)
                        <div class="buff-line">
                            @if($meAtkBuff > 0)
                                <span class="buff atk">攻 +{{ $meAtkBuff }}</span>
                            @endif
                            @if($meDefBuff > 0)
                                <span class="buff def">防 +{{ $meDefBuff }}</span>
                            @endif
                        </div>
                    @endif

                </div>

            </div>

        </div>


        {{-- ================= メッセージ ================= --}}
        <div class="message-box">
            {{ $battle->last_message ?: 'たたかいが はじまった！' }}
        </div>


        {{-- ================= コマンド ================= --}}
        @if(!$battle->winner_user_id)

            <div class="command-box">

                @if($isMyTurn)

                    <p class="turn-label my-turn">
                        ▼ どうする？
                    </p>

                    <form action="/attack" method="POST" class="command-grid">

                        @csrf

                        <input
                            type="hidden"
                            name="room_id"
                            value="{{ $battle->room_id }}">

                        <button type="submit" class="cmd cmd-attack">
                            <span class="cmd-name">こうげき</span>
                            <span class="cmd-cost">MP 0</span>
                        </button>

                        <button
                            type="submit"
                            name="skill"
                            value="heal"
                            class="cmd cmd-heal"
                            @disabled($meMp < 15)>
                            <span class="cmd-name">かいふく</span>
                            <span class="cmd-cost">MP 15</span>
                        </button>

                        <button
                            type="submit"
                            name="skill"
                            value="attack_up"
                            class="cmd cmd-buff"
                            @disabled($meMp < 10)>
                            <span class="cmd-name">こうげきUP</span>
                            <span class="cmd-cost">MP 10</span>
                        </button>

                        <button
                            type="submit"
                            name="skill"
                            value="defense_up"
                            class="cmd cmd-buff"
                            @disabled($meMp < 10)>
                            <span class="cmd-name">ぼうぎょUP</span>
                            <span class="cmd-cost">MP 10</span>
                        </button>

                        <button
                            type="submit"
                            name="skill"
                            value="special"
                            class="cmd cmd-special"
                            @disabled($meMp < 20)>
                            <span class="cmd-name">ひっさつわざ</span>
                            <span class="cmd-cost">MP 20</span>
                        </button>

                    </form>

                @else

                    <p class="turn-label wait-turn">
                        あいての こうどうを まっています
                        <span class="wait-dots">
                            <span></span><span></span><span></span>
                        </span>
                    </p>

                @endif

            </div>

        @endif


        {{-- ================= 決着 ================= --}}
        @if($battle->winner_user_id)

            <div class="result">

                @if(session('user_id') == $battle->winner_user_id)
                    <h1 class="win">あなたの勝ち！</h1>
                @else
                    <h1 class="lose">あなたの負け…</h1>
                @endif

                <form action="/rematch" method="POST">

                    @csrf

                    <input
                        type="hidden"
                        name="room_id"
                        value="{{ $battle->room_id }}">

                    <button type="submit" class="rematch-btn">
                        もう一度戦う
                    </button>

                </form>

                <a href="/character" class="lobby-link">
                    キャラ選択に戻る
                </a>

            </div>

        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            if (!window.Echo) {

                return;

            }

            window.Echo.channel(
                    'battle.{{ $battle->room_id }}'
                )
                .listen('.BattleUpdated', () => {

                    location.reload();

                });

        });
    </script>

</body>

</html>