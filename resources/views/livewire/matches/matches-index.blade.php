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
                        <th>Type</th>
                        <th>Group</th>
                        <th>Knockout Round</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Winner Team</th>
                        <th>Date/Time </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matches as $match)
                    <tr>
                        <td>{{ $match->id }}</td>
                        <td>{{ $match->type }}</td>
                        <td>{{ $match->group?->name }}</td>
                        <td>{{ $match->knockoutRound?->name }}</td>

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
                        <td>{{ $match->winnerTeam?->nickname }}</td>
                        <td>{{ $match?->datetime }}</td>

                        <td>
                            @can('matches-view')
                            {{-- <a href="{{ route('matches.view', ['id' => $match->id, 'status' => \App\Utils\Constants::VIEW_STATUS]) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>--}}
                            @endcan
                            @if($match->is_started)
                            <a href="{{ route('matches.details', [$match->id]) }}" class="text-body edit-tournament-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Match Details"><i class="ti ti-ball-tennis ti-sm me-2"></i></a>
                            @endif
                            @if($match->homeTeam && $match->awayTeam && !$match->is_completed)
                            <a href="{{ route('matches.scoring', ['matchId' => $match->id]) }}" class="text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Start Game"><i class="ti ti-player-play ti-sm me-2"></i></a>
                            @endif

                            @if($match->homeTeam && $match->awayTeam && !$match->is_completed)
                            <a href="#" class="text-body view-user-button" data-bs-toggle="modal" data-bs-target="#dateTime{{$match->id}}"><i class="ti ti-calendar ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Date/Time"></i></a>
{{--                            <a href="#" class="text-body view-user-button" data-bs-toggle="modal" data-bs-target="#userModal{{$match->id}}"><i class="ti ti-wand ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Choose Winner"></i></a>--}}
                            @endif

                            <div class="modal fade" id="userModal{{$match->id}}" tabindex="-1" aria-labelledby="userModalLabel{{$match->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="userModalLabel{{$match->id}}">Choose the winner:</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <select wire:model="winner_team_id" class="form-select" aria-label="Default select example" id="winner-{{ $match->id }}">
                                                <option value="" selected>Select winner</option>
                                                <option value="{{ $match->homeTeam?->id }}">{{ $match->homeTeam?->nickname }}</option>
                                                <option value="{{ $match->awayTeam?->id }}">{{ $match->awayTeam?->nickname }}</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" data-match-id="{{ $match->id }}" class="btn btn-primary submit-btn">Submit</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>

                    <!-- date/time -->
                    <div class="modal fade" id="dateTime{{$match->id}}" tabindex="-1" aria-labelledby="userModalLabel{{$match->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel{{$match->id}}">Choose Date/Time:</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input wire:model="datetimeModel" type="datetime-local" class="form-control dt-input">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" data-match-id="{{ $match->id }}" class="btn btn-primary storeDateTime-btn">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

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

        $(document).on('click', '.storeDateTime-btn', function() {
            let matchId = $(this).data('match-id');
            let datetime = $('#datetime-' + matchId).val();
            let data = {
                matchId
                , matchId
            };

            $wire.dispatch('storeDateTime', data)
        })

    </script>
    @endscript

</div>
