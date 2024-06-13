@extends('main')

@section('content')

    <section class="section section-sm bg-gray-100">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">Game schedule
                            </h5>
                            <div class="heading-component-aside">
                                <form id="filtersForm">
                                @csrf
                                    <ul class="list-inline list-inline-xs list-inline-middle">
                                        <li>
                                            <select name="category_id" class="select filter-input" data-placeholder="Select an option" data-container-class="select-minimal-xl">
                                                <option label="placeholder"></option>
                                                <option value="All Categories" selected="">All Categories</option>
                                                @foreach($levelCategories as $levelCategory)
                                                    <option value="{{ $levelCategory->id }}">{{ $levelCategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </li>
                                        <li>
                                            <select name="month" class="select filter-input" data-placeholder="Select an option" data-container-class="select-minimal-xs">
                                                <option label="placeholder"></option>
                                                <option value="All">All</option>
                                                <option value="1" {{ now()->month == "1" ? "selected" : "" }}>January</option>
                                                <option value="2" {{ now()->month == "2" ? "selected" : "" }}>February</option>
                                                <option value="3" {{ now()->month == "3" ? "selected" : "" }}>March</option>
                                                <option value="4" {{ now()->month == "4" ? "selected" : "" }}>April</option>
                                                <option value="5" {{ now()->month == "5" ? "selected" : "" }}>May</option>
                                                <option value="6" {{ now()->month == "6" ? "selected" : "" }}>June</option>
                                                <option value="7" {{ now()->month == "7" ? "selected" : "" }}>July</option>
                                                <option value="8" {{ now()->month == "8" ? "selected" : "" }}>August</option>
                                                <option value="9" {{ now()->month == "9" ? "selected" : "" }}>September</option>
                                                <option value="10" {{ now()->month == "10" ? "selected" : "" }}>October</option>
                                                <option value="11" {{ now()->month == "11" ? "selected" : "" }}>November</option>
                                                <option value="12" {{ now()->month == "12" ? "selected" : "" }}>December</option>
                                            </select>
                                        </li>
                                        <li>
                                            <select name="year" class="select filter-input" data-placeholder="Select an option" data-container-class="select-minimal-xs">
                                                <option label="placeholder"></option>
                                                <option value="{{ now()->subYear()->format('Y') }}">{{ now()->subYear()->format('Y') }}</option>
                                                <option value="{{ now()->format('Y') }}" selected="">{{ now()->format('Y') }}</option>
                                                <option value="{{ now()->addYear()->format('Y') }}">{{ now()->addYear()->format('Y') }}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </article>
                    <div id="matches">
                        @forelse($matches as $match)
                            <!-- Game Result Bug-->
                            <article class="game-result">
                                @php($time = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('H:i') : "N/A")
                                @php($day = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('D j') : "N/A")
                                @php($month = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('M Y') : "N/A")
                                <div class="game-info">
                                    <p class="game-info-subtitle">
                                        Time: <time> {{ $time }}</time>
                                    </p>
                                    <h3 class="game-info-title">{{ getMatchCategory($match)->name }} - {{ getMatchRound($match) }}</h3>
                                    <div class="game-info-main">
                                        <div class="game-info-team game-info-team-first">
                                            <div class="game-result-team-name">
                                                @if($match->homeTeam)
                                                    {{ $match->homeTeam->nickname }}
                                                @elseif($match->relatedHomeGame)
                                                    Winner of {{ $match->relatedHomeGame->knockoutRound?->name }}
                                                @endif
                                            </div>
                                            <div class="game-result-team-country">Home</div>
                                        </div>
                                        <div class="game-info-middle game-info-middle-vertical">
                                            <time class="time-big">
                                                <span class="heading-3">{{ $day }}</span> {{ $month }}
                                            </time>
                                            <div class="game-result-divider-wrap"><span class="game-info-team-divider">VS</span></div>
                                            <div class="group-sm">
                                                <div class="button button-sm button-share-outline">Share
                                                    <ul class="game-info-share">
                                                        <li class="game-info-share-item"><a class="icon fa fa-facebook" href="#"></a></li>
                                                        <li class="game-info-share-item"><a class="icon fa fa-twitter" href="#"></a></li>
                                                        <li class="game-info-share-item"><a class="icon fa fa-google-plus" href="#"></a></li>
                                                        <li class="game-info-share-item"><a class="icon fa fa-instagram" href="#"></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="game-info-team game-info-team-second">
                                            <div class="game-result-team-name">
                                                @if($match->awayTeam)
                                                    {{ $match->awayTeam->nickname }}
                                                @elseif($match->relatedAwayGame)
                                                    Winner of {{ $match->relatedAwayGame->knockoutRound?->name }}
                                                @endif
                                            </div>
                                            <div class="game-result-team-country">Away</div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="d-flex justify-content-center">
                                <h6>No matches available.</h6>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
<script>
    $(document).on('change', '.filter-input', function () {
        let matchesDivSelector = $('#matches');
        $.ajax({
            url: "{{ route('frontend.get-matches') }}",
            method: 'post',
            processing: true,
            serverSide: true,
            cache: true,
            processData: false,
            contentType: false,
            dataType: 'json',
            data: new FormData(document.getElementById('filtersForm')),
            success: function(data)
            {
                matchesDivSelector.empty();
                let matchesHtml = data.matchesHtml;
                matchesDivSelector.append(matchesHtml);
            },
            error: function (xhr, textStatus, errorThrown) {
                ajax_error_display(xhr, textStatus, errorThrown);
            }
        }).always(function() {
        });
    })
</script>
@endsection
