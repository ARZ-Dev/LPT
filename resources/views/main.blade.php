<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>
    <!-- Site Title-->
    <title>Home LPT</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('assets/frontend/images/tennis/favicon.ico') }}" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Kanit:300,400,500,500i,600,900%7CRoboto:400,900">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style-tennis.css') }}" id="main-styles-link">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
</head>
<body>
    <div class="preloader">
        <div class="preloader-body">
            <div class="preloader-item"></div>
        </div>
    </div>
    <!-- Page-->
    <div class="page">
        <!-- Page Header-->
        <header class="section page-header rd-navbar-dark">
            <!-- RD Navbar-->
            <div class="rd-navbar-wrap">
                <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="166px" data-xl-stick-up-offset="166px" data-xxl-stick-up-offset="166px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                    <div class="rd-navbar-panel">
                        <!-- RD Navbar Toggle-->
                        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-main"><span></span></button>
                        <!-- RD Navbar Panel-->
                        <div class="rd-navbar-panel-inner container">
                            <div class="rd-navbar-collapse rd-navbar-panel-item rd-navbar-panel-item-left">
                                <!-- Owl Carousel-->
                                <div class="owl-carousel-navbar owl-carousel-inline-outer">
                                    <div class="owl-inline-nav">
                                        <button class="owl-arrow owl-arrow-prev"></button>
                                        <button class="owl-arrow owl-arrow-next"></button>
                                    </div>
                                    <div class="owl-carousel-inline-wrap">
                                        <div class="owl-carousel owl-carousel-inline" data-items="1" data-dots="false" data-nav="true" data-autoplay="true" data-autoplay-speed="3200" data-stage-padding="0" data-loop="true" data-margin="10" data-mouse-drag="false" data-touch-drag="false" data-nav-custom=".owl-carousel-navbar">
                                            <!-- Post Inline-->
                                            <article class="post-inline">
                                                <time class="post-inline-time" datetime="2024">April 15, 2024</time>
                                                <p class="post-inline-title">Sportland vs Dream Team</p>
                                            </article>
                                            <!-- Post Inline-->
                                            <article class="post-inline">
                                                <time class="post-inline-time" datetime="2024">April 15, 2024</time>
                                                <p class="post-inline-title">Sportland vs Real Madrid</p>
                                            </article>
                                            <!-- Post Inline-->
                                            <article class="post-inline">
                                                <time class="post-inline-time" datetime="2024">April 15, 2024</time>
                                                <p class="post-inline-title">Sportland vs Barcelona</p>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="rd-navbar-panel-item rd-navbar-panel-item-right">
                                <ul class="list-inline list-inline-bordered">
                                    <li><a class="link link-icon link-icon-left link-classic" href="{{ route('login') }}"><span class="icon fl-bigmug-line-login12"></span><span class="link-icon-text">Login</span></a></li>
                                </ul>
                            </div>
                            <div class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
                        </div>
                    </div>
                    <div class="rd-navbar-main">
                        <div class="rd-navbar-main-top">
                            <div class="rd-navbar-main-container container">
                                <!-- RD Navbar Brand-->
                                <div class="rd-navbar-brand"><a class="brand" href="{{ route('home') }}"><img class="brand-logo " src="{{ asset('assets/frontend/images/tennis/logo-default-144x126.png') }}" alt="" width="95" height="126"/></a>
                                </div>
                                <!-- RD Navbar List-->
                                <ul class="rd-navbar-list">
                                    <li class="rd-navbar-list-item"><a class="rd-navbar-list-link" href="#"><img src="{{ asset('assets/frontend/images/partners-1-inverse-75x42.png') }}" alt="" width="75" height="42"/></a></li>
                                    <li class="rd-navbar-list-item"><a class="rd-navbar-list-link" href="#"><img src="{{ asset('assets/frontend/images/partners-2-inverse-88x45.png') }}" alt="" width="88" height="45"/></a></li>
                                    <li class="rd-navbar-list-item"><a class="rd-navbar-list-link" href="#"><img src="{{ asset('assets/frontend/images/partners-3-inverse-79x52.png') }}" alt="" width="79" height="52"/></a></li>
                                </ul>
                                <!-- RD Navbar Search-->
                                <div class="rd-navbar-search">

                                </div>
                            </div>
                        </div>
                        <div class="rd-navbar-main-bottom rd-navbar-darker">
                            <div class="rd-navbar-main-container container">
                                <!-- RD Navbar Nav-->
                                <ul class="rd-navbar-nav">
                                    <li class="rd-nav-item {{ request()->is('home') ? "active" : "" }}"><a class="rd-nav-link" href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="rd-nav-item"><a class="rd-nav-link" href="#">Tournaments</a>
                                        <article class="rd-menu rd-navbar-megamenu rd-megamenu-2-columns context-light">
                                            <div class="rd-megamenu-main">
                                                <div class="rd-megamenu-item rd-megamenu-item-nav">
                                                    <!-- Heading Component-->
                                                    <article class="heading-component heading-component-simple">
                                                        <div class="heading-component-inner">
                                                            <h5 class="heading-component-title">Categories
                                                            </h5>
                                                        </div>
                                                    </article>
                                                    <div class="rd-megamenu-list-outer">
                                                        <ul class="rd-megamenu-list">
                                                            @php($levelCategories = \App\Models\LevelCategory::all())
                                                            @foreach($levelCategories as $levelCategory)
                                                                <li class="rd-megamenu-list-item"><a class="rd-megamenu-list-link" href="shortcodes.html">{{ $levelCategory->name }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="rd-megamenu-item rd-megamenu-item-content">
                                                    <!-- Heading Component-->
                                                    <article class="heading-component heading-component-simple">
                                                        <div class="heading-component-inner">
                                                            <h5 class="heading-component-title">Latest Tournaments
                                                            </h5><a class="button button-xs button-gray-outline" href="news-1.html">See all Tournaments</a>
                                                        </div>
                                                    </article>
                                                    <div class="row row-20">
                                                        @php($tournaments = \App\Models\Tournament::orderBy('start_date', 'desc')->take(4)->with('levelCategories.levelCategory')->get())
                                                        @foreach($tournaments as $tournament)
                                                            <div class="col-lg-6">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <!-- Post Classic-->
                                                                        <article class="post-classic">
                                                                            <div class="post-classic-main">
                                                                                <!-- Badge-->
                                                                                <div class="badge badge-primary">{{ $tournament->name }}</div>
                                                                                <p class="post-classic-title">
                                                                                    {{ implode(', ', $tournament->levelCategories->pluck('levelCategory.name')->toArray()) }}
                                                                                </p>
                                                                                <div class="post-classic-time"><span class="icon mdi mdi-clock"></span>
                                                                                    From:<time datetime="2024">{{ Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}</time>
                                                                                </div>
                                                                                <div class="post-classic-time"><span class="icon mdi mdi-clock"></span>
                                                                                    To:<time datetime="2024">{{ Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}</time>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            @php($upcomingMatch = \App\Models\Game::where('is_started', false)->where('datetime', '>', now())->orderBy('datetime')->with('group.tournamentLevelCategory.levelCategory', 'knockoutRound.tournamentLevelCategory.levelCategory')->first())
                                            @if($upcomingMatch)
                                                <!-- Event Teaser-->
                                                <article class="event-teaser rd-megamenu-footer">
                                                    <div class="event-teaser-header">
                                                        <div class="event-teaser-caption">
                                                            <h5 class="event-teaser-title">
                                                                Upcoming Match in {{ getMatchCategory($upcomingMatch)->name }}
                                                            </h5>
                                                            <time class="event-teaser-time" datetime="2024">{{ Carbon\Carbon::parse($tournament->datetime)->format('D, M d, Y') }}</time>
                                                        </div>
                                                        <div class="event-teaser-teams">
                                                            <div class="event-teaser-team">
                                                                <div class="unit unit-spacing-xs unit-horizontal align-items-center">
                                                                    <div class="unit-body">
                                                                        <p class="heading-7">{{ $upcomingMatch->homeTeam->nickname }}</p>
                                                                        <p class="text-style-1">Home Team</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="event-teaser-team-divider"><span class="event-teaser-team-divider-text">VS</span></div>
                                                            <div class="event-teaser-team">
                                                                <div class="unit unit-spacing-xs unit-horizontal align-items-center">
                                                                    <div class="unit-body">
                                                                        <p class="heading-7">{{ $upcomingMatch->awayTeam->nickname }}</p>
                                                                        <p class="text-style-1">Away Team</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="event-teaser-countdown event-teaser-highlighted">
                                                        <!-- Countdown-->
                                                        <div class="countdown countdown-classic" data-type="until" data-time="{{ Carbon\Carbon::parse($upcomingMatch->datetime)->format('d M Y H:i') }}" data-format="dhms" data-style="short"></div>
                                                    </div>
                                                </article>
                                            @endif
                                        </article>
                                    </li>
                                    <li class="rd-nav-item {{ request()->is('matches') ? "active" : "" }}">
                                        <a class="rd-nav-link" href="{{ route('frontend.matches') }}">Matches</a>
                                    </li>
                                    <li class="rd-nav-item {{ request()->is('teams-standings') ? "active" : "" }}">
                                        <a class="rd-nav-link" href="{{ route('frontend.teams-standings') }}">Teams</a>
                                    </li>
                                    <li class="rd-nav-item">
                                        <a class="rd-nav-link" href="#">Players</a>
                                    </li>
                                </ul>
                                <div class="rd-navbar-main-element">
                                    <ul class="list-inline list-inline-sm">
                                        <li><a class="icon icon-xs icon-light fa fa-facebook" href="#"></a></li>
                                        <li><a class="icon icon-xs icon-light fa fa-twitter" href="#"></a></li>
                                        <li><a class="icon icon-xs icon-light fa fa-google-plus" href="#"></a></li>
                                        <li><a class="icon icon-xs icon-light fa fa-instagram" href="#"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        @yield('content')

        <!-- Page Footer-->
        <footer class="section footer-corporate context-dark">
            <div class="footer-corporate-main">
                <div class="container">
                    <div class="row row-50 justify-content-center justify-content-md-between">
                        <div class="col-md-5"><a class="brand" href="../landing"><img class="brand-logo " src="{{ asset('assets/frontend/images/tennis/logo-default-144x126.png') }}" alt="" width="144" height="126"/></a>
                            <p class="lh-15 ls-normal">Tennis Blastship connects everyone passionate about tennis. Established in 2005, our website has been providing the best news and updates for tennis fans. From recent tennis matches to event announcements, we cover everything you may want to know about.</p>
                            <ul class="list-sm mt-4">
                                <li>
                                    <div class="unit unit-horizontal unit-spacing-xs align-items-center">
                                        <div class="unit-left"><span class="icon align-middle icon-xs-big icon-primary icomoon-phone"></span></div>
                                        <div class="unit-body"><a class="heading-4 link-light ls-normal" href="tel:#">+1 234 567 8901</a></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="unit unit-horizontal unit-spacing-xs align-items-center">
                                        <div class="unit-left"><span class="icon align-middle icon-xs-big icon-primary icomoon-mail"></span></div>
                                        <div class="unit-body"><a class="link-light ls-normal" href="mailto:#">info@arzgt.com</a></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="row row-50">
                                <div class="col-6 col-lg-4">
                                    <h6 class="footer-corporate-title">Quick Links</h6>
                                    <ul class="list-xxs">
                                        <li><a class="link-light" href="#">Home</a></li>
                                        <li><a class="link-light" href="#">Features</a></li>
                                        <li><a class="link-light" href="#">Team</a></li>
                                        <li><a class="link-light" href="#">News</a></li>
                                        <li><a class="link-light" href="#">Shop</a></li>
                                    </ul>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <h6 class="footer-corporate-title">Categories</h6>
                                    <ul class="list-xxs">
                                        <li><a class="link-light" href="#">Interview</a></li>
                                        <li><a class="link-light" href="#">Facts & stats</a></li>
                                        <li><a class="link-light" href="#">WTA Charleston</a></li>
                                        <li><a class="link-light" href="#">Match report</a></li>
                                        <li><a class="link-light" href="#">OFF court</a></li>
                                        <li><a class="link-light" href="#">ON court</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <h6 class="footer-corporate-title">Social</h6>
                                    <ul class="list-xxs">
                                        <li><a class="link-light" href="#">Facebook</a></li>
                                        <li><a class="link-light" href="#">YouTube</a></li>
                                        <li><a class="link-light" href="#">Instagram</a></li>
                                        <li><a class="link-light" href="#">Twitter</a></li>
                                        <li><a class="link-light" href="#">LinkedIn</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-corporate-aside">
                <div class="container">
                    <p class="rights"><span>LPT</span><span>&nbsp;&copy;&nbsp;</span><span class="copyright-year"></span><span>.&nbsp;</span><a class="link-underline" href="privacy-policy.html">Privacy Policy</a></p>
                    <p class="small ls-normal text-gray-500">The content provided on our tennis news site is for general informational purposes only. While we strive to ensure the accuracy and reliability of the information presented, we cannot guarantee that all information is up to date, complete, or accurate.</p>
                </div>
            </div>
        </footer>
        <!-- Modal Video-->
        <div class="modal modal-video fade" id="modal1" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ratio ratio-16x9">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/42STRZ2DTEM" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="{{ asset('assets/frontend/js/core.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/script.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    @yield('script')
</body>
</html>
