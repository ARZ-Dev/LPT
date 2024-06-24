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
                        @php($upcomingMatches = \App\Models\Game::where('is_started', false)->where('datetime', '>', now())->orderBy('datetime')->with(['homeTeam', 'awayTeam'])->get())
                        @if(count($upcomingMatches))
                            <!-- Owl Carousel-->
                            <div class="owl-carousel-navbar owl-carousel-inline-outer">
                                <div class="owl-inline-nav">
                                    <button class="owl-arrow owl-arrow-prev"></button>
                                    <button class="owl-arrow owl-arrow-next"></button>
                                </div>
                                <div class="owl-carousel-inline-wrap">
                                    <div class="owl-carousel owl-carousel-inline" data-items="1" data-dots="false" data-nav="true" data-autoplay="true" data-autoplay-speed="3200" data-stage-padding="0" data-loop="true" data-margin="10" data-mouse-drag="false" data-touch-drag="false" data-nav-custom=".owl-carousel-navbar">
                                        <!-- Post Inline-->
                                        @foreach($upcomingMatches as $match)
                                            @if($match->homeTeam && $match->awayTeam)
                                                <article class="post-inline">
                                                    <time class="post-inline-time" datetime="{{ \Carbon\Carbon::parse($match->datetime)->format('Y') }}">{{ \Carbon\Carbon::parse($match->datetime)->format('M d, Y') }}</time>
                                                    <p class="post-inline-title">{{ $match->homeTeam->nickname }} vs {{ $match->awayTeam->nickname }}</p>
                                                </article>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
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
                            <li class="rd-nav-item {{ request()->is('u/home', 'home') ? "active" : "" }}">
                                <a class="rd-nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="rd-nav-item {{ request()->is('u/tournaments*', 'tournaments*') ? "active" : "" }}">
                                <a class="rd-nav-link" href="#">Tournaments</a>
                                <article class="rd-menu rd-navbar-megamenu rd-megamenu-2-columns context-light">
                                    <div class="rd-megamenu-main">
                                        <div class="rd-megamenu-item rd-megamenu-item-nav">
                                            <!-- Heading Component-->
                                            <article class="heading-component heading-component-simple">
                                                <div class="heading-component-inner">
                                                    <h5 class="heading-component-title">Categories</h5>
                                                </div>
                                            </article>
                                            <div class="rd-megamenu-list-outer">
                                                <ul class="rd-megamenu-list">
                                                    @php($levelCategories = \App\Models\LevelCategory::all())
                                                    @foreach($levelCategories as $levelCategory)
                                                        <li class="rd-megamenu-list-item">
                                                            <a class="rd-megamenu-list-link" href="{{ route('frontend.tournaments', $levelCategory->id) }}">{{ $levelCategory->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="rd-megamenu-item rd-megamenu-item-content">
                                            <!-- Heading Component-->
                                            <article class="heading-component heading-component-simple">
                                                <div class="heading-component-inner">
                                                    <h5 class="heading-component-title">Latest Tournaments</h5>
                                                    <a class="button button-xs button-gray-outline" href="{{ route('frontend.tournaments') }}">See all Tournaments</a>
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
                            <li class="rd-nav-item {{ request()->is('u/matches*') ? "active" : "" }}">
                                <a class="rd-nav-link" href="{{ route('frontend.matches') }}">Matches</a>
                            </li>
                            <li class="rd-nav-item {{ request()->is('u/teams') ? "active" : "" }}">
                                <a class="rd-nav-link" href="{{ route('frontend.teams') }}">Teams</a>
                            </li>
                            <li class="rd-nav-item {{ request()->is('u/players*') ? "active" : "" }}">
                                <a class="rd-nav-link" href="{{ route('frontend.players') }}">Players</a>
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
