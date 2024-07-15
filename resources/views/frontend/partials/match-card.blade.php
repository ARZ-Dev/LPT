<article class="game-result hoverable-div matches" data-match-id="{{ $match->id }}">
    <a href="{{ route('frontend.matches.view', $match->id) }}">
        @php($time = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('H:i') : "N/A")
        @php($day = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('D j') : "N/A")
        @php($month = $match->datetime ? \Carbon\Carbon::parse($match->datetime)->format('M Y') : "N/A")

        <div class="game-info game-info-classic">
            <div class="d-flex justify-content-between">
                <div></div>
                <div>
                    <p class="game-info-subtitle">
                        {{ $day }}, {{ $month }} at {{ $time }}, in {{ getMatchCourt($match)?->name }}
                    </p>
                    <h3 class="game-info-title">
                        {{ getMatchTournament($match)->name }} - {{ getMatchCategory($match)->name }} - {{ getMatchRound($match) }}
                    </h3>
                </div>
                <div class="me-4">
                    @if($match->is_started && !$match->is_completed)
                        <div class="spinner-grow text-red" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="game-info-main">
                <div class="game-info-team game-info-team-first">
                    <figure>
                        <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($match->homeTeam?->image)) }}" alt=""/>
                    </figure>
                    <div class="game-result-team-name">
                        @if($match->homeTeam)
                            {{ $match->homeTeam->nickname }}
                        @elseif($match->relatedHomeGame)
                            Winner of {{ $match->relatedHomeGame->knockoutRound?->name }}
                        @endif
                    </div>
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
                    <figure>
                        <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($match->awayTeam?->image)) }}" alt=""/>
                    </figure>
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
            <!-- Table Game Info-->
            @if($match->is_started && $match->is_completed)
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
            @elseif($match->is_started && !$match->is_completed)
                <div class="row d-flex justify-content-center mt-4" id="match-score-container-{{ $match->id }}">
                    @include('frontend.partials.match-score-board', ['match' => $match])
                </div>
            @endif
        </div>
    </a>
</article>
