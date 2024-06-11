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
    <section class="section section-xl bg-white">
        <div class="container">
            <div class="row row-50">
                <div class="col-md-12 owl-carousel-outer-navigation">
                    <!-- Heading Component-->
                    <article class="heading-component heading-component-lg no-decor">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">Upcoming events
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
                        <div class="promo-new row row-30">
                            <div class="col-md-6">
                                <div class="promo-new-wrap">
                                    <div class="promo-new-meta context-dark align-items-start">
                                        <time class="promo-new-time lh-1" datetime="2023-12-31"><span class="heading-3">02</span><span class="heading-5">Apr</span></time>
                                        <div class="promo-new-meta-description small"><span class="d-block text-nowrap">08:30 pm</span><span class="d-block">Saturday</span></div>
                                    </div>
                                    <div class="promo-new-figure"><img src="{{ asset('assets/frontend/images/padel-stad.jpg') }}" alt="" width="470" height="353"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-5 offset-xl-1">
                                <div class="promo-new-details">
                                    <h3 class="promo-new-title">Credit One Charleston Open</h3>
                                    <p class="promo-new-location ls-normal">
                                        <svg class="promo-new-svg-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                                            <path d="M12.0011 0C6.92264 0 2.79102 4.13162 2.79102 9.21006C2.79102 11.301 3.47688 13.2734 4.77579 14.9158L12.0011 24L19.2278 14.9141C20.5254 13.2734 21.2112 11.3009 21.2112 9.21006C21.2112 4.13162 17.0796 0 12.0011 0ZM18.0359 13.9688L12.0011 21.5561L5.9677 13.9704C4.88477 12.6011 4.31229 10.955 4.31229 9.21006C4.31234 4.97048 7.7615 1.52133 12.0011 1.52133C16.2408 1.52133 19.6899 4.97048 19.6899 9.21006C19.6899 10.955 19.1175 12.6011 18.0359 13.9688Z"></path>
                                            <path d="M12.0025 5.29395C9.90539 5.29395 8.19922 7.00011 8.19922 9.09726C8.19922 11.1944 9.90539 12.9006 12.0025 12.9006C14.0997 12.9006 15.8059 11.1944 15.8059 9.09726C15.8059 7.00011 14.0997 5.29395 12.0025 5.29395ZM12.0025 11.3793C10.7443 11.3793 9.72055 10.3556 9.72055 9.09726C9.72055 7.83897 10.7443 6.81527 12.0025 6.81527C13.2608 6.81527 14.2845 7.83897 14.2845 9.09726C14.2845 10.3556 13.2608 11.3793 12.0025 11.3793Z"></path>
                                        </svg><span class="text-primary">Charleston, United States</span>
                                    </p>
                                    <div class="promo-main promo-new-main">
                                        <div class="promo-team promo-new-team">
                                            <figure class="promo-team-figure"><img src="{{ asset('assets/frontend/images/tennis/usa-70x48.jpg') }}" alt="" width="70" height="48"/>
                                            </figure>
                                            <div class="promo-team-title">
                                                <div class="promo-team-name">John Isner</div>
                                                <div class="promo-team-country">Usa</div>
                                            </div>
                                        </div>
                                        <div class="promo-new-middle">VS</div>
                                        <div class="promo-team promo-new-team">
                                            <figure class="promo-team-figure"><img src="{{ asset('assets/frontend/images/tennis/ned-70x48.jpg') }}" alt="" width="70" height="48"/>
                                            </figure>
                                            <div class="promo-team-title">
                                                <div class="promo-team-name">GIJS Brouwer</div>
                                                <div class="promo-team-country">Ned</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="promo-new-tickets group-md text-gray-800"><a class="button button-secondary button-sm" href="#">Buy tickets</a>
                                        <p class="ls-normal">Only&nbsp;<span class="text-primary">89</span>&nbsp;tickets left, hurry up!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="promo-new row row-30">
                            <div class="col-md-6">
                                <div class="promo-new-wrap">
                                    <div class="promo-new-meta context-dark align-items-start">
                                        <time class="promo-new-time lh-1" datetime="2023-12-31"><span class="heading-3">08</span><span class="heading-5">Apr</span></time>
                                        <div class="promo-new-meta-description small"><span class="d-block text-nowrap">09:30 pm</span><span class="d-block">Saturday</span></div>
                                    </div>
                                    <div class="promo-new-figure"><img src="{{ asset('assets/frontend/images/tennis/sport-elements-2-470x353.jpg') }}" alt="" width="470" height="353"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-5 offset-xl-1">
                                <div class="promo-new-details">
                                    <h3 class="promo-new-title">THE KING OF CLAY COUNTDOWN</h3>
                                    <p class="promo-new-location ls-normal">
                                        <svg class="promo-new-svg-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" fill="none">
                                            <path d="M12.0011 0C6.92264 0 2.79102 4.13162 2.79102 9.21006C2.79102 11.301 3.47688 13.2734 4.77579 14.9158L12.0011 24L19.2278 14.9141C20.5254 13.2734 21.2112 11.3009 21.2112 9.21006C21.2112 4.13162 17.0796 0 12.0011 0ZM18.0359 13.9688L12.0011 21.5561L5.9677 13.9704C4.88477 12.6011 4.31229 10.955 4.31229 9.21006C4.31234 4.97048 7.7615 1.52133 12.0011 1.52133C16.2408 1.52133 19.6899 4.97048 19.6899 9.21006C19.6899 10.955 19.1175 12.6011 18.0359 13.9688Z"></path>
                                            <path d="M12.0025 5.29395C9.90539 5.29395 8.19922 7.00011 8.19922 9.09726C8.19922 11.1944 9.90539 12.9006 12.0025 12.9006C14.0997 12.9006 15.8059 11.1944 15.8059 9.09726C15.8059 7.00011 14.0997 5.29395 12.0025 5.29395ZM12.0025 11.3793C10.7443 11.3793 9.72055 10.3556 9.72055 9.09726C9.72055 7.83897 10.7443 6.81527 12.0025 6.81527C13.2608 6.81527 14.2845 7.83897 14.2845 9.09726C14.2845 10.3556 13.2608 11.3793 12.0025 11.3793Z"></path>
                                        </svg><span class="text-primary">Charleston, United States</span>
                                    </p>
                                    <div class="promo-main promo-new-main">
                                        <div class="promo-team promo-new-team">
                                            <figure class="promo-team-figure"><img src="{{ asset('assets/frontend/images/tennis/tun-70x48.jpg') }}" alt="" width="70" height="48"/>
                                            </figure>
                                            <div class="promo-team-title">
                                                <div class="promo-team-name">Wade Warren</div>
                                                <div class="promo-team-country">TUN</div>
                                            </div>
                                        </div>
                                        <div class="promo-new-middle">VS</div>
                                        <div class="promo-team promo-new-team">
                                            <figure class="promo-team-figure"><img src="{{ asset('assets/frontend/images/tennis/usa-70x48.jpg') }}" alt="" width="70" height="48"/>
                                            </figure>
                                            <div class="promo-team-title">
                                                <div class="promo-team-name">Robert Fox</div>
                                                <div class="promo-team-country">USA</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="promo-new-tickets group-md text-gray-800"><a class="button button-secondary button-sm" href="#">Buy tickets</a>
                                        <p class="ls-normal">Only&nbsp;<span class="text-primary">89</span>&nbsp;tickets left, hurry up!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                    <div class="main-component offset-xl">
                        <!-- Heading Component-->
                        <article class="heading-component heading-component-lg no-decor">
                            <div class="heading-component-inner">
                                <h5 class="heading-component-title">STORY OF THE SEASON
                                </h5>
                            </div>
                        </article>
                        <!-- Post grace-->
                        <article class="post-grace"><a class="post-grace-figure" href="blog-post.html"><img src="{{ asset('assets/frontend/images/tennis/post-grace-1-270x200.jpg') }}" alt="" width="270" height="200"/></a>
                            <div class="post-grace-main">
                                <!-- Badge-->
                                <div class="badge badge-sm badge-secondary">Match Report
                                </div>
                                <h4 class="post-grace-title ls-normal"><a href="blog-post.html">#NextGenATP Q1 Review: Shelton, Fils Enjoy Strong Starts To Season</a></h4>
                                <div class="post-grace-text">
                                    <p>The first quarter of the 2023 ATP Tour season marked breakthrough runs, career-best wins and titles on the ATP Challenger Tour.</p>
                                </div>
                                <div class="post-grace-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                    <time datetime="2024">January 15, 2023</time>
                                </div>
                            </div>
                        </article>
                        <!-- Post grace-->
                        <article class="post-grace"><a class="post-grace-figure" href="blog-post.html"><img src="{{ asset('assets/frontend/images/tennis/post-grace-2-270x200.jpg') }}" alt="" width="270" height="200"/></a>
                            <div class="post-grace-main">
                                <!-- Badge-->
                                <div class="badge badge-sm badge-secondary">Match Report
                                </div>
                                <h4 class="post-grace-title ls-normal"><a href="blog-post.html">Scouting Report: Ruud, Tiafoe &amp; Musetti Headline In Estoril, Houston &amp; Marrakech</a></h4>
                                <div class="post-grace-text">
                                    <p>ATP Tour returns to clay this week with events in Estoril, Houston and Marrakech. Ruud is the top seed at the Millennium EstorIL Open.</p>
                                </div>
                                <div class="post-grace-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                    <time datetime="2024">January 13, 2023</time>
                                </div>
                            </div>
                        </article>
                        <!-- Post grace-->
                        <article class="post-grace"><a class="post-grace-figure" href="blog-post.html"><img src="{{ asset('assets/frontend/images/tennis/post-grace-3-270x200.jpg') }}" alt="" width="270" height="200"/></a>
                            <div class="post-grace-main">
                                <!-- Badge-->
                                <div class="badge badge-sm badge-secondary">Off Court
                                </div>
                                <h4 class="post-grace-title ls-normal"><a href="blog-post.html">Nadal Receives Replica Of Roland Garros Statue</a></h4>
                                <div class="post-grace-text">
                                    <p>On Thursday at the Rafa Nadal Academy by Movistar, Rafael Nadal received a replica of the sculpture that was unveiled in May 2024.</p>
                                </div>
                                <div class="post-grace-meta small ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                    <time datetime="2024">January 11, 2023</time>
                                </div>
                            </div>
                        </article>
                    </div>
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
                        <div class="aside-component">
                            <div class="rd-mailform-corporate-wrap">
                                <h4 class="rd-mailform-corporate-title">Sign Up to our News!</h4>
                                <h5 class="small rd-mailform-corporate-subtitle">Get the latest tennis news</h5>
                                <!-- Mail Form corporate-->
                                <form class="form-xs rd-mailform rd-mailform-corporate" data-form-output="form-output-global" data-form-type="subscribe" method="post" action="bat/rd-mailform.php">
                                    <div class="form-wrap">
                                        <label class="form-label" for="subscribe-email">Enter Your E-mail</label>
                                        <input class="form-input" id="subscribe-email" type="email" name="email" data-constraints="info@arzgt.com">
                                    </div>
                                    <div class="form-wrap">
                                        <button class="button button-block button-secondary button-sm" type="submit">Subscribe</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="aside-component aside-component-bordered">
                            <!-- Heading Component-->
                            <article class="heading-component heading-component-sm heading-component-primary no-decor">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Recomended
                                    </h5>
                                </div>
                            </article>
                            <!-- List Post minimal-->
                            <!-- Post tiny-->
                            <article class="post-tiny">
                                <!-- Badge-->
                                <div class="badge badge-sm badge-secondary">Match Report
                                </div>
                                <h6 class="post-tiny-title"><a href="blog-post.html">DIY TENNIS: HOW AN UNORTHODOX STYLE THRIVES IN MODERN GAME</a></h6>
                                <div class="post-tiny-text">
                                </div>
                                <div class="post-tiny-meta small fw-medium">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                    <time datetime="2024">Janyary 15, 2023</time>
                                </div>
                            </article>
                            <!-- Post tiny-->
                            <article class="post-tiny">
                                <!-- Badge-->
                                <div class="badge badge-sm badge-secondary">Match Report
                                </div>
                                <h6 class="post-tiny-title"><a href="blog-post.html">Cerundolo &amp; Etcheverry Score Slam Dunk Meeting With Manu Ginobili</a></h6>
                                <div class="post-tiny-text">
                                </div>
                                <div class="post-tiny-meta small fw-medium">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                    <time datetime="2024">Janyary 15, 2023</time>
                                </div>
                            </article>
                            <!-- Post tiny-->
                            <article class="post-tiny">
                                <!-- Badge-->
                                <div class="badge badge-sm badge-secondary">Match Report
                                </div>
                                <h6 class="post-tiny-title"><a href="blog-post.html">Miami Open Unites Campaign Returns for A Third Year</a></h6>
                                <div class="post-tiny-text">
                                </div>
                                <div class="post-tiny-meta small fw-medium">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                    <time datetime="2024">Janyary 15, 2023</time>
                                </div>
                            </article>
                        </div>
                        <div class="aside-component aside-component-bordered">
                            <!-- Heading Component-->
                            <article class="heading-component heading-component-sm heading-component-primary no-decor">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Stay connected
                                    </h5>
                                </div>
                            </article>
                            <div class="group-icon-media fz-0"><a class="icon-media icon-media-bordered icon-media-round icon-media-sm icomoon-facebook" href="#"></a><a class="icon-media icon-media-bordered icon-media-round icon-media-sm icomoon-instagram" href="#"></a><a class="icon-media icon-media-bordered icon-media-round icon-media-sm icomoon-twitter" href="#"></a><a class="icon-media icon-media-bordered icon-media-round icon-media-sm icomoon-youtube" href="#"></a><a class="icon-media icon-media-bordered icon-media-round icon-media-sm icomoon-linkedin" href="#"></a><a class="icon-media icon-media-bordered icon-media-round icon-media-sm icomoon-gitlab" href="#"></a><a class="icon-media icon-media-bordered icon-media-round icon-media-sm icomoon-github" href="#"></a><a class="icon-media icon-media-bordered icon-media-round icon-media-sm icomoon-google" href="#"></a></div>
                        </div>
                        <div class="aside-component aside-component-bordered">
                            <!-- Heading Component-->
                            <article class="heading-component heading-component-sm heading-component-primary no-decor">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Latest &amp; popular news
                                    </h5>
                                </div>
                            </article>
                            <div class="tabs-custom tabs-horizontal tabs-modern tabs-modern_2">
                                <!-- Nav tabs-->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="tab"><a class="nav-link active" href="#tabs-product-1" data-bs-toggle="tab">recent</a></li>
                                    <li class="nav-item" role="tab"><a class="nav-link" href="#tabs-product-2" data-bs-toggle="tab">popular</a></li>
                                </ul>
                                <!-- Tab panes-->
                                <div class="tab-content">
                                    <div class="tab-pane active show fade" id="tabs-product-1" role="tabpanel">
                                        <div class="post-simple-list">
                                            <!-- Post simple-->
                                            <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-13-110x82.jpg') }}" alt="" width="110" height="82"/>
                                                <div class="post-simple-main">
                                                    <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Bonzi Advances In Rainy Marrakech</a></h6>
                                                    <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                        <time datetime="2023">January 15, 2023</time>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- Post simple-->
                                            <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-8-110x82.jpg') }}" alt="" width="110" height="82"/>
                                                <div class="post-simple-main">
                                                    <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Really Excited' Wolf Makes Fast Start In Houston</a></h6>
                                                    <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                        <time datetime="2023">January 15, 2023</time>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- Post simple-->
                                            <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-14-110x82.jpg') }}" alt="" width="110" height="82"/>
                                                <div class="post-simple-main">
                                                    <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Nominations Open For Tom Perrotta Journalism Award</a></h6>
                                                    <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                        <time datetime="2023">January 15, 2023</time>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tabs-product-2" role="tabpanel">
                                        <div class="post-simple-list">
                                            <!-- Post simple-->
                                            <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-15-110x82.jpg') }}" alt="" width="110" height="82"/>
                                                <div class="post-simple-main">
                                                    <h6 class="post-simple-title ls-normal"><a href="blog-post.html">BARCELONA OPEN BANC SABADELL</a></h6>
                                                    <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                        <time datetime="2023">January 15, 2023</time>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- Post simple-->
                                            <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-16-110x82.jpg') }}" alt="" width="110" height="82"/>
                                                <div class="post-simple-main">
                                                    <h6 class="post-simple-title ls-normal"><a href="blog-post.html">DJOKOVIC ISSUES FITNESS UPDATE, ADMITS ELBOW 'NOT IN IDEAL SHAPE’</a></h6>
                                                    <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                        <time datetime="2023">January 15, 2023</time>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- Post simple-->
                                            <article class="post-simple"><img src="{{ asset('assets/frontend/images/tennis/post-simple-17-110x82.jpg') }}" alt="" width="110" height="82"/>
                                                <div class="post-simple-main">
                                                    <h6 class="post-simple-title ls-normal"><a href="blog-post.html">Djokovic tested but prevails in Banja Luka opener</a></h6>
                                                    <div class="post-simple-meta small lh-1 ls-normal">By&nbsp;<span>Frances Pruyn</span>,&nbsp;
                                                        <time datetime="2023">January 15, 2023</time>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
