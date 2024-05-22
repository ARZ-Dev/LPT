<div class="col-md-4 my-2">
    <div class="card bg-light rounded">
        <div class="card-header d-flex justify-content-between">
            <div>
                <span>Match #{{ $match->id }} - Status: {{ ucfirst($match->status) }}</span> <br>
                <span>{{ $match->type == "Knockouts" ? $match->knockoutRound->name : $match->group->name }} Round</span> <br>
                <span>Date: {{ $match->datetime ?? "N/A" }}</span>
            </div>
            <div>
                @if($match->datetime)
                    <a href="{{ route('matches.scoring', ['matchId' => $match->id]) }}" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light">
                        @if($match->is_started)
                            <span class="ti ti-report text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Results"></span>
                        @else
                            <span class="ti ti-player-play text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Start Game"></span>
                        @endif
                    </a>

                    @if(!$match->is_started)
                        <a href="#" data-bs-toggle="modal" data-bs-target="#absentTeam{{$match->id}}" class="btn rounded-pill btn-icon btn-warning waves-effect waves-light">
                            <span class="ti ti-hand-stop text-white"  data-bs-toggle="tooltip" data-bs-placement="top" title="Absence"></span>
                        </a>
                    @endif
                @else
                    @can('matches-setDate')
                        <a href="#" data-bs-toggle="modal" data-bs-target="#dateTime{{$match->id}}" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light">
                            <span class="ti ti-calendar text-white"  data-bs-toggle="tooltip" data-bs-placement="top" title="Set Date/Time"></span>
                        </a>
                    @endcan
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h5>
                        @if($match->homeTeam)
                            @if($match->is_completed)
                                <span class="badge rounded-pill bg-{{ $match->winner_team_id == $match->home_team_id ? "success" : "danger" }}">
                                    {{ $match->homeTeam->nickname }}
                                </span>
                            @else
                                {{ $match->homeTeam->nickname }}
                            @endif
                        @elseif($match->relatedHomeGame)
                            Winner of {{ $match->relatedHomeGame->knockoutRound?->name }}
                        @endif
                    </h5>
                </div>
                <div class="col-12 text-center">
                    <h4>VS</h4>
                </div>
                <div class="col-12 text-center">
                    <h5>
                        @if($match->awayTeam)
                            @if($match->is_completed)
                                <span class="badge rounded-pill bg-{{ $match->winner_team_id == $match->away_team_id ? "success" : "danger" }}">
                                    {{ $match->awayTeam->nickname }}
                                </span>
                            @else
                                {{ $match->awayTeam->nickname }}
                            @endif
                        @elseif($match->relatedAwayGame)
                            Winner of {{ $match->relatedAwayGame->knockoutRound?->name }}
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modals.matches-datetime', ['match' => $match])
@include('modals.matches-absent', ['match' => $match])

