<!DOCTYPE html>
<html>
<head>
    <title>バケモンバトル2</title>

    @vite([
        'resources/js/app.js'
    ])
</head>
<body>

    <h1>バケモンバトル2</h1>

    <div class="player-card">

        <h2>
            {{ $hostUser->name }}
            （{{ $player1->character_name }}）
        </h2>

        <div class="hp-bar">
            <div
                class="hp-fill"
                style="
                    width:
                    {{ ($battle->player1_hp / $player1->hp) * 100 }}%;
                "
            ></div>
        </div>

        <h3>
            HP :
            {{ $battle->player1_hp }}
            / {{ $player1->hp }}
        </h3>

        <div class="mp-bar">
            <div
                class="mp-fill"
                style="
                    width:
                    {{ ($battle->player1_mp / 50) * 100 }}%;
                "
            ></div>
        </div>

        <h3>
            MP :
            {{ $battle->player1_mp }}
            / 50
        </h3>

        <h4>
            攻撃補正 :
            {{ $battle->player1_attack_buff }}
        </h4>

        <h4>
            防御補正 :
            {{ $battle->player1_defense_buff }}
        </h4>

    </div>

    <div class="player-card">

        <h2>
            {{ $guestUser->name }}
            （{{ $player2->character_name }}）
        </h2>

        <div class="hp-bar">
            <div
                class="hp-fill"
                style="
                    width:
                    {{ ($battle->player2_hp / $player2->hp) * 100 }}%;
                "
            ></div>
        </div>

        <h3>
            HP :
            {{ $battle->player2_hp }}
            / {{ $player2->hp }}
        </h3>

        <div class="mp-bar">
            <div
                class="mp-fill"
                style="
                    width:
                    {{ ($battle->player2_mp / 50) * 100 }}%;
                "
            ></div>
        </div>

        <h3>
            MP :
            {{ $battle->player2_mp }}
            / 50
        </h3>

        <h4>
            攻撃補正 :
            {{ $battle->player2_attack_buff }}
        </h4>

        <h4>
            防御補正 :
            {{ $battle->player2_defense_buff }}
        </h4>

    </div>

    <div class="log">

        <h2>
            {{ $battle->last_message }}
        </h2>

    </div>

    <h2 class="turn">

        @if(session('user_id') == $battle->turn_player)

            あなたのターン

        @else

            相手のターン

        @endif

    </h2>

    @if(!$battle->winner_user_id)

        @if(session('user_id') == $battle->turn_player)

            <form action="/attack" method="POST">

                @csrf

                <input
                    type="hidden"
                    name="room_id"
                    value="{{ $battle->room_id }}"
                >

                <button
                    type="submit"
                    class="attack-btn"
                >
                    通常攻撃
                </button>

                <button
                    type="submit"
                    name="skill"
                    value="attack_up"
                    class="buff-btn"
                >
                    攻撃UP(MP10)
                </button>

                <button
                    type="submit"
                    name="skill"
                    value="defense_up"
                    class="buff-btn"
                >
                    防御UP(MP10)
                </button>

                <button
                    type="submit"
                    name="skill"
                    value="heal"
                    class="heal-btn"
                >
                    回復(MP15)
                </button>

                <button
                    type="submit"
                    name="skill"
                    value="special"
                    class="skill-btn"
                >
                    必殺技(MP20)
                </button>

            </form>

        @endif

    @endif

@if($battle->winner_user_id)

    <h1 class="win">
        WINNER !!
    </h1>

    <script>

        setTimeout(() => {

            location.href = "/character";

        }, 3000);

    </script>

@endif

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