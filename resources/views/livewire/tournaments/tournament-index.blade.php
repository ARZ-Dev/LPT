<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Tournaments List</h4>
            @can('tournament-create')
                <a class="btn btn-primary h-50" href="{{ route('tournaments.create') }}">Add Tournament</a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-tournaments dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tournaments as $tournament)
                    <tr>
                        <td>{{ $tournament->id }}</td>
                        <td>{{ $tournament->name }}</td>
                        <td>
                            @can('tournament-view')
                                <a href="{{ route('tournaments.view', ['id' => $tournament->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('tournament-edit')
                                <a href="{{ route('tournaments.edit', $tournament->id) }}" class="text-body edit-tournament-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan
                            @can('tournament-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $tournament->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

