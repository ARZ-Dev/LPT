<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Players List</h4>
            @can('player-create')
                <a class="btn btn-primary h-50" href="{{ route('players.create') }}">Add Player</a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-players dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Current Team</th>
                    <th>Teams</th>
                    <th>Birthdate</th>
                    <th>Phone Number</th>
                    <th>Points</th>
                    <th>Rank</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($players as $player)
                    <tr>
                        <td>{{ $player->id }}</td>
                        <td>{{ $player->full_name }}</td>
                        <td>{{ ucfirst($player->gender) }}</td>
                        <td>{{ $player->currentTeam?->nickname }}</td>
                        <td>
                            @foreach($player->teams as $team)
                                <span class='badge bg-label-warning m-1'>{{ $team->nickname }}</span>
                            @endforeach
                        </td>
                        <td>{{ $player->birthdate }}</td>
                        <td>{{ $player->phone_number }}</td>
                        <td>{{ $player->points }}</td>
                        <td>{{ $player->rank }}</td>
                        <td>
                            @can('player-view')
                                <a href="{{ route('players.view', ['id' => $player->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('player-edit')
                                <a href="{{ route('players.edit', $player->id) }}" class="text-body edit-player-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan
                            @can('player-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $player->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                            @endcan
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


</div>

