<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' type='text/javascript'></script>



<style>




#fanback {



display:none;


background:rgba(0,0,0,0.8);


width:100%;


height:100%;


position:fixed;


top:0;


left:0;


z-index:99999;


}


#fan-exit {


width:100%;


height:100%;


}


#fanbox {


background:white;


width:420px;


height:270px;


position:absolute;


top:58%;


left:63%;


margin:-220px 0 0 -375px;


-webkit-box-shadow: inset 0 0 50px 0 #939393;


-moz-box-shadow: inset 0 0 50px 0 #939393;


box-shadow: inset 0 0 50px 0 #939393;


-webkit-border-radius: 5px;


-moz-border-radius: 5px;


border-radius: 5px;


margin: -220px 0 0 -375px;


}


#fanclose {


float:right;


cursor:pointer;


background:url(http://3.bp.blogspot.com/-NRmqfyLwBHY/T4nwHOrPSzI/AAAAAAAAAdQ/8b9O7O1q3c8/s1600/fanclose.png) repeat;


height:25px;


padding:20px;


position:relative;


padding-right:40px;


margin-top:-20px;


margin-right:-22px;


}


.remove-borda {


height:1px;


width:366px;


margin:0 auto;


background:#F3F3F3;


margin-top:16px;


position:relative;


margin-left:20px;


}


</style>




<script type='text/javascript'>


//<![CDATA[


jQuery.cookie = function (key, value, options) {


// key and at least value given, set cookie...


if (arguments.length > 1 && String(value) !== "[object Object]") {


options = jQuery.extend({}, options);


if (value === null || value === undefined) {


options.expires = -1;


}


if (typeof options.expires === 'number') {


var days = options.expires, t = options.expires = new Date();


t.setDate(t.getDate() + days);


}


value = String(value);


return (document.cookie = [


encodeURIComponent(key), '=',


options.raw ? value : encodeURIComponent(value),


options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE


options.path ? '; path=' + options.path : '',


options.domain ? '; domain=' + options.domain : '',


options.secure ? '; secure' : ''


].join(''));


}


// key and possibly options given, get cookie...


options = value || {};


var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;


return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;


};


//]]>


</script>


<script type='text/javascript'>


jQuery(document).ready(function($){


if($.cookie('popup_user_login') != 'yes'){


$('#fanback').delay(1000).fadeIn('medium');


$('#fanclose, #fan-exit').click(function(){


$('#fanback').stop().fadeOut('medium');


});


}


$.cookie('popup_user_login', 'no', { path: '/', expires: 7 });


});


</script>


<div id='fanback'>


<div id='fan-exit'>


</div>


<div id='fanbox'>


<div id='fanclose'>


</div>


<div class='remove-borda'>


</div>
<br><br>

<iframe allowtransparency='true' frameborder='0' scrolling='no' src='//www.facebook.com/plugins/likebox.php?href=<?=$school_fanpage?>&width=402&height=255&colorscheme=light&show_faces=true&border_color=%23E2E2E2&stream=false&header=false'


style='border: none; overflow: hidden; margin-top: -19px; width: 402px; height: 230px;'></iframe>


</div>


</div>