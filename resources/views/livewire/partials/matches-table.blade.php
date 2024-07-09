<div class="card m-2">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Matches</h5>
    </div>
    <div class="card-body">
        <div class="col-12">
            <div class="table-responsive">
                <table class="dt-row-grouping table border table-striped table-bordered">
                    <thead>
                    <tr>
                        @if($stage->name != "Group Stages")
                        <th class="text-center">Round</th>
                        <th class="text-center">Court</th>
                        @endif
                        <th class="text-center">Home Team</th>
                        <th class="text-center">Away Team</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Started By</th>
                        <th class="text-center">Winner</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($games as $game)
                        <tr>
                            @if($stage->name != "Group Stages")
                            <td class="text-center text-nowrap">
                                {{ $game->knockoutRound?->name }}
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $game->court?->name }}
                            </td>
                            @endif
                            <td class="text-center text-nowrap">
                                @if($game->homeTeam)
                                    {{ $game->homeTeam->nickname }}
                                @elseif($game->relatedHomeGame)
                                    Winner of {{ $game->relatedHomeGame->knockoutRound?->name }}
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                @if($game->awayTeam)
                                    {{ $game->awayTeam->nickname }}
                                @elseif($game->relatedAwayGame)
                                    Winner of {{ $game->relatedAwayGame->knockoutRound?->name }}
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $game->datetime }}
                            </td>
                            <td class="text-center text-nowrap">
                                @if($game->is_started)
                                    {{ $game->startedBy?->full_name }}
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                {{ $game->winnerTeam?->nickname }}
                            </td>
                            <td class="text-center text-nowrap">
                                @php($badgeLabel = "warning")
                                @if($game->status == "started")
                                    @php($badgeLabel = "info")
                                @elseif($game->status == "completed")
                                    @php($badgeLabel = "success")
                                @elseif($game->status == "forfeited")
                                    @php($badgeLabel = "danger")
                                @endif
                                <span class="badge bg-label-{{ $badgeLabel }}">
                                                                                {{ ucfirst($game->status) }}
                                                                            </span>
                            </td>
                            <td class="text-center text-nowrap">
                                @if($game->datetime)
                                    @if($game->homeTeam && $game->awayTeam)
                                        <a href="{{ route('matches.scoring', ['matchId' => $game->id]) }}" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light btn-sm">
                                            @if($game->is_started)
                                                <span class="ti ti-report text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Results"></span>
                                            @else
                                                <span class="ti ti-player-play text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Start Game"></span>
                                            @endif
                                        </a>

                                        @if(!$game->is_started)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#absentTeam{{$game->id}}" class="btn rounded-pill btn-icon btn-warning waves-effect waves-light btn-sm">
                                                <span class="ti ti-hand-stop text-white"  data-bs-toggle="tooltip" data-bs-placement="top" title="Absence"></span>
                                            </a>
                                        @endif
                                    @endif
                                @else
                                    @can('matches-setDate')
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#dateTime{{$game->id}}" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light btn-sm">
                                            <span class="ti ti-calendar text-white"  data-bs-toggle="tooltip" data-bs-placement="top" title="Set Date/Time"></span>
                                        </a>
                                    @endcan
                                @endif
                            </td>
                        </tr>

                        @include('modals.matches-datetime', ['match' => $game, 'courts' => $courts])
                        @include('modals.matches-absent', ['match' => $game])
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
