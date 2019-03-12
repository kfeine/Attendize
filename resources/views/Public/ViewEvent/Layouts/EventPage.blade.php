<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
    <head>
        <title>{{{$event->title}}} - {{$event->organiser->name}}</title>


        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0" />
        <link rel="canonical" href="{{$event->event_url}}" />


        <!-- Open Graph data -->
        <meta property="og:title" content="{{{$event->title}}}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{$event->event_url}}?utm_source=fb" />
        @if($event->images->count())
        <meta property="og:image" content="{{config('attendize.cdn_url_user_assets').'/'.$event->images->first()['image_path']}}" />
        @endif
        <meta property="og:description" content="{{Str::words(strip_tags(Markdown::parse($event->description))), 20}}" />
        <meta property="og:site_name" content="Attendize.com" />
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        @yield('head')

       {!!HTML::style(config('attendize.cdn_url_static_assets').'/assets/stylesheet/frontend.css')!!}

        <!--Bootstrap placeholder fix-->
        <style>
            ::-webkit-input-placeholder { /* WebKit browsers */
                color:    #ccc !important;
            }
            :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
                color:    #ccc !important;
                opacity:  1;
            }
            ::-moz-placeholder { /* Mozilla Firefox 19+ */
                color:    #ccc !important;
                opacity:  1;
            }
            :-ms-input-placeholder { /* Internet Explorer 10+ */
                color:    #ccc !important;
            }

            input, select {
                color: #999 !important;
            }

            .btn {
                color: #fff !important;
            }

        </style>
    </head>
    <body class="attendize">
        <div id="event_page_wrap" vocab="http://schema.org/" typeof="Event">
            @yield('content')

            {{-- Push for sticky footer--}}
            @stack('footer')
        </div>

        {{-- Sticky Footer--}}
        @yield('footer')

        <a href="#intro" style="display:none;" class="totop"><i class="ico-angle-up"></i>
            <span style="font-size:11px;">@lang('public_viewevent_layouts_eventpage.top')</span></a>

        {!!HTML::script(config('attendize.cdn_url_static_assets').'/assets/javascript/frontend.js')!!}


        @if(isset($secondsToExpire))
        <script>if($('#countdown')) {setCountdown($('#countdown'), {{$secondsToExpire}});}</script>
        @endif

        @include('Shared.Partials.GlobalFooterJS')

<script>
$(document).ready(function(){
    if (window.navigator.userAgent.indexOf("MSIE ") > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))
        $("h1.section_head").before('<p id="ie_warning">Attention, vous utilisez visiblement le navigateur Internet Explorer, pour lequel ce site n\'a pas été conçu. Nous vous recommandons d\'utiliser un autre navigateur comme <a href="https://www.mozilla.org/fr/firefox/">Firefox</a>.</div>');
});
</script>
    </body>
</html>
