<!DOCTYPE html>
<html>
<head>
    <title>キャラクター選択</title>
</head>
<body>

    <h1>キャラクター選択</h1>

    <form action="/character" method="POST">
        @csrf

        @foreach($characters as $character)

            <div style="border:1px solid black; margin:10px; padding:10px;">

                <input
                    type="radio"
                    name="character_id"
                    value="{{ $character->id }}"
                    required
                >

                <h3>{{ $character->character_name }}</h3>

                <p>HP : {{ $character->hp }}</p>

                <p>攻撃 : {{ $character->attack }}</p>

                <p>防御 : {{ $character->defense }}</p>

                <p>素早さ : {{ $character->speed }}</p>

                <p>知力 : {{ $character->intelligence }}</p>

            </div>

        @endforeach

        <button type="submit">
            キャラクター決定
        </button>
    </form>

</body>
</html>