@if ($match->type == "Knockouts")
    @php($stage = $match->knockoutRound?->knockoutStage)
@else
    @php($stage = $match->group?->knockoutStage)
@endif

@php($nbOfSetsToWin = $stage->nb_of_sets)
@php($nbOfGamesToWin = $stage->nb_of_games)
@php($tiebreakPointsToWin = $stage->tie_break)
@php($deuceType = $stage->tournamentDeuceType)

<div class="col-lg-5 col-sm-12">
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
                @foreach($match?->sets ?? [] as $set)
                    <td class="border">
                        {{ $set->home_team_score }}
                        @if($set->is_completed && ($set->home_team_score == $nbOfGamesToWin + 1 && $set->away_team_score == $nbOfGamesToWin) || ($set->home_team_score == $nbOfGamesToWin && $set->away_team_score == $nbOfGamesToWin + 1))
                            <sup>
                                @php($homeTeamScoreDetails = $set->setGames()->latest()->first()->points()->latest()->first())
                                @if($homeTeamScoreDetails->home_team_score == "won")
                                    @php($beforeLastDetails = $set->setGames()->latest()->first()->points()->where('point_number', $homeTeamScoreDetails->point_number - 1)->first())
                                    {{ $beforeLastDetails->home_team_score + 1 }}
                                @else
                                    {{ $homeTeamScoreDetails->home_team_score }}
                                @endif
                            </sup>
                        @endif
                    </td>
                    @if(!$set->is_completed)
                        <td class="border">{{ $set->setGames()->where('is_completed', false)->first()?->home_team_score ?? 0 }}</td>
                    @endif
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
                @foreach($match?->sets ?? [] as $set)
                    <td class="border">
                        {{ $set->away_team_score }}
                        @if($set->is_completed && ($set->home_team_score == $nbOfGamesToWin + 1 && $set->away_team_score == $nbOfGamesToWin) || ($set->home_team_score == $nbOfGamesToWin && $set->away_team_score == $nbOfGamesToWin + 1))
                            <sup>
                                @php($awayTeamScoreDetails = $set->setGames()->latest()->first()->points()->latest()->first())
                                @if($awayTeamScoreDetails->away_team_score == "won")
                                    @php($beforeLastDetails = $set->setGames()->latest()->first()->points()->where('point_number', $awayTeamScoreDetails->point_number - 1)->first())
                                    {{ $beforeLastDetails->away_team_score + 1 }}
                                @else
                                    {{ $awayTeamScoreDetails->away_team_score }}
                                @endif
                            </sup>
                        @endif
                    </td>
                    @if(!$set->is_completed)
                        <td class="border">{{ $set->setGames()->where('is_completed', false)->first()?->away_team_score ?? 0 }}</td>
                    @endif
                @endforeach
            </tr>
        </table>
    </div>
</div>
