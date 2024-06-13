@extends('main')

@section('content')

    <section class="section section-sm bg-gray-100">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-8">
                    <div class="row row-50">
                        <div class="col-sm-12">
                            <!-- Heading Component-->
                            <article class="heading-component">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Game Overview
                                    </h5>
                                </div>
                            </article>
                            <!-- Game Result Bug-->
                            <article class="game-result">
                                <div class="game-info game-info-classic">
                                    <p class="game-info-subtitle">{{ getMatchTournament($match)->name }} - {{ getMatchCategory($match)->name }} -
                                        <time datetime="{{ \Carbon\Carbon::parse($match->datetime)->format('M d, Y') }}">{{ \Carbon\Carbon::parse($match->datetime)->format('M d, Y') }}</time>
                                    </p>
                                    <h3 class="game-info-title">{{ getMatchRound($match) }}</h3>
                                    <div class="game-info-main">
                                        <div class="game-info-team game-info-team-first">
                                            <div class="game-result-team-name">{{ $match->homeTeam?->nickname }}</div>
                                            <div class="game-result-team-country">Home</div>
                                        </div>
                                        <div class="game-info-middle">
                                            <div class="game-result-score-wrap">
                                                <div class="game-info-score {{ $match->winner_team_id == $match->home_team_id ? "game-result-team-win" : "" }}">{{ $match->sets->where('winner_team_id', $match->home_team_id)->count() }}</div>
                                                <div class="game-info-score {{ $match->winner_team_id == $match->away_team_id ? "game-result-team-win" : "" }}">{{ $match->sets->where('winner_team_id', $match->away_team_id)->count() }}</div>
                                            </div>
                                            <div class="game-result-divider-wrap"><span class="game-info-team-divider">VS</span></div>
                                        </div>
                                        <div class="game-info-team game-info-team-second">
                                            <div class="game-result-team-name">{{ $match->awayTeam?->nickname }}</div>
                                            <div class="game-result-team-country">Away</div>
                                        </div>
                                    </div>
                                    <!-- Table Game Info-->
                                    <div class="table-game-info-wrap"><span class="table-game-info-title">Game statistics<span></span></span>
                                        <div class="table-game-info-main table-custom-responsive">
                                            <table class="table-custom table-game-info">
                                                <tbody>
                                                @foreach($match->sets as $set)
                                                    <tr>
                                                        <td class="table-game-info-number">{{ $set->home_team_score }}</td>
                                                        <td class="table-game-info-category">Set {{ $set->set_number }}</td>
                                                        <td class="table-game-info-number">{{ $set->away_team_score }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <div class="col-sm-12">
                            <!-- Heading Component-->
                            <article class="heading-component">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Players
                                    </h5>
                                </div>
                            </article>
                            <div class="row row-30">
                                <div class="col-sm-6">
                                    <!-- Table Roster-->
                                    <div class="table-custom-responsive">
                                        <table class="table-custom table-roster">
                                            <thead>
                                            <tr>
                                                <th colspan="3">{{ $match->homeTeam?->nickname }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>NBR</td>
                                                <td>Player name</td>
                                                <td>Position</td>
                                            </tr>
                                            @foreach($match->homeTeam->players as $key => $player)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $player->full_name }}</td>
                                                <td>{{ $player->playing_side }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <!-- Table Roster-->
                                    <div class="table-custom-responsive">
                                        <table class="table-custom table-roster team2-blue">
                                            <thead>
                                            <tr>
                                                <th colspan="3">{{ $match->awayTeam?->nickname }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>NBR</td>
                                                <td>Player name</td>
                                                <td>Position</td>
                                            </tr>
                                            @foreach($match->awayTeam->players as $key => $player)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $player->full_name }}</td>
                                                    <td>{{ $player->playing_side }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row row-50">
                        <div class="col-md-6 col-lg-12">
                            <!-- Heading Component-->
                            <article class="heading-component">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Game highlights
                                    </h5>
                                </div>
                            </article>
                            <!-- Game Highlights-->
                            <div class="game-highlights overflow-x-auto" style="height: {{ count($points) ? "500px" : "auto" }}">
                                <ul class="game-highlights-list">
                                    <li>
                                        <p class="game-highlights-title">Start of the Match
                                        </p><span class="game-highlights-minute">0’</span>
                                    </li>
                                    @php
                                        $previousTime = null;
                                        $totalElapsedTime = 0;
                                    @endphp
                                    @foreach($points as $index => $point)
                                        @php
                                            if ($index === 0) {
                                                // The first point, time is 0
                                                $time = 0;
                                                $previousTime = $point->created_at;
                                            } else {
                                                // Calculate the difference in minutes from the previous point
                                                $currentTime = $point->created_at;
                                                $elapsedTime = \Carbon\Carbon::parse($previousTime)->diffInMinutes($currentTime);
                                                $totalElapsedTime += $elapsedTime;
                                                $time = $totalElapsedTime;
                                                $previousTime = $currentTime;
                                            }
                                        @endphp
                                        <li class="team-primary">
                                            <p class="game-highlights-title">
                                                <span class="icon icon-xxs icon-primary fa fa-table-tennis-paddle-ball-o"></span>
                                                <span class="game-highlights-goal">Point</span> {{ $point->home_team_score }} - {{ $point->away_team_score }}
                                            </p>
                                            <p class="game-highlights-description">{{ $point->pointTeam->nickname }} scores!</p>
                                            <span class="game-highlights-minute">{{ $time }}’</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
<script>

</script>
@endsection
