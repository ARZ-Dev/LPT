<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Tournaments List</h4>
            @can('tournament-create')
            <a class="btn btn-primary h-50" href="{{ route('tournaments.create') }}">Create Tournament</a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-tournaments dataTable table border-top">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Categories</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tournaments as $tournament)
                    <tr>
                        <td>{{ $tournament->id }}</td>
                        <td>{{ $tournament->name }}</td>
                        <td>
                            @foreach($tournament->levelCategories as $tournamentCategory)
                                <span class="badge bg-label-success">
                                {{ $tournamentCategory->levelCategory?->name }}
                            </span>
                            @endforeach
                        </td>
                        <td>{{ $tournament->start_date }}</td>
                        <td>{{ $tournament->end_date }}</td>
                        <td>
                            <span class="badge bg-label-{{ $tournament->is_completed ? "info" : "warning" }}">
                                {{ $tournament->is_completed ? "Completed" : "Pending" }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('tournaments-categories', $tournament->id) }}" class="text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Categories">
                                <i class="ti ti-category ti-sm me-2"></i>
                            </a>
                            @can('tournament-view')
                            <a href="{{ route('tournaments.view', ['id' => $tournament->id, 'status' => \App\Utils\Constants::VIEW_STATUS]) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('tournament-edit')
                            <a href="{{ route('tournaments.edit', $tournament->id) }}" class="text-body edit-tournament-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan

                            @if(!$tournament->levelCategories?->firstWhere('is_group_matches_generated', true) && !$tournament->levelCategories?->firstWhere('is_knockout_matches_generated', true))
                                @can('tournament-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $tournament->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                                @endcan
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

    </script>
    @endscript

</div>
