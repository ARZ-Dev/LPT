<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">{{ $tournament->name }} Categories List</h4>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-tournaments dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Nb of Teams</th>
                    <th>Group Stage</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tournamentCategories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->levelCategory?->name }}</td>
                        <td>{{ $category->type?->name }}</td>
                        <td>{{ $category->number_of_teams }}</td>
                        <td>
                            <span class="badge bg-label-{{ $category->has_group_stage ? "info" : "warning" }}">
                                {{ $category->has_group_stage ? "Yes" : "No" }}
                            </span>
                        </td>
                        <td>{{ $category->start_date }}</td>
                        <td>{{ $category->end_date }}</td>
                        <td>
                            <a href="{{ route('tournaments-categories.edit', [$category->tournament_id, $category->id]) }}" class="text-body edit-tournament-button"><i class="ti ti-edit ti-sm"></i></a>
                            <a href="#" class="text-body delete-record delete-button" data-id="{{ $category->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                            <a href="#" class="text-body edit-tournament-button knockoutRound" data-id="{{ $category->id }}"><i class="ti ti-vector ti-sm"></i></a>

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
        $(document).on('click', '.generate-matches', function () {
            let tournamentId = $(this).data('id');
            $wire.dispatch('generateMatches', { tournamentId })
        })

        $(document).on('click', '.knockoutRound', function () {
            let id = $(this).data('id');
            $wire.dispatch('knockoutRound', { id })
        })
    </script>
    @endscript

</div>

