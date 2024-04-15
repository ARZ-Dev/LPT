<div>
    <div class="card" wire:ignore>
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">{{ $tournament->name }} Categories List</h4>
            <a href="{{ route('tournaments') }}" class="btn btn-primary mb-2 text-nowrap">
                Tournaments
            </a>
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
                        <th>Status</th>
                        <th>Winner Team</th>
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
                            <span class="badge bg-label-{{ $category->is_completed ? "success" : "warning" }}">
                                {{ $category->is_completed ? "Completed" : "Pending" }}
                            </span>
                        </td>
                        <td>{{ $category->winnerTeam?->nickname }}</td>
                        <td>
                            @if(count($category->knockoutsMatches) || count($category->groupStageMatches))
                                <a href="{{ route('matches', $category->id) }}" class="text-body" data-bs-toggle="tooltip" data-bs-placement="top" title="Matches">
                                    <i class="ti ti-crown ti-sm me-2"></i>
                                </a>
                            @endif
                            @if(
                                (
                                    ($category->has_group_stage && !$category->is_group_matches_generated) ||
                                    (!$category->has_group_stage && !$category->is_knockout_matches_generated) ||
                                    ($category->has_group_stage && $category->is_group_stages_completed && !$category->is_knockout_matches_generated)
                                )
                                    && $category->number_of_teams > 0
                            )
                                <a href="#" class="text-body edit-tournament-button generate-matches" data-id="{{ $category->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Matches">
                                    <i class="ti ti-layout-grid-add ti-sm me-2"></i>
                                </a>
                            @endif
                            @if(!$category->is_group_matches_generated && !$category->is_knockout_matches_generated)
                                <a href="{{ route('tournaments-categories.edit', [$category->tournament_id, $category->id]) }}" class="text-body edit-tournament-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $category->id }}"><i class="ti ti-trash ti-sm me-2 text-danger"></i></a>
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
        $(document).on('click', '.generate-matches', function() {
            let categoryId = $(this).data('id');
            $wire.dispatch('generateMatches', {
                categoryId
            })
        })

        $(document).on('click', '.knockoutRound', function() {
            let id = $(this).data('id');
            $wire.dispatch('knockoutRound', {
                id
            })
        })

    </script>
    @endscript

</div>
