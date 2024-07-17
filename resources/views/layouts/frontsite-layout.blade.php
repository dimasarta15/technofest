<!DOCTYPE html>

<html lang="en">
<head>
@php
    $logo = "/frontsite-assets/images/logo.png";
    if (!empty(setting('logo')->value))
        $logo = '/storage/'.setting('logo')->value;
@endphp

<meta charset="utf-8">
<title>{{ setting('title')->value }}</title>
<!-- 
Congratz son, You found the easter egg !

Ketika rasa, tak bisa diungkap dengan kata... 
                 _  _
                ( \/ )
         .---.   \  /   .-"-.
        /   6_6   \/   / 4 4 \
        \_  (__\       \_ v _/
        //   \\        //   \\
       ((     ))      ((     ))
jgs=====""===""========""===""=======
          |||            |||
           |              |
https://github.com/robyfirnandoyusuf
https://twitter.com/0x00b0
-->
<!-- SEO -->
<meta name="title" content="{{ setting('title')->value }}">
<meta name="description" content="{{ strip_tags(setting('about')->value) }}">
@if(env('BRAND') == 'technofest')
    <meta name="keywords" content="Technofest, Technofest STIKI, STIKI Malang, Pameran STIKI Malang, STIKI">
@else
    <meta name="keywords" content="DKVOLUTION, DKVOLUTION STIKI, STIKI Malang, Pameran DKV STIKI Malang, STIKI">
@endif
<meta name="robots" content="index, follow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="STIKI Malang collaboration by CreativeCrew Since 2013">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ request()->getHost() }}">
<meta property="og:title" content="{{ setting('title')->value }}">
<meta property="og:description" content="{{ strip_tags(setting('about')->value) }}">
<meta property="og:image" content="{{ $logo }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ request()->getHost() }}">
<meta property="twitter:title" content="{{ setting('title')->value }}">
<meta property="twitter:description" content="{{ strip_tags(setting('about')->value) }}">
<meta property="twitter:image" content="{{ $logo }}">

<!-- Stylesheets -->
<link href="/frontsite-assets/css/bootstrap.css" rel="stylesheet" media='all'>
<link href="/frontsite-assets/css/style.css" rel="stylesheet" media='all'>
<link href="/frontsite-assets/css/responsive.css" rel="stylesheet" media='all'>
<link href="/frontsite-assets/css/new-style.css" rel="stylesheet" media='all'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="shortcut icon" href="{{ $logo }}" type="image/x-icon">
<link rel="icon" href="{{ $logo }}" type="image/x-icon">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
@yield('style')
@include('layouts.style-custom')

@yield('script-recaptcha')
<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
<!--[if lt IE 9]><script src="/frontsite-assets/js/respond.js"></script><![endif]-->

</head>

<body>

<div class="page-wrapper">

    <!-- Header Span
    <span class="header-span style-two"></span> -->

    <!-- Main Header-->
    <header class="main-header header-style-two alternate-two">

        <div class="main-box">
            <div class="auto-container clearfix">
                <div class="logo-box">
                    @php
                        $link = '/';
                        if (session('lang') == 'id.') {
                            $link = '/id';
                        }
                    @endphp
                    <div class="logo"><a href="{{ $link }}"><img src="{{ empty(setting('logo')->value) ? "/frontsite-assets/images/logo.png" : '/storage/'.setting('logo')->value }}" class="img-logo" alt="" title=""></a></div>
                </div>

                <!--Nav Box-->
                <div class="nav-outer clearfix">
                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>
                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-md navbar-light">
                        <div class="navbar-header">
                            <!-- Togg le Button -->
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon flaticon-menu-button"></span>
                            </button>
                        </div>
                        @if (request()->is('/'))
                            <div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li><a href="{{ route(getLang() . 'frontsite.home.index') }}">@trans('frontsite.home')</a></li>
                                    <li><a href="{{ route(getLang() . 'frontsite.participant.index') }}">@trans('frontsite.participant')</a></li>
                                    <li><a href="#agenda">@trans('frontsite.agenda')</a></li>
                                    <li><a href="#pembicara">@trans('frontsite.speaker')</a></li>
                                    <li><a href="#karya">@trans('frontsite.project')</a></li>
                                    <li class="dropdown">
                                        <a>@trans('frontsite.event')</a>
                                        <ul>
                                            @forelse (semesters() as $semester)
                                                <li class=""><a href="{{ route(getLang() . 'frontsite.event.show', $semester->id) }}">{{ $semester->title }}</a></li>
                                            @empty
                                            @endforelse
                                        </ul>
                                    </li>
                                    <li><a href="{{ route(getLang() . 'frontsite.quizioner.index') }}">@trans('frontsite.quizioner')</a></li>
                                    <li><a href="{{ route(getLang() . 'frontsite.project-archive.index') }}">@trans('frontsite.archive')</a></li>
                                </ul>
                            </div>
                        @else
                            <div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li><a href="{{ route(getLang() . 'frontsite.participant.index') }}">@trans('frontsite.participant')</a></li>
                                    <li><a href="/#agenda">@trans('frontsite.agenda')</a></li>
                                    <li><a href="/#pembicara">@trans('frontsite.speaker')</a></li>
                                    <li><a href="/#karya">@trans('frontsite.project')</a></li>
                                    <!-- <li><a href="/#kegiatan">@trans('frontsite.event')</a></li> -->
                                    <li class="dropdown">
                                        <a>@trans('frontsite.event')</a>
                                        <ul>
                                            @forelse (semesters() as $semester)
                                                <li class=""><a href="{{ route(getLang() . 'frontsite.event.show', $semester->id) }}">{{ $semester->title }}</a></li>
                                            @empty
                                            @endforelse
                                        </ul>
                                    </li>
                                    
                                    <li><a href="{{ route(getLang() . 'frontsite.quizioner.index') }}">@trans('frontsite.quizioner')</a></li>
                                    <li><a href="{{ route(getLang() . 'frontsite.project-archive.index') }}">@trans('frontsite.archive')</a></li>
                                </ul>
                            </div>
                        @endif
                    </nav>
                    <!-- Main Menu End-->

                    <!-- Outer box -->
                    <div class="outer-box">                        
                        <!-- Button Box -->
                        <div class="btn-box" style="padding: 0px 0px;">
                            @guest
                                <div class="switch-fragment">
                                    <span class="btn-title">
                                        <div class="switch">
                                            @php
                                                $checked = ""
                                            @endphp

                                            @if (getLang() == 'id.')
                                                @php
                                                    $checked = 'checked'
                                                @endphp
                                            @endif
                                            <input id="language-toggle" class="check-toggle check-toggle-round-flat" type="checkbox" onclick="return changeLang()" {{ $checked }}>
                                                <label for="language-toggle"></label>
                                                <span class="off"><img src="https://icons.iconarchive.com/icons/wikipedia/flags/512/ID-Indonesia-Flag-icon.png" width="25px"></span>
                                                <span class="on"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Flag_of_the_United_Kingdom.png/1200px-Flag_of_the_United_Kingdom.png" width="25px"></span>
                                            </input>
                                        </div>
                                    </span>
                                </div>

                                <a href="{{ route(getLang() . 'login') }}" class="theme-btn btn-style-one"><span class="btn-title">@trans('frontsite.login')</span></a>
                                <a href="{{ route(getLang() . 'register') }}" class="theme-btn btn-style-two" style="margin-right: 10px;"><span class="btn-title">@trans('frontsite.register')</span></a>
                            @endguest
                            
                            @auth
                                <div class="switch-fragment">
                                    <span class="btn-title">
                                        <div class="switch">
                                            @php
                                                $checked = ""
                                            @endphp

                                            @if (getLang() == 'id.')
                                                @php
                                                    $checked = 'checked'
                                                @endphp
                                            @endif
                                            <input id="language-toggle" class="check-toggle check-toggle-round-flat" type="checkbox" onclick="return changeLang()" {{ $checked }}>
                                                <label for="language-toggle"></label>
                                                <span class="off"><img src="https://icons.iconarchive.com/icons/wikipedia/flags/512/ID-Indonesia-Flag-icon.png" width="25px"></span>
                                                <span class="on"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Flag_of_the_United_Kingdom.png/1200px-Flag_of_the_United_Kingdom.png" width="25px"></span>
                                            </input>
                                        </div>
                                    </span>
                                </div>
                                <a href="{{ route(getLang() . 'backsite.dashboard.index') }}" class="theme-btn btn-style-one"><span class="btn-title">Dashboard</span></a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>

            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            <nav class="menu-box">
                <div class="nav-logo"><a href="#"><img src="{{ empty(setting('logo')->value) ? "/frontsite-assets/images/logo.png" : '/storage/'.setting('logo')->value }}" class="img-logo" alt="" title=""></a></div>

                <ul class="navigation clearfix">
                    <!--Keep This Empty / Menu will come through Javascript-->
                    <li>
                        <div class="switch" style="margin-top: 20px;margin-left: 20px;">
                            @php
                                $checked = ""
                            @endphp

                            @if (getLang() == 'id.')
                                @php
                                    $checked = 'checked'
                                @endphp
                            @endif
                            <input id="language-toggle" class="check-toggle check-toggle-round-flat" type="checkbox" onclick="return changeLang()" {{ $checked }}>
                                <label for="language-toggle"></label>
                                <span class="off"><img src="https://icons.iconarchive.com/icons/wikipedia/flags/512/ID-Indonesia-Flag-icon.png" width="25px"></span>
                                <span class="on"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Flag_of_the_United_Kingdom.png/1200px-Flag_of_the_United_Kingdom.png" width="25px"></span>
                            </input>
                        </div>
                    </li>

                    @guest
                    <li>
                        <a href="{{ route(getLang() . 'login') }}" class="theme-btn btn-style-one" style="margin:10px;"><span class="btn-title" style="color: #fff;">@trans('frontsite.login')</span></a>
                    </li>
                    <li>
                        <a href="{{ route(getLang() . 'register') }}" class="theme-btn btn-style-two" style="margin: 10px;"><span class="btn-title" style="color: #fff;">@trans('frontsite.register')</span></a>
                    </li>
                    @endguest
                    
                    @auth
                    <li>
                        <a href="{{ route(getLang() . 'backsite.dashboard.index') }}" class="theme-btn btn-style-one" style="margin: 10px;"><span class="btn-title" style="color: #fff;">Dashboard</span></a>
                    </li>
                    @endauth
                </ul>
            </nav>
        </div><!-- End Mobile Menu -->
    </header>
    @routes
    @include('sweetalert::alert')
    <!--End Main Header -->
    @yield('content')
    <!-- Main Footer -->
    <footer class="main-footer style-two">
        <div class="auto-container" id="kontak">
            <!-- Footer Content -->
            <div class="footer-content">
                <div class="footer-logo"><a href="#"><img style="max-width:200px;" src="{{ empty(setting('logo')->value) ? "/frontsite-assets/images/logo.png" : '/storage/'.setting('logo')->value }}" alt=""></a></div>
                @if(env('BRAND') == 'technofest')
                    <div class="copyright-text">© Copyright 2024 All Rights Reserved by <a href="#">Technofest Team</a></div>
                @else
                    <div class="copyright-text">© Copyright 2024 All Rights Reserved by <a href="#">DKVOLUTION Team</a></div>
                @endif
            </div>
        </div>
    </footer>
    <!-- End Footer -->
</div>
<!--End pagewrapper-->

<!--Scroll to top-->
<script>
!function(Gleap,t,i){if(!(Gleap=window.Gleap=window.Gleap||[]).invoked){for(window.GleapActions=[],Gleap.invoked=!0,Gleap.methods=["identify","clearIdentity","attachCustomData","setCustomData","removeCustomData","clearCustomData","registerCustomAction","logEvent","sendSilentCrashReport","startFeedbackFlow","setAppBuildNumber","setAppVersionCode","preFillForm","setApiUrl","setFrameUrl","isOpened","open","close","on","setLanguage","setOfflineMode","initialize"],Gleap.f=function(e){return function(){var t=Array.prototype.slice.call(arguments);window.GleapActions.push({e:e,a:t})}},t=0;t<Gleap.methods.length;t++)Gleap[i=Gleap.methods[t]]=Gleap.f(i);Gleap.load=function(){var t=document.getElementsByTagName("head")[0],i=document.createElement("script");i.type="text/javascript",i.async=!0,i.src="https://js.gleap.io/latest/index.js",t.appendChild(i)},Gleap.load(),
    Gleap.initialize("b1ZZcgkXVs6kLwdvtFcjph4V1kAMQLmn")
}}();

function changeLang() {
    $('#language-toggle').change(function() {
        let val = $(this).is(':checked')

        if (val) { // jika indo
            location.href = "{{ localLink('id') }}"
        } else {
            location.href = "{{ localLink('en') }}"
        }
    })
}
</script>
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-double-up"></span></div>
<script src="/frontsite-assets/js/jquery.js"></script>
<script defer src="/frontsite-assets/js/popper.min.js"></script>
<script defer src="/frontsite-assets/js/bootstrap.min.js"></script>
<script defer src="/frontsite-assets/js/jquery.fancybox.js"></script>
<script defer src="/frontsite-assets/js/jquery.countdown.js"></script>
<script defer src="/frontsite-assets/js/appear.js"></script>
<script defer src="/frontsite-assets/js/owl.js"></script>
<script defer src="/frontsite-assets/js/wow.js"></script>
<script defer src="/frontsite-assets/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@yield('script')
</body>
</html>
