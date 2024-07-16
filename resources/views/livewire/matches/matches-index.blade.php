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
                        <td>{{ $match->id }}</td>
                        <td>{{ getMatchTournament($match)->name }}</td>
                        <td>{{ getMatchTournamentCategory($match)->levelCategory?->name }}</td>
                        <td class="text-nowrap">{{ $match->type == "Knockouts" ? $match->knockoutRound?->name : $match->group?->name }}</td>
                        <td>
                            {{ $match->court?->name }}
                        </td>
                        <td>
                            @if($match->homeTeam)
                            {{ $match->homeTeam->nickname }}
                            @elseif($match->relatedHomeGame)
                            Winner of {{ $match->relatedHomeGame->knockoutRound?->name }}
                            @endif
                        </td>
                        <td>
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
                        <td>{{ $match->winnerTeam?->nickname }}</td>
                        <td>
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

                            @can('matches-scoring')
                                @if($match->homeTeam && $match->awayTeam && $match->datetime)
                                    <a href="{{ route('matches.scoring', ['matchId' => $match->id]) }}" class="text-body">
                                        @if($match->is_completed)
                                            <i class="ti ti-report ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Results"></i>
                                        @else
                                            <i class="ti ti-player-play ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Start Game"></i>
                                        @endif
                                    </a>
                                @endif
                            @endcan

                            @if($match->is_started && $match->status != 'forfeited')
                                <a href="{{ route('matches.details', [$match->id]) }}" class="text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Match Details"><i class="ti ti-ball-tennis ti-sm me-2"></i></a>
                            @endif

                        </td>
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
        $(document).on('click', '.submit-btn', function() {
            let matchId = $(this).data('match-id');
            let winnerId = $('#winner-' + matchId).val();
            let data = {
                matchId
                , winnerId
            };

            $wire.dispatch('chooseWinner', data)
        })

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
                $('.absent-modal').modal('hide');
            }
        })

    </script>
    @endscript

</div>
