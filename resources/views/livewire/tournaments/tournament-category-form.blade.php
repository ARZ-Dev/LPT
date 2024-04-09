<div>
    <form>

        <div class="card mb-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    {{ $tournamentLevelCategory?->levelCategory?->name }} Info
                </h5>
                <div>
                    <a href="{{ route('tournaments-categories', $tournament->id) }}"
                       class="btn btn-primary mb-2 text-nowrap"
                    >
                        {{ $tournament->name }} Categories
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label">Start Date *</label>
                        <input wire:model="start_date" type="date" class="form-control dt-input">
                        @error('start_date') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label">End Date *</label>
                        <input wire:model="end_date" type="date" class="form-control dt-input">
                        @error('end_date') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="tournament-type">Type *</label>
                        <div wire:ignore>
                            <select
                                wire:model="type_id"
                                id="tournament-type"
                                class="selectpicker w-100"
                                title="Select Type"
                                data-style="btn-default"
                                data-live-search="true"
                                data-icon-base="ti"
                                data-size="5"
                                data-tick-icon="ti-check text-white" required>
                                @foreach($tournamentTypes as $tournamentType)
                                    <option value="{{ $tournamentType->id }}" @selected(($type_id ?? null) == $tournamentType->id)>{{ $tournamentType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('type_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="nb-of-teams" class="form-label">Number of Teams:</label>
                        <input wire:model="nb_of_teams" id="nb-of-teams" type="number" class="form-control dt-input" placeholder="Number of Teams" disabled readonly>
                        @error('nb_of_teams') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 col-sm-12 mt-4">
                        <label class="switch switch-primary">
                            <input wire:model.live="has_group_stages" @checked($has_group_stages ?? false) type="checkbox" class="switch-input" />
                            <span class="switch-toggle-slider">
                                <span class="switch-on">
                                  <i class="ti ti-check"></i>
                                </span>
                                <span class="switch-off">
                                  <i class="ti ti-x"></i>
                                </span>
                            </span>
                            <span class="switch-label">Has Group Stages?</span>
                        </label>
                    </div>
                    <div class="col-md-6 col-sm-12 {{ ($has_group_stages ?? false) ? "" : "d-none" }}">
                        <label for="nb-of-teams" class="form-label">Number of Groups:</label>
                        <input wire:model="nb_of_groups" id="nb-of-groups" type="number" class="form-control dt-input" placeholder="Number of Groups">
                        @error('nb_of_groups') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 col-sm-12 {{ ($has_group_stages ?? false) ? "" : "d-none" }}">
                        <label for="nb-of-teams" class="form-label">Number of Winners per Group:</label>
                        <input wire:model="nb_of_winners_per_group" id="nb-of-winners" type="number" class="form-control dt-input" placeholder="Number of Winners per Group">
                        @error('nb_of_winners_per_group') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 mb-2">
            <div class="card-header align-items-center">
                <h5 class="mb-0">
                    {{ $tournamentLevelCategory?->levelCategory?->name }} Teams
                </h5>
                @error('selectedTeamsIds') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-12 col-sm-12">
                        <div class="d-flex justify-content-end">
                            <div class="col-2 mb-2">
                                <input wire:model.live="teams_filter_search" type="text" placeholder="Search..." class="form-control" />
                            </div>
                        </div>
                        <div class="row overflow-auto h-px-400">
                            @forelse($teams as $team)
                                <div class="col-md-3 my-2">
                                    <div class="card bg-label-{{ in_array($team->id, $selectedTeamsIds) ? "linkedin" : "danger" }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="card-title">{{ $team->nickname }}</h5>
                                                <a wire:click="toggleTeam({{ $team->id }})" class="btn rounded-pill btn-{{ in_array($team->id, $selectedTeamsIds) ? "warning" : "success" }} text-nowrap text-white">
                                                    {{ in_array($team->id, $selectedTeamsIds) ? "Remove" : "Select" }}
                                                </a>
                                            </div>
                                            <p class="card-text">Players: {{ count($team->players) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <div class="alert alert-danger" role="alert">
                                        No teams available.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-end mt-4">
            <button wire:click="update" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
        </div>

    </form>

    @script
    <script>

        $(document).on('change', '.selectpicker', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })

    </script>
    @endscript
</div>
