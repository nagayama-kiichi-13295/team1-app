<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>キャラクター選択</title>

    @vite([
        'resources/js/app.js'
    ])
</head>
<body class="character-page">

    <h1>キャラクター選択</h1>

    <p class="character-lead">
        使用するバケモンを選んでください
    </p>

    <form action="/character" method="POST">
        @csrf

        <div class="character-list">

            @foreach($characters as $character)

                <label class="character-card">

                    <input
                        type="radio"
                        name="character_id"
                        value="{{ $character->id }}"
                        required
                    >

                    <div class="character-image">

                        @if($character->image)

                            <img
                                src="{{ asset('images/characters/' . $character->image) }}"
                                alt="{{ $character->character_name }}"
                            >

                        @else

                            <div class="no-image">NO IMAGE</div>

                        @endif

                    </div>

                    <h3 class="character-name">
                        {{ $character->character_name }}
                    </h3>

                    <div class="stat-row stat-hp">
                        <div class="stat-label">
                            <span>HP</span>
                            <span>{{ $character->hp }}</span>
                        </div>
                        <div class="stat-bar">
                            <div
                                class="stat-fill"
                                style="width: {{ min($character->hp / 1500 * 100, 100) }}%;"
                            ></div>
                        </div>
                    </div>

                    <div class="stat-row stat-attack">
                        <div class="stat-label">
                            <span>攻撃</span>
                            <span>{{ $character->attack }}</span>
                        </div>
                        <div class="stat-bar">
                            <div
                                class="stat-fill"
                                style="width: {{ min($character->attack / 200 * 100, 100) }}%;"
                            ></div>
                        </div>
                    </div>

                    <div class="stat-row stat-defense">
                        <div class="stat-label">
                            <span>防御</span>
                            <span>{{ $character->defense }}</span>
                        </div>
                        <div class="stat-bar">
                            <div
                                class="stat-fill"
                                style="width: {{ min($character->defense / 150 * 100, 100) }}%;"
                            ></div>
                        </div>
                    </div>

                    <div class="stat-row stat-speed">
                        <div class="stat-label">
                            <span>素早さ</span>
                            <span>{{ $character->speed }}</span>
                        </div>
                        <div class="stat-bar">
                            <div
                                class="stat-fill"
                                style="width: {{ min($character->speed / 200 * 100, 100) }}%;"
                            ></div>
                        </div>
                    </div>

                    <div class="stat-row stat-intelligence">
                        <div class="stat-label">
                            <span>知力</span>
                            <span>{{ $character->intelligence }}</span>
                        </div>
                        <div class="stat-bar">
                            <div
                                class="stat-fill"
                                style="width: {{ min($character->intelligence / 150 * 100, 100) }}%;"
                            ></div>
                        </div>
                    </div>

                    <div class="selected-mark">
                        ◆ 選択中
                    </div>

                </label>

            @endforeach

        </div>

        <button type="submit" class="decide-btn">
            キャラクター決定
        </button>

    </form>

</body>
</html>