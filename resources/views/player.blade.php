<!DOCTYPE html>
<html>
<head>
    <title>プレイヤー名入力</title>
</head>
<body>

    <h1>バケモンバトル2</h1>

    <form action="/player" method="POST">
        @csrf

        <input
            type="text"
            name="player_name"
            placeholder="プレイヤー名"
        >

        <button type="submit">
            開始
        </button>
    </form>

</body>
</html>