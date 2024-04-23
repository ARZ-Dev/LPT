<div>
    <div class="card" wire:ignore>
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">{{ $tournament->name }} Stages</h4>
            <a class="btn btn-primary h-50" href="{{ route('tournaments-categories', $tournament->id) }}">{{ $tournament->name }} Categories</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-matches dataTable table border-top">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tournament Deuce Type</th>
                        <th>Name</th>
                        <th>Nb Of Sets</th>
                        <th>Nb Of Games</th>
                        <th>Tie Break</th>

                        <th>Is Completed</th>
                        <th>Actions</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach($knockoutStages as $knockoutStage)
                    <tr>
                        <td>{{ $knockoutStage->id }}</td>
                        <td>{{ $knockoutStage->tournamentDeuceType?->name }}</td>
                        <td>{{ $knockoutStage->name }}</td>
                        <td>{{ $knockoutStage->nb_of_sets }}</td>
                        <td>{{ $knockoutStage->nb_of_games }}</td>
                        <td>{{ $knockoutStage->tie_break }}</td>

                        <td>
                            <span class="badge bg-label-{{ $knockoutStage->is_completed  == 0 ? "warning" : "info" }}">
                                {{ $knockoutStage->is_completed == 0 ? "Pending" : "Completed" }}
                            </span>

                        <td>
                            <a href="#" class="text-body view-user-button" data-bs-toggle="modal" data-bs-target="#actions{{$knockoutStage->id}}"><i class="ti ti-pencil ti-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Actions"></i></a>

                        </td>
                    </tr>

                    <div wire:ignore.self class="modal fade" id="actions{{$knockoutStage->id}}" tabindex="-1" aria-labelledby="userModalLabel{{$knockoutStage->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel{{$knockoutStage->id}}">
                                        {{ $knockoutStage->name }} Settings
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class=" modal-body">

                                    <div class="container">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label" for="tournament_deuce_type_id">Tournament Deuce Type *</label>
                                                <div wire:ignore>
                                                    <select wire:model="knockoutStageValues.{{ $knockoutStage->id }}.tournament_deuce_type_id" id="tournament_deuce_type_id" class="form-select selectpicker w-100" aria-label="Default select example" title="Select Deuce Type" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white">
                                                        @foreach($TournamentDeuceTypes as $type)
                                                        <option value="{{ $type->id }}" @selected(($knockoutStageValues[$knockoutStage->id]['tournament_deuce_type_id'] ?? "") == $type->id)>{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('knockoutStageValues.'.$knockoutStage->id.'.tournament_deuce_type_id') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label " for="nb_of_sets">Nb Of Sets to Win the Match *</label>
                                                <input type="text" wire:model="knockoutStageValues.{{ $knockoutStage->id }}.nb_of_sets" id="nb_of_sets" class="form-control form-control dt-input" oninput="this.value = Math.abs(parseInt(this.value)) || ''">
                                                @error('knockoutStageValues.'.$knockoutStage->id.'.nb_of_sets') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label " for="nb_of_games">Nb Of Games to Win the Set *</label>
                                                <input type="text" wire:model="knockoutStageValues.{{ $knockoutStage->id }}.nb_of_games" id="nb_of_games" class="form-control form-control dt-input" oninput="this.value = Math.abs(parseInt(this.value)) || ''">
                                                @error('knockoutStageValues.'.$knockoutStage->id.'.nb_of_games') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label " for="tie_break">Tie Break points to Win the Game *</label>
                                                <input type="text" wire:model="knockoutStageValues.{{ $knockoutStage->id }}.tie_break" id="tie_break" class="form-control form-control dt-input" oninput="this.value = Math.abs(parseInt(this.value)) || ''">
                                                @error('knockoutStageValues.'.$knockoutStage->id.'.tie_break') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button wire:click="submitSettings({{$knockoutStage->id }})" type="submit" data-match-id="{{ $knockoutStage->id }}" class="btn btn-primary ">Submit</button>
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
        $('.selectpicker').selectpicker();

        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
        })
    </script>
    @endscript

</div>
