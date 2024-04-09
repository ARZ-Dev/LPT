<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Matches List</h4>
            <a class="btn btn-primary h-50" href="{{ route('tournaments') }}">Tournaments</a>


        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-matches dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Knockout Round </th>
                    <th>Home Team</th>
                    <th>Away Team</th>
                    <th>Winner Team</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($matches as $match)
                    <tr>
                        <td>{{ $match->id }}</td>
                        <td>{{ $match->type }}</td>
                        <td>{{ $match->knockoutRound->name }}</td>
                        <td>{{ $match->homeTeam?->nickname }}</td>
                        <td>{{ $match->awayTeam?->nickname }}</td>
                        <td>{{ $match->winnerTeam?->nickname }}</td>

                        <td>
                            @can('matches-view')
                                <a href="{{ route('matches.view', ['id' => $match->id, 'status' => \App\Utils\Constants::VIEW_STATUS]) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan

                            @if($match->homeTeam && $match->awayTeam && !$match->is_completed)
                                <a href="#" class="text-body view-user-button" data-bs-toggle="modal" data-bs-target="#userModal{{$match->id}}"><i class="ti ti-wand ti-sm me-2"></i></a>
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
                                            <button type="submit" data-match-id="{{ $match->id }}" class="btn btn-success submit-btn">Submit</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        $(document).on('click', '.submit-btn', function () {
            let matchId = $(this).data('match-id');
            let winnerId = $('#winner-' + matchId).val();
            let data = {
                matchId, winnerId
            };

            $wire.dispatch('chooseWinner', data)
        })
    </script>
    @endscript

</div>

