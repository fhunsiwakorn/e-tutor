(function($, audiojs) {
    var track_selection_controls = '';
    track_selection_controls += '<div id="extended-controls-pre">';
    track_selection_controls += '<span id="prev-track" class="glyphicon glyphicon-chevron-left"></span>';
    track_selection_controls += '<span id="next-track" class="glyphicon glyphicon-chevron-right"></span>';
    track_selection_controls += '</div>';

    var volume_controls = '';
    volume_controls += '<div id="extended-controls-post">';
    volume_controls += '<div id="volume-container">';
    volume_controls += '<span class="glyphicon glyphicon-volume-down"> </span>';
    volume_controls += '<input id="volume-slider" type="range" min="0" max="1" step="0.01" value="0.5" />';
    volume_controls += '<span class="glyphicon glyphicon-volume-up"> </span>';
    volume_controls += '</div>';
    volume_controls += '</div>';
    volume_controls += '<div style="clear:both;"></div>';

    var volume = 0.5,
        $playlist = $("#playlist"),
        number_of_tracks = $playlist.find("li").length,
        MAX_ERROR_SKIP_ATTEMPTS = 10,
        error_skips = 0,
        total_duration = 0;

    var playlist_info = '';
    playlist_info += '<div id="playlist-info-container">';
    playlist_info += '<span id="playlist-info-number-tracks">' + number_of_tracks + '</span> tracks';
    playlist_info += ', <span id="playlist-info-duration"></span> playing time';
    playlist_info += '</div>';

    var a = audiojs.createAll({
          // Setup the player to autoplay the next track
            trackEnded: function() {
                var next = $('ol li.playing').next();
                if (!next.length) next = $('ol li').first();
                next.addClass('playing').siblings().removeClass('playing');
                audio.load($('a', next).attr('data-src'));
                audio.play();
            }
        }),
        $audiojs = $(".audiojs"),
        audio = a[0];

    if( number_of_tracks > 1 )
    {
        //only add track selection if more than one song in playlist
        $audiojs.before( track_selection_controls );
        //only show playlist info if more than one song
        $playlist.before( playlist_info );

        $("#playlist li").each(function(index, value){
            $(value).removeClass('playing');
        });

        var links = $playlist.find("li a");
        var current_track = 0;

        findTrackDuration( current_track );

    }

    function findTrackDuration( track )
    {
        if( track > number_of_tracks)
        {
            loadFirstTrack();
            var nice_duration = formatDuration(total_duration);
            $("#playlist-info-duration").html(nice_duration);
            return false;
        }

        var aud2 = new Audio();
        aud2.src = $(links[track]).data("src");
        aud2.preload = "metadataonly";

        (function(aud){
            aud.addEventListener('loadedmetadata', function(){
                var raw_duration = $(this)[0].duration;
                total_duration += raw_duration;
                var nice_duration = formatDuration( raw_duration );

                $playlist.find("li:eq(" + track + ") span.track-duration").html( nice_duration );
                ++current_track;

                //important to set the current audio src to the same as we will process next
                aud.src = $(links[current_track]).data("src");

                findTrackDuration( current_track );
            });
        })(aud2);
    }

    $audiojs.after( volume_controls );

    function formatDuration( raw )
    {
        if (raw == '') {
            return;
        }

        var seconds = Math.round( raw ) % 60;
        var minutes = Math.floor( raw / 60.0 ) % 60;
        var hours = Math.floor( raw / 3600.0 );

        if( seconds < 10){ seconds = "0" + seconds; }
        if( minutes < 10){ minutes = "0" + minutes; }

        if( hours == 0)
        {
            return minutes + ":" + seconds;
        }

        return hours + ":" + minutes + ":" + seconds;
    }

    function loadFirstTrack()
    {
      // Load in the first track
        first = $('ol a').attr('data-src');
        $('ol li').first().addClass('playing');
        audio.load(first);
    }

    //add custom event listeners
    audiojs.events.addListener(audio.source, 'error', function(e){
        if( error_skips < MAX_ERROR_SKIP_ATTEMPTS )
        {
            error_skips++;
            //remove error message
            $audiojs.addClass( "loading");
            $audiojs.removeClass( "error");
            nextTrack();
        }
    });

    //volume support
    function changeVolume( el )
    {
        var v = el.val();
        if( v != volume )
        {
            volume = v;
            audio.setVolume(v);
        }
    }

    $("body").on("mousewheel DOMMouseScroll", ".audiojs, #extended-controls-post, #extended-controls-pre", function(event){
        event.preventDefault();

        if (event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
            // scroll up
            volume = parseFloat(volume) + 0.05;
            if( volume > 1.0 )
            {
                volume = 1.0;
            }else{
                audio.setVolume( volume );
                $("#volume-slider").val( volume );
            }
        }
        else {
            // scroll down
            volume = parseFloat(volume) - 0.05;
            if( volume < 0.0 )
            {
                volume = 0.0;
            }else{
                audio.setVolume( volume );
                $("#volume-slider").val( volume );
            }
        }
    });
    //end volume support

    //track selection
    function nextTrack()
    {
        if( number_of_tracks > 1 )
        {
            var next = $('li.playing').next();
            if (!next.length) next = $('ol li').first();
            next.click();
        }
    }

    function prevTrack()
    {
        if( number_of_tracks > 1 )
        {
            var prev = $('li.playing').prev();
            if (!prev.length) prev = $('ol li').last();
            prev.click();
        }
    }
    //end track selection

    //=== event handling ===//

    //mouse events

    $("body").on("click", "#volume-slider", function(evt){
        changeVolume( $(this) );
    });

    $("body").on("mousemove", "#volume-slider", function(evt) {
        changeVolume( $(this) );
    });

    $("body").on("click", '#playlist li', function(e) {
        // Load in a track on playlist click
        e.preventDefault();
        $(this).addClass('playing').siblings().removeClass('playing');
        audio.load($('a', this).attr('data-src'));
        audio.play();
    });

    $("body").on("click", "#prev-track", function(e){
        prevTrack();
    });

    $("body").on("click", "#next-track", function(e) {
        nextTrack();
    });

    //keyboard events
    $(document).keydown(function(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode;
        if (unicode == 39) { // right arrow
            nextTrack();
        } else if (unicode == 37) { //back arrow
            prevTrack();
        } else if (unicode == 32) { // spacebar
            audio.playPause();
        }
    })
})(jQuery, audiojs);
