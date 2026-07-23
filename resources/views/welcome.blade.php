<!DOCTYPE html>
<html>
<head>
    <title>じゃんけん</title>

    @vite(['resources/js/app.js'])
</head>
<body>

<h1>じゃんけん</h1>

<select id="player">
    <option value="player1">プレイヤー1</option>
    <option value="player2">プレイヤー2</option>
</select>

<button onclick="play('グー')">グー</button>
<button onclick="play('チョキ')">チョキ</button>
<button onclick="play('パー')">パー</button>

<h2 id="result">ここに結果が表示されます</h2>

<script>
function play(hand)
{
    let player = document.getElementById('player').value;

    fetch('/play/' + player + '/' + hand);
}
</script>

</body>
</html>
