<div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Teams List</h4>
            <a class="btn btn-primary h-50" href="{{ route('players.create') }}">Add Player</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-players dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Team</th>
                    <th>Birthdate</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($players as $player)
                    <tr>
                        <td>{{ $player->id }}</td>
                        <td>{{ $player->full_name }}</td>
                        <td>{{ $player->team?->nickname }}</td>
                        <td>{{ $player->birthdate }}</td>
                        <td>{{ $player->phone_number }}</td>
                        <td>
                            @can('player-edit')
                                <a href="{{ route('players.edit', $player->id) }}" class="text-body edit-player-button"><i class="ti ti-edit ti-sm me-2"></i></a>
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
