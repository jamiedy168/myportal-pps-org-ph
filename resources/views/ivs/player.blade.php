<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $streamName ?? 'PPS IVS Live' }} — PPS Live</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            user-select: none;
        }
        .ivs-header {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: rgba(0,0,0,0.85);
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
        }
        .ivs-live-badge {
            background: #e74c3c;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 4px;
            letter-spacing: 1px;
            margin-right: 10px;
        }
        .ivs-stream-name { font-size: 15px; font-weight: bold; }
        .ivs-members-only { font-size: 12px; color: #aaa; }
        .ivs-player-wrapper {
            width: 100%;
            max-width: 1280px;
            padding: 70px 16px 16px;
        }
        video {
            width: 100%;
            height: auto;
            border-radius: 8px;
            background: #000;
        }
        .ivs-watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            opacity: 0.15;
            font-size: 12px;
            color: #fff;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="ivs-header">
        <div>
            <span class="ivs-live-badge">🔴 LIVE</span>
            <span class="ivs-stream-name">{{ $streamName ?? 'PPS Live Stream' }}</span>
        </div>
        <span class="ivs-members-only">PPS Members Only</span>
    </div>

    <div class="ivs-player-wrapper">
        <video id="ivs-player" controls autoplay playsinline></video>
    </div>

    <div class="ivs-watermark">PPS Members Only — Do Not Share</div>

    <script src="https://player.live-video.net/1.50.0/amazon-ivs-player.min.js"></script>
    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        document.addEventListener('keydown', function(e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && ['I','J','C'].includes(e.key)) ||
                (e.ctrlKey && e.key === 'U')
            ) {
                e.preventDefault();
                return false;
            }
        });

        (function initIvsPlayer() {
            if (!IVSPlayer.isPlayerSupported) {
                document.body.insertAdjacentHTML('beforeend',
                    '<p style="color:#e74c3c;text-align:center;margin-top:20px;">Your browser does not support this player. Please use Chrome or Firefox.</p>'
                );
                return;
            }
            var player = IVSPlayer.create();
            player.attachHTMLVideoElement(document.getElementById('ivs-player'));
            var src = atob('{{ base64_encode($playbackUrl ?? "") }}');
            player.load(src);
            player.play();
            player.addEventListener(IVSPlayer.PlayerEventType.ERROR, function(err) {
                console.warn('IVS stream unavailable or ended.', err);
            });
        })();
    </script>
</body>
</html>
