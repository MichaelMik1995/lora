<title>{{$page_title}} | {{$WEB_TITLE}}</title>
<base href="{{$WEB_ADDRESS}}/">
<link rel="icon" type="image/png" href="{{$this->asset("img/favicon/favicon.png")}}">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0;">


<!-- BEGIN loading Stylesheets -->
@foreach glob("./public/css/*.css") as $style @
<link type="text/css" rel="stylesheet" href="{{{$this->asset($style)}}}">
@endforeach

<link type="text/css" rel="stylesheet" href="{{{$this->asset("css/stylize.css")}}}">
<link type="text/css" rel="stylesheet" href="{{{$this->asset("css/compiled/modules.css")}}}">

<link type="text/css" rel="stylesheet" href="{{$this->asset("css/web_style/".$WEB_STYLE.".css")}}">
<link type="text/css" rel="stylesheet" href="{{$this->asset("css/style.css")}}">


<!-- END stylesheets -->


<!-- BEGIN loading Javascripts  -->

@if isset($_SESSION["token"]) @
<script>
    localStorage.setItem('TOKEN', '{{$_SESSION["token"]}}');
    localStorage.setItem('SID', '{{$_SESSION["SID"]}}');
</script>
@endif
<script>
    localStorage.setItem('DOMAIN', '{{$_SESSION["SID"]}}');
</script>

<script src="{{$this->asset('js/jquery/jquery.js')}}"></script>
<script src="{{$this->asset('js/jquery/jquery-ui/jquery-ui.js')}}"></script>
<script src="{{{$this->asset("js/lib/selectText.js")}}}" type="text/javascript"></script>

@foreach glob("./public/js/lib/autoload/*.js") as $autoload_js @
<script src="{{{$this->asset($autoload_js)}}}" type="text/javascript"></script>
@endforeach

@pluginload lora/easytext @ <!-- Load HTML for plugin in ./plugins/lora/easytext/html_loader/index.phtml -->

<script src="https://kit.fontawesome.com/0b54168b2a.js" crossorigin="anonymous"></script>

<!-- END Javascripts -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163118571-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-163118571-1');

  var minutes = 300;
  //Refresh inactivity
  (function(seconds) {
                var refresh,       
                        intvrefresh = function() {
                                clearInterval(refresh);
                                refresh = setTimeout(function() {
                                   location.href = location.href;
                                }, seconds * 1000);
                        };

                $(document).on('keypress click scroll mousemove', function() { intvrefresh() });
                intvrefresh();

        }(minutes));
</script> --> 
