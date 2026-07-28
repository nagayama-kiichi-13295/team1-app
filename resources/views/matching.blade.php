<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>マッチング中</title>

    {{-- 3秒ごとに再読み込みして相手の参加を確認 --}}
    <meta http-equiv="refresh" content="3">

    @vite([
        'resources/js/app.js'
    ])
</head>
<body class="matching-page">

    <div class="matching-panel">

        <div class="spinner"></div>

        <h1 class="matching-title">
            マッチング中
        </h1>

        <p class="matching-text">
            対戦相手を探しています
        </p>

        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <p class="elapsed">
            経過時間 <strong id="elapsed-time">0</strong> 秒
        </p>

        @if(session('user_name'))

            <div class="my-info">
                あなた : <strong>{{ session('user_name') }}</strong>
            </div>

        @endif

        <a href="/character" class="back-link">
            キャラクター選択に戻る
        </a>

    </div>

    <script>

    (function () {

        const KEY = 'matching_started_at';

        // 3秒ごとにページが再読み込みされるため、
        // 開始時刻を sessionStorage に保存しておく。
        // 経過秒数は常にこの開始時刻から計算するので、
        // リロードをまたいでもカウントが途切れない。
        let startedAt = sessionStorage.getItem(KEY);

        if (!startedAt) {

            startedAt = Date.now();

            sessionStorage.setItem(KEY, startedAt);
        }

        const target = document.getElementById('elapsed-time');

        function update() {

            if (!target) {

                return;
            }

            const elapsed = Math.floor(
                (Date.now() - Number(startedAt)) / 1000
            );

            target.textContent = elapsed;
        }

        // 初回表示
        update();

        // 1秒ごとに更新
        setInterval(update, 1000);

    })();

    </script>

</body>
</html>