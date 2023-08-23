
<html>
<head>
    <meta charset="UTF-8">

    <!-- <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">
    <link rel="stylesheet" href="audiojs_Playlist/css/playlist.min.css"> -->
    <!-- <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
    <link href="audiojs_Playlist/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="audiojs_Playlist/progres-bar.css">
</head>
<body>
  <div class="mediPlayer">
    <!-- <audio class="listen" data-size="140"  ></audio> -->
    <audio  data-size="140"  ></audio>
      </div>
    <div id="playlist-container"  style="display:none" >
        <ol id="playlist">
<li><a href="#" data-src="<?=$_GET['qu']?>">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="<?=$_GET['ch1']?>">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="<?=$_GET['ch2']?>">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="<?=$_GET['ch3']?>">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="<?=$_GET['ch4']?>">your second track</a><span class="track-duration"></span></li>
        </ol>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script> -->
    <script src="audiojs_Playlist/jquery-2.1.1.min.js"></script>
    <script src="audiojs_Playlist/player.js"></script>
    <script src="audiojs_Playlist/audiojs/audio.min.js"></script>
    <script src="audiojs_Playlist/js/playlist.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.mediPlayer').mediaPlayer();
        });
    </script>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-36251023-1']);
      _gaq.push(['_setDomainName', 'jqueryscript.net']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();


    </script>

</body>
</html>
