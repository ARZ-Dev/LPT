@extends('main')

@section('content')
    <!-- Swiper-->
    <section class="section swiper-container swiper-slider swiper-modern bg-primary" data-swiper='{"autoplay":false,"simulateTouch":true,"effect":"fade"}'>
        <div class="swiper-wrapper">
            <div class="swiper-slide" data-slide-bg="{{ asset('assets/frontend/images/tennis/slider-slide-1-1920x720.jpg') }}">
                <div class="container">
                    <div class="swiper-slide-caption">
                        <h2 class="lh-1 fst-normal ls-normal" style="max-width: 550px;" data-caption-animate="fadeInLeftSmall">Unique venue. Exceptional team. One passion</h2>
                        <p class="mt-4" style="max-width: 320px;" data-caption-animate="fadeInLeftSmall" data-caption-delay="200">Tennis Blastship is your #1 space for everything concerning this breathtaking sport.</p><a class="button button-sm button-secondary button-offset-xl" data-caption-animate="fadeInLeftSmall" data-caption-delay="400" href="about-us.html">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News-->
    <section class="section section-xl bg-white">
        <div class="container">
            <div class="row row-30 justify-content-center">
                <div class="col-sm-6 col-md-4">
                    <!-- Post Iris-->
                    <article class="post-iris"><img src="{{ asset('assets/frontend/images/tennis/post-iris-1-370x280.jpg') }}" alt="" width="370" height="280"/>
                        <div class="post-iris-main">
                            <!-- Badge-->
                            <div class="badge badge-sm badge-secondary">Interview
                            </div>
                            <h4 class="post-iris-title ls-normal"><a href="blog-post.html">JESSICA PEGULA IS THE &quot;EST&quot; OF THE WTA</a></h4>
                            <div class="post-iris-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                <time datetime="2024">January 15, 2023</time>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-md-4">
                    <!-- Post Iris-->
                    <article class="post-iris"><img src="{{ asset('assets/frontend/images/tennis/post-iris-2-370x280.jpg') }}" alt="" width="370" height="280"/>
                        <div class="post-iris-main">
                            <!-- Badge-->
                            <div class="badge badge-sm badge-secondary">facts &amp; stats
                            </div>
                            <h4 class="post-iris-title ls-normal"><a href="blog-post.html">Pegula, Keys cruise into Charleston Round of 16</a></h4>
                            <div class="post-iris-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                <time datetime="2024">January 13, 2023</time>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-6 col-md-4">
                    <!-- Post Iris-->
                    <article class="post-iris"><img src="{{ asset('assets/frontend/images/tennis/post-iris-3-370x280.jpg') }}" alt="" width="370" height="280"/>
                        <div class="post-iris-main">
                            <!-- Badge-->
                            <div class="badge badge-sm badge-secondary">WTA CHARLESTON
                            </div>
                            <h4 class="post-iris-title ls-normal"><a href="blog-post.html">SHELBY ROGERS, HUMBLE GIANT-KILLER, LACKS ONE THING ON HER RESUME</a></h4>
                            <div class="post-iris-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                <time datetime="2024">January 11, 2023</time>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming events-->
    @if(count($upcomingMatches))
    <section class="section section-xl bg-white">
        <div class="container">
            <div class="row row-50">
                <div class="col-md-12 owl-carousel-outer-navigation">
                    <!-- Heading Component-->
                    <article class="heading-component heading-component-lg no-decor">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">Upcoming Tournaments
                            </h5>
                            <div class="owl-carousel-arrows-outline owl-carousel-arrows-sm owl-carousel-arrows-secondary">
                                <div class="owl-nav">
                                    <button class="owl-arrow owl-arrow-prev"></button>
                                    <button class="owl-arrow owl-arrow-next"></button>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- Owl Carousel-->
                    <div class="owl-carousel" data-items="1" data-autoplay="false" data-autoplay-speed="6500" data-dots="false" data-nav="true" data-stage-padding="0" data-loop="true" data-margin="30" data-mouse-drag="false" data-nav-custom=".owl-carousel-outer-navigation">
                        @foreach($upcomingMatches as $match)
                        <div class="promo-new row row-30">
                            <div class="col-md-6">
                                <div class="promo-new-wrap">
                                    <div class="promo-new-meta context-dark align-items-start">
                                        <time class="promo-new-time lh-1" datetime="2023-12-31">
                                            <span class="heading-3">{{ \Carbon\Carbon::parse($match->datetime)->format('d') }}</span>
                                            <span class="heading-5">{{ \Carbon\Carbon::parse($match->datetime)->format('M') }}</span>
                                        </time>
                                        <div class="promo-new-meta-description small">
                                            <span class="d-block text-nowrap">{{ \Carbon\Carbon::parse($match->datetime)->format('H:i') }}</span>
                                            <span class="d-block">{{ \Carbon\Carbon::parse($match->datetime)->format('l') }}</span>
                                        </div>
                                    </div>
                                    <div class="promo-new-figure">
                                        <img src="{{ asset('assets/frontend/images/padel-stad.jpg') }}" alt="" width="470" height="353"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-5 offset-xl-1">
                                <div class="promo-new-details">
                                    <h3 class="promo-new-title">{{ getMatchTournament($match)->name }}</h3>
                                    <p class="promo-new-location ls-normal">
                                        <span class="text-primary">{{ getMatchCategory($match)->name }}</span>
                                    </p>
                                    <div class="promo-main promo-new-main">
                                        <div class="promo-team-title">
                                            <div class="promo-team-name">{{ $match->homeTeam?->nickname }}</div>
                                        </div>
                                        <div class="promo-new-middle">VS</div>
                                        <div class="promo-team-title">
                                            <div class="promo-team-name">{{ $match->awayTeam?->nickname }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Latest News-->
    <section class="section section-xl bg-white">
        <div class="container">
            <div class="main-component">
                <!-- Heading Component-->
                <article class="heading-component heading-component-lg no-decor">
                    <div class="heading-component-inner">
                        <h5 class="heading-component-title">THIS WEEK IN TENNIS
                        </h5><a class="button button-sm button-gray-outline mb-0" href="sport-elements.html">Read more</a>
                    </div>
                </article>
            </div>
            <div class="row row-lg row-15 row-sm-30">
                <div class="col-lg-8">
                    <!-- Post Iris-->
                    <article class="post-iris post-iris-lg"><img src="{{ asset('assets/frontend/images/tennis/post-iris-4-770x580.jpg') }}" alt="" width="770" height="580"/>
                        <div class="post-iris-main">
                            <!-- Badge-->
                            <div class="badge badge-sm badge-secondary">Interview
                            </div>
                            <h4 class="post-iris-title ls-normal"><a href="blog-post.html">Evans Makes Winning Start In Marrakech</a></h4>
                            <div class="post-iris-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                <time datetime="2024">January 15, 2023</time>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4">
                    <div class="row row-15">
                        <div class="col-sm-6 col-lg-12">
                            <!-- Post Iris-->
                            <article class="post-iris"><img src="{{ asset('assets/frontend/images/tennis/post-iris-5-370x280.jpg') }}" alt="" width="370" height="280"/>
                                <div class="post-iris-main">
                                    <!-- Badge-->
                                    <div class="badge badge-sm badge-secondary">Match Report
                                    </div>
                                    <h4 class="post-iris-title ls-normal"><a href="blog-post.html">Thiem Reaches Maiden QF Of Season In Estoril</a></h4>
                                    <div class="post-iris-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                        <time datetime="2024">January 15, 2023</time>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-6 col-lg-12">
                            <!-- Post Iris-->
                            <article class="post-iris"><img src="{{ asset('assets/frontend/images/tennis/post-iris-6-370x280.jpg') }}" alt="" width="370" height="280"/>
                                <div class="post-iris-main">
                                    <!-- Badge-->
                                    <div class="badge badge-sm badge-secondary">Off Court News
                                    </div>
                                    <h4 class="post-iris-title ls-normal"><a href="blog-post.html">Nadal Receives Replica Of Roland Garros Statue</a></h4>
                                    <div class="post-iris-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                        <time datetime="2024">January 15, 2023</time>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story-->
    <section class="section section-xl bg-white">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-8">
                    <div class="main-component owl-carousel-outer-navigation offset-xl">
                        <!-- Heading Component-->
                        <article class="heading-component heading-component-lg no-decor">
                            <div class="heading-component-inner">
                                <h5 class="heading-component-title">WTA Rankings
                                </h5>
                            </div>
                        </article>
                        <div class="row row-eight row-30">
                            <div class="col-md-3">
                                <div class="player-info-rank context-dark">
                                    <div class="player-info-rank-main">
                                        <div class="player-info-rank-figure"><img src="{{ asset('assets/frontend/images/tennis/iga-swiatek-270x200.jpg') }}" alt="" width="270" height="200"/>
                                        </div>
                                        <div class="player-info-rank-body">
                                            <div class="player-info-rank-desc heading-4">Singles</div>
                                            <div class="player-info-rank-pos heading-2 text-primary">#1</div>
                                            <div class="player-info-rank-points">
                                                <div class="small text-gray-500 fw-medium">Points</div>
                                                <div class="heading-4">8976</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="player-info-rank-footer">
                                        <div class="player-info-rank-name heading-5 lh-1">Iga</div>
                                        <div class="player-info-rank-surname heading-4 lh-1 mt-0">Swiatek</div>
                                        <div class="player-info-rank-country"><img src="{{ asset('assets/frontend/images/tennis/pol-18x12.jpg') }}" alt="" width="18" height="12"/><span class="small">Pol</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="table-custom-responsive table-rankings-wrap">
                                    <table class="table-custom table-rankings">
                                        <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Player</th>
                                            <th>Points</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="heading-4">2<span>-</span></td>
                                            <td>
                                                <div class="unit unit-spacing-sm unit-horizontal align-items-center">
                                                    <div class="unit-left"><img src="{{ asset('assets/frontend/images/tennis/player-1-32x32.jpg') }}" alt="" width="32" height="32"/>
                                                    </div>
                                                    <div class="unit-body">
                                                        <p class="heading-7 lh-1">A.Sabalenka</p>
                                                        <p class="mt-0 small lh-1"><img src="{{ asset('assets/frontend/images/tennis/usa-18x12.jpg') }}" alt="" width="18" height="12"/><span class="fw-medium ps-1 align-middle">BLR</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="heading-4 text-primary">6987</td>
                                        </tr>
                                        <tr>
                                            <td class="heading-4">3<span>-</span></td>
                                            <td>
                                                <div class="unit unit-spacing-sm unit-horizontal align-items-center">
                                                    <div class="unit-left"><img src="{{ asset('assets/frontend/images/tennis/player-2-32x32.jpg') }}" alt="" width="32" height="32"/>
                                                    </div>
                                                    <div class="unit-body">
                                                        <p class="heading-7 lh-1">J.PEGULA</p>
                                                        <p class="mt-0 small lh-1"><img src="{{ asset('assets/frontend/images/tennis/usa-18x12.jpg') }}" alt="" width="18" height="12"/><span class="fw-medium ps-1 align-middle">USA</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="heading-4 text-primary">5605</td>
                                        </tr>
                                        <tr>
                                            <td class="heading-4">4<span>-</span></td>
                                            <td>
                                                <div class="unit unit-spacing-sm unit-horizontal align-items-center">
                                                    <div class="unit-left"><img src="{{ asset('assets/frontend/images/tennis/player-3-32x32.jpg') }}" alt="" width="32" height="32"/>
                                                    </div>
                                                    <div class="unit-body">
                                                        <p class="heading-7 lh-1">C. GARCIA</p>
                                                        <p class="mt-0 small lh-1"><img src="{{ asset('assets/frontend/images/tennis/fra-18x12.jpg') }}" alt="" width="18" height="12"/><span class="fw-medium ps-1 align-middle">FRA</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="heading-4 text-primary">4990</td>
                                        </tr>
                                        <tr>
                                            <td class="heading-4">5<span>-</span></td>
                                            <td>
                                                <div class="unit unit-spacing-sm unit-horizontal align-items-center">
                                                    <div class="unit-left"><img src="{{ asset('assets/frontend/images/tennis/player-4-32x32.jpg') }}" alt="" width="32" height="32"/>
                                                    </div>
                                                    <div class="unit-body">
                                                        <p class="heading-7 lh-1">O. JABEUR</p>
                                                        <p class="mt-0 small lh-1"><img src="{{ asset('assets/frontend/images/tennis/tun-18x12.jpg') }}" alt="" width="18" height="12"/><span class="fw-medium ps-1 align-middle">TUN</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="heading-4 text-primary">4567</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-component owl-carousel-outer-navigation offset-xl">
                        <!-- Heading Component-->
                        <article class="heading-component heading-component-lg no-decor">
                            <div class="heading-component-inner">
                                <h5 class="heading-component-title">Video Highlights
                                </h5><a class="button button-sm button-gray-outline mb-0" href="sport-elements.html">more videos</a>
                            </div>
                        </article>
                        <div class="row row-eight row-30">
                            <div class="col-md-5">
                                <!-- Post mia-->
                                <article class="post-mia post-mia-lg">
                                    <div class="post-mia-figure"><img src="{{ asset('assets/frontend/images/tennis/post-mia-1-470x320.jpg') }}" alt="" width="470" height="320"/>
                                        <!-- Post Video Button--><a class="post-video-button-2 post-video-button-lg" href="#modal1" data-bs-toggle="modal"><span class="icon material-icons-play_arrow"></span></a>
                                    </div>
                                    <div class="post-mia-main">
                                        <h4 class="post-mia-title ls-normal"><a href="blog-post.html">Bogota: Sorribes Tormo rallies into first quarterfinal of season</a></h4>
                                        <div class="post-mia-meta ls-normal small fw-medium">
                                            <div class="post-meta-item pe-1">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                <time datetime="2024">January 15, 2023</time>
                                            </div>
                                            <div class="post-meta-item"><span class="time">01:43</span></div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-md-3">
                                <div class="swiper-container swiper-slider swiper-post" data-swiper='{"autoplay":false,"loop":false,"simulateTouch":true,"slidesPerView":1,"spaceBetween":30,"scrollbar":{"el":".swiper-scrollbar","draggable":true},"breakpoints":{"576":{"slidesPerView":2},"768":{"spaceBetween":30,"slidesPerView":2,"direction":"vertical"}}}'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <!-- Post mia-->
                                            <article class="post-mia">
                                                <div class="post-mia-figure"><img src="{{ asset('assets/frontend/images/tennis/post-mia-2-240x166.jpg') }}" alt="" width="240" height="166"/>
                                                    <!-- Post Video Button--><a class="post-video-button-2" href="#modal1" data-bs-toggle="modal"><span class="icon material-icons-play_arrow"></span></a>
                                                </div>
                                                <div class="post-mia-main">
                                                    <h4 class="post-mia-title ls-normal"><a href="blog-post.html">Shot of the Month: Jabeur comes up big in March</a></h4>
                                                    <div class="post-mia-meta ls-normal small fw-medium">
                                                        <div class="post-meta-item pe-1">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                            <time datetime="2024">January 15, 2023</time>
                                                        </div>
                                                        <div class="post-meta-item"><span class="time">01:43</span></div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <!-- Post mia-->
                                            <article class="post-mia">
                                                <div class="post-mia-figure"><img src="{{ asset('assets/frontend/images/tennis/post-mia-3-240x166.jpg') }}" alt="" width="240" height="166"/>
                                                    <!-- Post Video Button--><a class="post-video-button-2" href="#modal1" data-bs-toggle="modal"><span class="icon material-icons-play_arrow"></span></a>
                                                </div>
                                                <div class="post-mia-main">
                                                    <h4 class="post-mia-title ls-normal"><a href="blog-post.html">TopCourt with Aryna Sabalenka</a></h4>
                                                    <div class="post-mia-meta ls-normal small fw-medium">
                                                        <div class="post-meta-item pe-1">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                            <time datetime="2024">January 15, 2023</time>
                                                        </div>
                                                        <div class="post-meta-item"><span class="time">01:43</span></div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <!-- Post mia-->
                                            <article class="post-mia">
                                                <div class="post-mia-figure"><img src="{{ asset('assets/frontend/images/tennis/post-mia-4-240x166.jpg') }}" alt="" width="240" height="166"/>
                                                    <!-- Post Video Button--><a class="post-video-button-2" href="#modal1" data-bs-toggle="modal"><span class="icon material-icons-play_arrow"></span></a>
                                                </div>
                                                <div class="post-mia-main">
                                                    <h4 class="post-mia-title ls-normal"><a href="blog-post.html">Tennis betting: We're backing Jannik Sinner to dominate in Barcelona</a></h4>
                                                    <div class="post-mia-meta ls-normal small fw-medium">
                                                        <div class="post-meta-item pe-1">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                            <time datetime="2024">January 15, 2023</time>
                                                        </div>
                                                        <div class="post-meta-item"><span class="time">01:43</span></div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="swiper-slide">
                                            <!-- Post mia-->
                                            <article class="post-mia">
                                                <div class="post-mia-figure"><img src="{{ asset('assets/frontend/images/tennis/post-mia-5-240x166.jpg') }}" alt="" width="240" height="166"/>
                                                    <!-- Post Video Button--><a class="post-video-button-2" href="#modal1" data-bs-toggle="modal"><span class="icon material-icons-play_arrow"></span></a>
                                                </div>
                                                <div class="post-mia-main">
                                                    <h4 class="post-mia-title ls-normal"><a href="blog-post.html">RACQUET REVIEW: VOLKL C10 PRO</a></h4>
                                                    <div class="post-mia-meta ls-normal small fw-medium">
                                                        <div class="post-meta-item pe-1">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                            <time datetime="2024">January 15, 2023</time>
                                                        </div>
                                                        <div class="post-meta-item"><span class="time">01:43</span></div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-component owl-carousel-outer-navigation offset-xl">
                        <!-- Heading Component-->
                        <article class="heading-component heading-component-lg no-decor">
                            <div class="heading-component-inner">
                                <h5 class="heading-component-title">HOT NEWS
                                </h5>
                                <div class="owl-carousel-arrows-outline owl-carousel-arrows-sm owl-carousel-arrows-secondary">
                                    <div class="owl-nav">
                                        <button class="owl-arrow owl-arrow-prev"></button>
                                        <button class="owl-arrow owl-arrow-next"></button>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <!-- Owl Carousel-->
                        <div class="owl-carousel" data-items="1" data-md-items="2" data-autoplay-speed="4000" data-dots="false" data-nav="true" data-stage-padding="0" data-margin="30" data-mouse-drag="false" data-nav-custom=".owl-carousel-outer-navigation">
                            <div class="post-simple-list">
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-1-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Nadal Receives Replica Of Roland Garros Statue</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-2-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Djokovic Set For No. 1 Return Monday</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-3-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Wawrinka, Fognini Awarded Monte Carlo Wild Cards</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-4-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">ITF RESUMES TENNIS IN CHINA, WITH STILL NO WORD ON PENG SHUAI</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="post-simple-list">
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-5-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">ITALIAN OPEN TO AWARD WOMEN EQUAL PRIZE MONEY BY 2025</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-6-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">The Last Time With… Francisco Cerundolo</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-7-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Jack Sock On Patrick Mahomes: 'Just An Awesome Dude'</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-8-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Federer: 'My Foundation Will Be At The Forefront Of My Priorities'</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="post-simple-list">
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-9-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">DAYS AFTER BEING ROBBED, GRIGOR WINS BARCELONA OPENER</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-10-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">SHELBY ROGERS, TOUR PLAYER AND TOUR GUIDE, HIGHLIGHTS</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-11-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Alcaraz brushes aside Borges in Barcelona</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                                <!-- Post simple-->
                                <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-12-110x82.jpg') }}" alt="" width="110" height="82"/>
                                    <div class="post-simple-main">
                                        <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Rebeka Mertena earns 102nd career singles victory</a></h6>
                                        <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                            <time datetime="2023">January 15, 2023</time>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Aside Block-->
                <div class="col-lg-4">
                    <aside class="aside-components">
                        <div class="aside-component aside-component-bordered">
                            <!-- Heading Component-->
                            <article class="heading-component heading-component-sm heading-component-primary no-decor">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Grand Prix Hassan II
                                    </h5>
                                    <p class="heading-component-subtitle text-capitalize text-primary ls-normal">Marrakech, Morocco</p>
                                </div>
                            </article>
                            <div class="game-result-boxed">
                                <div class="game-result-boxed-meta group-xs">
                                    <div class="game-result-boxed-meta-item">Round Of 16 - Center Court</div>
                                    <div class="game-result-boxed-meta-item">01:18:24</div>
                                </div>
                                <div class="table-custom-responsive">
                                    <table class="table-game-result-boxed">
                                        <tr>
                                            <td>
                                                <div class="game-result-boxed-player"><img src="{{ asset('assets/frontend/images/tennis/usa-32x22.jpg') }}" alt="" width="32" height="22"/><span>J.Isner</span>
                                                </div><span class="icon icomoon-check icon-success"></span>
                                            </td>
                                            <td>0</td>
                                            <td>4</td>
                                            <td>6</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="game-result-boxed-player"><img src="{{ asset('assets/frontend/images/tennis/ned-32x22.jpg') }}" alt="" width="32" height="22"/><span>G. Brouwer</span>
                                                </div>
                                            </td>
                                            <td>0</td>
                                            <td>6</td>
                                            <td>5</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="game-result-boxed-footer small">The match has been suspended due to rain.</div>
                            </div>
                            <div class="game-result-boxed">
                                <div class="game-result-boxed-meta group-xs">
                                    <div class="game-result-boxed-meta-item">Round Of 16 - Center Court</div>
                                    <div class="game-result-boxed-meta-item">01:18:24</div>
                                </div>
                                <div class="table-custom-responsive">
                                    <table class="table-game-result-boxed">
                                        <tr>
                                            <td>
                                                <div class="game-result-boxed-player"><img src="{{ asset('assets/frontend/images/tennis/ita-32x22.jpg') }}" alt="" width="32" height="22"/><span>L.Musetti</span>
                                                </div><span class="icon icomoon-check icon-success"></span>
                                            </td>
                                            <td>6</td>
                                            <td>6</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="game-result-boxed-player"><img src="{{ asset('assets/frontend/images/tennis/fra-32x22.jpg') }}" alt="" width="32" height="22"/><span>H.Gaston</span>
                                                </div>
                                            </td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="game-result-boxed-footer small">Game Set and Match Lorenzo Musetti. Lorenzo Musetti wins the match 6-2 6-3 .</div>
                            </div>
                            <div class="game-result-boxed">
                                <div class="game-result-boxed-meta group-xs">
                                    <div class="game-result-boxed-meta-item">Round Of 32 - Court 7</div>
                                    <div class="game-result-boxed-meta-item">02:07:31</div>
                                </div>
                                <div class="table-custom-responsive">
                                    <table class="table-game-result-boxed">
                                        <tr>
                                            <td>
                                                <div class="game-result-boxed-player"><img src="{{ asset('assets/frontend/images/tennis/aus-32x22.jpg') }}" alt="" width="32" height="22"/><span>M. Purcell</span>
                                                </div>
                                            </td>
                                            <td>6</td>
                                            <td>3</td>
                                            <td>4</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="game-result-boxed-player"><img src="{{ asset('assets/frontend/images/tennis/ger-32x22.jpg') }}" alt="" width="32" height="22"/><span>D. Altmaier</span>
                                                </div><span class="icon icomoon-check icon-success"></span>
                                            </td>
                                            <td>4</td>
                                            <td>6</td>
                                            <td>3</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="game-result-boxed-footer small">The match has been suspended due to rain.</div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection
