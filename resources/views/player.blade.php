<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>プレイヤー名入力</title>

    @vite([
        'resources/js/app.js'
    ])
</head>
<body class="player-page">

    <div class="title-panel">

        <h1 class="game-title">
            バケモン<span class="title-accent">バトル</span>2
        </h1>

        <p class="game-subtitle">
            BAKEMON BATTLE
        </p>

        {{-- バリデーションエラー --}}
        @if($errors->any())

            <div class="error-box">

                @foreach($errors->all() as $error)

                    <p>{{ $error }}</p>

                @endforeach

            </div>

        @endif

        <form action="/player" method="POST">
            @csrf

            <label class="name-label" for="player_name">
                プレイヤー名
            </label>

            <input
                id="player_name"
                class="name-input"
                type="text"
                name="player_name"
                value="{{ old('player_name') }}"
                placeholder="名前を入力"
                maxlength="50"
                autocomplete="off"
            >

            <button type="submit" class="start-btn">
                ゲーム開始
            </button>

        </form>

    </div>

</body>
</html>