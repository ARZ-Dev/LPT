<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Teams List</h4>
            <div>
                <a class="btn btn-primary" href="{{ route('teams.rankings') }}">Rankings</a>
                @can('team-create')
                    <a class="btn btn-primary" href="{{ route('teams.create') }}">Add Team</a>
                @endcan
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-teams dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nickname</th>
                    <th>Level Category</th>
                    <th>Players</th>
                    <th>P / W / L</th>
                    <th>Rank</th>
                    <th>Points</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td>{{ $team->id }}</td>
                        <td>
                            <div class="d-flex justify-content-start align-items-center user-name">
                                <div class="avatar-wrapper">
                                    <div class="avatar me-2">
                                        @if($team->image)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($team->image) }}" alt="Avatar" class="rounded-circle">
                                        @else
                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ getInitials($team->nickname) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="emp_name text-truncate">{{ $team->nickname }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $team->levelCategory?->name }}</td>
                        <td>
                            @foreach($team->players as $player)
                                <span class='badge bg-label-warning m-1'>{{ $player->full_name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $team->matches }} / {{ $team->wins }} / {{ $team->losses }}</td>
                        <td>{{ $team->rank }}</td>
                        <td>{{ number_format($team->points) }}</td>
                        <td>
                            @can('team-view')
                                <a href="{{ route('teams.view', ['id' => $team->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('team-edit')
                                <a href="{{ route('teams.edit', $team->id) }}" class="text-body edit-team-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan
                            @can('team-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $team->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

