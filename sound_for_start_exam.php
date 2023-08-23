
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
    <audio tabindex="0" id="beep-one"  data-size="110"  preload></audio>
    <!-- <audio class="listen"  data-size="110"  ></audio> -->
      </div>
    <div id="playlist-container"  style="display:none" >
        <ol id="playlist">
<li><a href="#" data-src="<?=$_GET['qu']?>">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="https://od.lk/s/MzlfOTM0MjExMl8/A.mp3">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="https://od.lk/s/MzlfOTM0MjExM18/A-Blue.mp3">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="<?=$_GET['ch1']?>">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="https://od.lk/s/MzlfOTM0MjEwNl8/B.mp3">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="https://od.lk/s/MzlfOTM0MjEwN18/B-Green.mp3">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="<?=$_GET['ch2']?>">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="https://od.lk/s/MzlfOTM0MjEwOF8/C.mp3">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="https://od.lk/s/MzlfOTM0MjEwOV8/C-Red.mp3">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="<?=$_GET['ch3']?>">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="https://od.lk/s/MzlfOTM0MjExMF8/D.mp3">your second track</a><span class="track-duration"></span></li>
<li><a href="#" data-src="https://od.lk/s/MzlfOTM0MjExMV8/D-Orange.mp3">your second track</a><span class="track-duration"></span></li>
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

      $('#links a').click(function(e) {
          e.preventDefault();
          var beepOne = $("#beep-one")[0];
          beepOne.play();
      });
    </script>

</body>
</html>
