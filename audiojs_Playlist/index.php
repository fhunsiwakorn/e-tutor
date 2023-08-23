<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>audiojs Playlist Skin Demo</title>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
    <link rel="stylesheet" href="./css/playlist.min.css">
</head>
<body>
    <audio class="listen"  preload="auto" ></audio>
    <div id="playlist-container"  style="display:none" >
        <ol id="playlist">
            <li><a href="#" data-src="https://od.lk/s/MTJfNDg2ODg4Nl8/01.mp3">your first track</a><span class="track-duration"></span></li>
            <li><a href="#" data-src="https://od.lk/s/MTJfNDg2ODg5MV8/02.mp3">your second track</a><span class="track-duration"></span></li>
        </ol>
    </div>

    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="audiojs/audio.min.js"></script>
    <script src="js/playlist.min.js"></script>

</body>
</html>
