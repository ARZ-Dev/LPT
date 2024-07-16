<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">My Matches</h4>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-matches dataTable table border-top">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tournament</th>
                        <th>Category</th>
                        <th>Group / Round</th>
                        <th>Court</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Datetime</th>
                        <th>Scorekeeper</th>
                        <th>Winner Team</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                    <tr>
                        <td class="text-nowrap">{{ $match->id }}</td>
                        <td class="text-nowrap">{{ getMatchTournament($match)->name }}</td>
                        <td class="text-nowrap">{{ getMatchTournamentCategory($match)->levelCategory?->name }}</td>
                        <td class="text-nowrap">{{ $match->type == "Knockouts" ? $match->knockoutRound?->name : $match->group?->name }}</td>
                        <td class="text-nowrap">
                            {{ $match->court?->name }}
                        </td>
                        <td class="text-nowrap">
                            @if($match->homeTeam)
                            {{ $match->homeTeam->nickname }}
                            @elseif($match->relatedHomeGame)
                            Winner of {{ $match->relatedHomeGame->knockoutRound?->name }}
                            @endif
                        </td>
                        <td class="text-nowrap">
                            @if($match->awayTeam)
                            {{ $match->awayTeam->nickname }}
                            @elseif($match->relatedAwayGame)
                            Winner of {{ $match->relatedAwayGame->knockoutRound?->name }}
                            @endif
                        </td>
                        <td class="text-nowrap">{{ $match->datetime }}</td>
                        <td class="text-nowrap">
                            @if($match->scorekeeper_id)
                                {{ $match->scorekeeper?->full_name }}
                            @endif
                        </td>
                        <td class="text-nowrap">{{ $match->winnerTeam?->nickname }}</td>
                        <td class="text-nowrap">
                            @php($badgeLabel = "warning")
                            @if($match->status == "started")
                                @php($badgeLabel = "info")
                            @elseif($match->status == "completed")
                                @php($badgeLabel = "success")
                            @elseif($match->status == "forfeited")
                                @php($badgeLabel = "danger")
                            @endif
                            <span class="badge bg-label-{{ $badgeLabel }}">
                                {{ ucfirst($match->status) }}
                            </span>
                        </td>

                        <td class="text-nowrap">

                            @if($match->datetime)
                                @if($match->homeTeam && $match->awayTeam)
                                    @can('matches-scoring')
                                        <a href="{{ route('matches.scoring', ['matchId' => $match->id]) }}" class="text-body">
                                            @if($match->is_started)
                                                <i class="ti ti-report ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Results"></i>
                                            @else
                                                <i class="ti ti-player-play ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Start Game"></i>
                                            @endif
                                        </a>
                                    @endcan

                                    @if(!$match->is_started)
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#absentTeam{{$match->id}}" class="text-body">
                                            <i class="ti ti-hand-stop"  data-bs-toggle="tooltip" data-bs-placement="top" title="Absence"></i>
                                        </a>
                                    @endif
                                @endif
                            @else
                                    @can('matches-setDate')
{{--                                        <a href="#" class="text-body" data-bs-toggle="modal" data-bs-target="#dateTime{{$match->id}}">--}}
{{--                                            <i class="ti ti-calendar ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $match->datetime ? "Edit" : "Add" }} Date/Time"></i>--}}
{{--                                        </a>--}}
                                    @endcan
                            @endif

                            @if($match->is_started && $match->status != 'forfeited')
                                <a href="{{ route('matches.details', [$match->id]) }}" class="text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Match Details"><i class="ti ti-ball-tennis ti-sm me-2"></i></a>
                            @endif

                        </td>

                        @include('modals.matches-absent', ['match' => $match])
{{--                        @include('modals.matches-datetime', ['match' => $match, 'courts' => $courts])--}}
                    </tr>

                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @script
    @include('livewire.deleteConfirm')
    @endscript

    @script
    <script>

        $(document).on('click', '.store-date-btn', function() {
            let matchId = $(this).data('match-id');
            let data = {
                matchId
            };

            $wire.dispatch('storeDateTime', data)
        })

        $(document).on('click', '.store-absent-btn', function () {
            let matchId = $(this).data('match-id');
            let absentTeamId = $('#absent-team-' + matchId).val()
            if (absentTeamId !== "" && absentTeamId !== undefined) {
                $wire.dispatch('storeAbsent', {
                    matchId
                })
                $('.absent-modal').modal('hide');
            }
        })

    </script>
    @endscript

</div>
