<!-- Game Result Bug-->
<article class="game-result">
    @php($time = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('H:i') : "N/A")
    @php($day = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('D j') : "N/A")
    @php($month = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('M Y') : "N/A")
    <div class="game-info">
        <p class="game-info-subtitle">
            Time: <time> {{ $time }}</time>
        </p>
        <h3 class="game-info-title">
            {{ getMatchTournament($match)->name }} - {{ getMatchCategory($match)->name }} - {{ getMatchRound($match) }}
            @if($match->is_started && !$match->is_completed)
                <div class="spinner-grow text-red" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            @endif
        </h3>
        <div class="game-info-main">

            <div class="game-result-team game-result-team-first game-result-team-win">
                <div class="game-result-team-name">
                    @if($match->homeTeam)
                        {{ $match->homeTeam->nickname }}
                    @elseif($match->relatedHomeGame)
                        Winner of {{ $match->relatedHomeGame->knockoutRound?->name }}
                    @endif
                </div>
                <div class="game-result-team-country">Home</div>
                @if($match->is_completed && $match->winner_team_id == $match->home_team_id)
                    <span class="game-result-team-label game-result-team-label-top">Win</span>
                @endif
            </div>

            <div class="game-info-middle game-info-middle-vertical">
                <time class="time-big">
                    <span class="heading-3">{{ $day }}</span> {{ $month }}
                </time>
                @if($match->is_started)
                    <div class="game-result-score-wrap">
                        <div class="game-result-score">{{ $match->sets->where('winner_team_id', $match->home_team_id)->count() }}</div>
                        <div class="game-result-score-divider">
                            @include('svg.divider')
                        </div>
                        <div class="game-result-score">{{ $match->sets->where('winner_team_id', $match->away_team_id)->count() }}</div>
                    </div>
                @endif
            </div>

            <div class="game-result-team game-result-team-first game-result-team-win">
                <div class="game-result-team-name">
                    @if($match->awayTeam)
                        {{ $match->awayTeam->nickname }}
                    @elseif($match->relatedAwayGame)
                        Winner of {{ $match->relatedAwayGame->knockoutRound?->name }}
                    @endif
                </div>
                <div class="game-result-team-country">Away</div>
                @if($match->is_completed && $match->winner_team_id == $match->away_team_id)
                    <span class="game-result-team-label game-result-team-label-top">Win</span>
                @endif
            </div>

        </div>
        @if($match->is_started)
            <div class="table-game-info-wrap mt-2">
                <span class="table-game-info-title">Game statistics<span></span></span>
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
        @endif
    </div>
</article>
