<div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Teams List</h4>
            <a class="btn btn-primary h-50" href="{{ route('teams.create') }}">Add Team</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-teams dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nickname</th>
                    <th>Level Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <td>{{ $team->id }}</td>
                        <td>{{ $team->nickname }}</td>
                        <td>{{ $team->levelCategory?->name }}</td>
                        <td>
                            @can('team-edit')
                                <a href="{{ route('teams.edit', $team->id) }}" class="text-body edit-team-button"><i class="ti ti-edit ti-sm me-2"></i></a>
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

