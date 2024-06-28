@extends('main')

@section('content')
    <!-- Swiper-->
    <section class="section swiper-container swiper-slider swiper-modern bg-primary"
             data-swiper='{"autoplay":false,"simulateTouch":true,"effect":"fade"}'>
        <div class="swiper-wrapper">
            @forelse($heroSections as $heroSection)
                <div class="swiper-slide"
                     data-slide-bg="{{ asset(\Illuminate\Support\Facades\Storage::url($heroSection->image)) }}">
                    <div class="container">
                        <div class="swiper-slide-caption">
                            <h2 class="lh-1 fst-normal ls-normal" style="max-width: 550px; color: {{ $heroSection->title_text_color }}"
                                data-caption-animate="fadeInLeftSmall">{{ $heroSection->title }}</h2>
                            <p class="mt-4" style="max-width: 320px; color: {{ $heroSection->description_text_color }}" data-caption-animate="fadeInLeftSmall"
                               data-caption-delay="200">{{ $heroSection->description }}</p>
                            @if($heroSection->link)
                                <a class="button button-sm button-secondary button-offset-xl"
                                   data-caption-animate="fadeInLeftSmall" data-caption-delay="400"
                                   href="{{ $heroSection->link }}">Read More</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="swiper-slide" data-slide-bg="{{ asset('assets/frontend/images/tennis/slider-slide-1-1920x720.jpg') }}">
                    <div class="container">
                        <div class="swiper-slide-caption">
                            <h2 class="lh-1 fst-normal ls-normal" style="max-width: 550px;" data-caption-animate="fadeInLeftSmall">Unique venue. Exceptional team. One passion</h2>
                            <p class="mt-4" style="max-width: 320px;" data-caption-animate="fadeInLeftSmall" data-caption-delay="200">Tennis Blastship is your #1 space for everything concerning this breathtaking sport.</p>
                            <a class="button button-sm button-secondary button-offset-xl" data-caption-animate="fadeInLeftSmall" data-caption-delay="400" href="#">Read More</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="swiper-button swiper-button-prev"></div>
        <div class="swiper-button swiper-button-next"></div>
        <div class="swiper-pagination"></div>
    </section>

    @if(count($blogs) || $firstBlog)
    <section class="section section-xl bg-white">
        <div class="container">
            <div class="main-component">
                <!-- Heading Component-->
                <article class="heading-component heading-component-lg no-decor">
                    <div class="heading-component-inner">
                        <h5 class="heading-component-title">THIS WEEK IN PADEL</h5>
                    </div>
                </article>
            </div>
            <div class="row row-lg row-15 row-sm-30">
                @if($firstBlog)
                    <div class="col-lg-8">
                        <article class="post-iris post-iris-lg">
                            <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($firstBlog->image)) }}" alt=""
                                 width="770" height="580"/>
                            <div class="post-iris-main">
                                <!-- Badge-->
                                <div class="badge badge-sm badge-secondary">{{ $firstBlog->title }}</div>
                                <h4 class="post-iris-title ls-normal">
                                    <a href="{{ $firstBlog->link ?? "#" }}">{{ $firstBlog->description }}</a>
                                </h4>
                            </div>
                        </article>
                    </div>
                @endif
                <div class="col-lg-4">
                    <div class="row row-15 overflow-x-auto" style="height: 590px">
                        @if(count($blogs))
                            @foreach($blogs as $blog)
                            <div class="col-sm-6 col-lg-12">
                                <!-- Post Iris-->
                                <article class="post-iris">
                                    <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($blog->image)) }}" alt="" width="370" height="280"/>
                                    <div class="post-iris-main">
                                        <!-- Badge-->
                                        <div class="badge badge-sm badge-secondary">{{ $blog->title }}</div>
                                        <h4 class="post-iris-title ls-normal">
                                            <a href="{{ $blog->link ?? "#" }}">{{ $blog->description }}</a>>
                                        </h4>
                                    </div>
                                </article>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

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
                                <div
                                    class="owl-carousel-arrows-outline owl-carousel-arrows-sm owl-carousel-arrows-secondary">
                                    <div class="owl-nav">
                                        <button class="owl-arrow owl-arrow-prev"></button>
                                        <button class="owl-arrow owl-arrow-next"></button>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <!-- Owl Carousel-->
                        <div class="owl-carousel" data-items="1" data-autoplay="false" data-autoplay-speed="6500"
                             data-dots="false" data-nav="true" data-stage-padding="0" data-loop="true" data-margin="30"
                             data-mouse-drag="false" data-nav-custom=".owl-carousel-outer-navigation">
                            @foreach($upcomingMatches as $match)
                                <div class="promo-new row row-30">
                                    <div class="col-md-6">
                                        <div class="promo-new-wrap">
                                            <div class="promo-new-meta context-dark align-items-start">
                                                <time class="promo-new-time lh-1" datetime="2023-12-31">
                                                    <span
                                                        class="heading-3">{{ \Carbon\Carbon::parse($match->datetime)->format('d') }}</span>
                                                    <span
                                                        class="heading-5">{{ \Carbon\Carbon::parse($match->datetime)->format('M') }}</span>
                                                </time>
                                                <div class="promo-new-meta-description small">
                                                    <span
                                                        class="d-block text-nowrap">{{ \Carbon\Carbon::parse($match->datetime)->format('H:i') }}</span>
                                                    <span
                                                        class="d-block">{{ \Carbon\Carbon::parse($match->datetime)->format('l') }}</span>
                                                </div>
                                            </div>
                                            <div class="promo-new-figure">
                                                <img src="{{ asset('assets/frontend/images/padel-stad.jpg') }}" alt=""
                                                     width="470" height="353"/>
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
                                                <div class="promo-team promo-new-team">
                                                    @if($match->homeTeam?->image)
                                                        <figure class="promo-team-figure">
                                                            <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($match->homeTeam?->image)) }}" alt="" width="70" height="48"/>
                                                        </figure>
                                                    @endif
                                                    <div class="promo-team-title">
                                                        <h4 class="text-primary">{{ $match->homeTeam?->nickname }}</h4>
                                                    </div>
                                                </div>
                                                <div class="promo-new-middle">VS</div>
                                                <div class="promo-team promo-new-team">
                                                    @if($match->awayTeam?->image)
                                                        <figure class="promo-team-figure">
                                                            <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($match->awayTeam?->image)) }}" alt="" width="70" height="48"/>
                                                        </figure>
                                                    @endif
                                                    <div class="promo-team-title">
                                                        <h4 class="text-primary">{{ $match->awayTeam?->nickname }}</h4>
                                                    </div>
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

    <!-- Story-->
    <section class="section section-xl bg-white">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-8">
                    @if(count($menPlayers))
                        <div class="main-component owl-carousel-outer-navigation offset-xl">
                            <!-- Heading Component-->
                            <article class="heading-component heading-component-lg no-decor">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Men Rankings
                                    </h5>
                                </div>
                            </article>
                            <div class="row row-eight row-30">
                                <div class="col-md-3">
                                    <div class="player-info-rank context-dark">
                                        <div class="player-info-rank-main">
                                            @if($menFirstRankPlayer->image)
                                            <div class="player-info-rank-figure">
                                                <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($menFirstRankPlayer->image)) }}" alt="" width="270" height="200"/>
                                            </div>
                                            @endif
                                            <div class="player-info-rank-body">
                                                <div class="player-info-rank-desc heading-4 text-black-50">Singles</div>
                                                <div class="player-info-rank-pos heading-2 text-primary">#1</div>
                                                <div class="player-info-rank-points">
                                                    <div class="small text-gray-500 fw-medium">Points</div>
                                                    <div
                                                        class="heading-4 text-black-50">{{ number_format($menFirstRankPlayer?->points) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="player-info-rank-footer">
                                            <div class="player-info-rank-name heading-5 lh-1">{{ $menFirstRankPlayer?->first_name }}</div>
                                            <div class="player-info-rank-surname heading-4 lh-1 mt-0">{{ $menFirstRankPlayer?->last_name }}</div>
                                            <div class="player-info-rank-country">
                                                <span class="small">{{ $menFirstRankPlayer?->country?->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 overflow-x-auto" style="height: 325px !important;">
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
                                            @foreach($menPlayers as $player)
                                                <tr>
                                                    <td class="heading-4">{{ $player->rank }}<span>-</span></td>
                                                    <td>
                                                        <div class="unit unit-spacing-sm unit-horizontal align-items-center">
                                                            @if($player->image)
                                                            <div class="unit-left">
                                                                <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($player->image)) }}" alt="" width="32" height="32"/>
                                                            </div>
                                                            @endif
                                                            <div class="unit-body">
                                                                <p class="heading-7 lh-1">{{ $player->full_name }}</p>
                                                                <p class="mt-0 small lh-1">
                                                                    <span class="fw-medium ps-1 align-middle">{{ $player->country?->name }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="heading-4 text-primary">{{ number_format($player->points) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(count($womenPlayers))
                        <div class="main-component owl-carousel-outer-navigation offset-xl">
                            <!-- Heading Component-->
                            <article class="heading-component heading-component-lg no-decor">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Women Rankings
                                    </h5>
                                </div>
                            </article>
                            <div class="row row-eight row-30">
                                <div class="col-md-3">
                                    <div class="player-info-rank context-dark">
                                        <div class="player-info-rank-main">
                                            @if($womenFirstRankPlayer->image)
                                                <div class="player-info-rank-figure">
                                                    <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($womenFirstRankPlayer->image)) }}" alt="" width="270" height="200"/>
                                                </div>
                                            @endif
                                            <div class="player-info-rank-body">
                                                <div class="player-info-rank-desc heading-4 text-black-50">Singles</div>
                                                <div class="player-info-rank-pos heading-2 text-primary">#1</div>
                                                <div class="player-info-rank-points">
                                                    <div class="small text-gray-500 fw-medium">Points</div>
                                                    <div
                                                        class="heading-4 text-black-50">{{ number_format($womenFirstRankPlayer?->points) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="player-info-rank-footer">
                                            <div class="player-info-rank-name heading-5 lh-1">{{ $womenFirstRankPlayer?->first_name }}</div>
                                            <div class="player-info-rank-surname heading-4 lh-1 mt-0">{{ $womenFirstRankPlayer?->last_name }}</div>
                                            <div class="player-info-rank-country">
                                                <span class="small">{{ $womenFirstRankPlayer?->country?->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 overflow-x-auto" style="height: 325px !important;">
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
                                            @foreach($womenPlayers as $player)
                                                <tr>
                                                    <td class="heading-4">{{ $player->rank }}<span>-</span></td>
                                                    <td>
                                                        <div class="unit unit-spacing-sm unit-horizontal align-items-center">
                                                            @if($player->image)
                                                            <div class="unit-left">
                                                                <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($player->image)) }}" alt="" width="32" height="32"/>
                                                            </div>
                                                            @endif
                                                            <div class="unit-body">
                                                                <p class="heading-7 lh-1">{{ $player->full_name }}</p>
                                                                <p class="mt-0 small lh-1">
                                                                    <span
                                                                        class="fw-medium ps-1 align-middle">{{ $player->country?->name }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="heading-4 text-primary">{{ number_format($player->points) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Aside Block-->
                @if(count($lastMatches))
                    <div class="col-lg-4">
                        <aside class="aside-components">
                            <div class="aside-component aside-component-bordered">
                                <!-- Heading Component-->
                                <article
                                    class="heading-component heading-component-sm heading-component-primary no-decor">
                                    <div class="heading-component-inner">
                                        <h5 class="heading-component-title">Last matches results
                                        </h5>
                                    </div>
                                </article>
                                @foreach($lastMatches as $match)
                                    <div class="game-result-boxed">
                                        <div class="game-result-boxed-meta group-xs">
                                            <div class="game-result-boxed-meta-item">{{ getMatchRound($match) }}</div>
                                            <div class="game-result-boxed-meta-item">{{ $match->datetime }}</div>
                                        </div>
                                        <div class="table-custom-responsive">
                                            <table class="table-game-result-boxed">
                                                <tr>
                                                    <td>
                                                        <div class="game-result-boxed-player">
                                                            @if($match->homeTeam?->image)
                                                            <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($match->homeTeam?->image)) }}" alt="" width="32" height="22">
                                                            @endif
                                                            <span>{{ $match->homeTeam?->nickname }}</span>
                                                        </div>
                                                        @if($match->winner_team_id == $match->home_team_id)
                                                            <span class="icon icomoon-check icon-success"></span>
                                                        @endif
                                                    </td>
                                                    @foreach($match->sets as $set)
                                                        <td>{{ $set->home_team_score }}</td>
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="game-result-boxed-player">
                                                            @if($match->awayTeam?->image)
                                                                <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($match->awayTeam?->image)) }}" alt="" width="32" height="22">
                                                            @endif
                                                            <span>{{ $match->awayTeam?->nickname }}</span>
                                                        </div>
                                                        @if($match->winner_team_id == $match->away_team_id)
                                                            <span class="icon icomoon-check icon-success"></span>
                                                        @endif
                                                    </td>
                                                    @foreach($match->sets as $set)
                                                        <td>{{ $set->away_team_score }}</td>
                                                    @endforeach
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </aside>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
