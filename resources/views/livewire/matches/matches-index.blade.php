<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">{{ $category->tournament->name }} - {{ $category->levelCategory?->name }} - Matches</h4>
            <a class="btn btn-primary h-50" href="{{ route('tournaments-categories', $category->tournament_id) }}">{{ $category->tournament->name }} Categories</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-matches dataTable table border-top">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Group / Round</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Datetime</th>
                        <th>Started At / By</th>
                        <th>Winner Team</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                    <tr>
                        <td>{{ $match->id }}</td>
                        <td>{{ $match->type == "Knockouts" ? $match->knockoutRound?->name : $match->group?->name }}</td>

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
                            @if($match->is_started)
                                {{ Carbon\Carbon::parse($match->started_at)->format('d-m-Y H:i') }} / {{ $match->startedBy?->full_name }}
                            @endif
                        </td>
                        <td>{{ $match->winnerTeam?->nickname }}</td>

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

                            @can('matches-setDate')
                                @if(!$match->is_started)
                                <a href="#" class="text-body" data-bs-toggle="modal" data-bs-target="#dateTime{{$match->id}}">
                                    <i class="ti ti-calendar ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $match->datetime ? "Edit" : "Add" }} Date/Time"></i>
                                </a>
                                @endif
                            @endcan

                            @if(!$match->is_started && $match->datetime)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#absentTeam{{$match->id}}" class="text-body">
                                    <i class="ti ti-hand-stop ti-sm me-2"  data-bs-toggle="tooltip" data-bs-placement="top" title="Absence"></i>
                                </a>
                            @endif

                            @if($match->is_started)
                                <a href="{{ route('matches.details', [$match->id]) }}" class="text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Match Details"><i class="ti ti-ball-tennis ti-sm me-2"></i></a>
                            @endif

                        </td>
                    </tr>

                    @include('modals.matches-datetime', ['match' => $match])
                    @include('modals.matches-absent', ['match' => $match])

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
