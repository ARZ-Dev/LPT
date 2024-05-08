<div>
    <form>

        <div class="col-xl-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link active"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-home"
                            aria-controls="navs-pills-justified-home"
                            aria-selected="true">
                            <i class="tf-icons ti ti-home ti-xs me-1"></i>
                            {{ $category->levelCategory?->name }} Details
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-stages"
                            aria-controls="navs-pills-justified-stages"
                            aria-selected="false"
                            @disabled(!count($category->knockoutStages))
                        >
                            <i class="tf-icons ti ti-settings ti-xs me-1"></i>
                            Stages Settings
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-map"
                            aria-controls="navs-pills-justified-map"
                            aria-selected="false"
                            @disabled(!$category->is_knockout_matches_generated)
                        >
                            <i class="tf-icons ti ti-tournament ti-xs me-1"></i>
                            Knockout Map
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#navs-pills-justified-matches"
                            aria-controls="navs-pills-justified-matches"
                            aria-selected="false"
                            @disabled(!count($category->knockoutsMatches) && !count($category->groupStageMatches))
                        >
                            <i class="tf-icons ti ti-list-numbers ti-xs me-1"></i>
                            Matches
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">

                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Start Date *</label>
                                <input wire:model="start_date" type="date" class="form-control" min="{{ $tournament->start_date }}" max="{{ $tournament->end_date }}">
                                @error('start_date') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">End Date *</label>
                                <input wire:model="end_date" type="date" class="form-control" min="{{ $tournament->start_date }}" max="{{ $tournament->end_date }}">
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
                                @error('knockout_teams') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="d-flex justify-content-end">
                                <div class="col-2 mb-2">
                                    <input wire:model.live="teams_filter_search" type="text" placeholder="Search..." class="form-control" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
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

                        <div class="col-12 text-end mt-4">
                            <button wire:click="update" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>

                            @if(
                                (
                                    ($category->has_group_stage && !$category->is_group_matches_generated) ||
                                    (!$category->has_group_stage && !$category->is_knockout_matches_generated) ||
                                    ($category->has_group_stage && $category->is_group_stages_completed && !$category->is_knockout_matches_generated)
                                )
                                    && $category->number_of_teams > 0
                            )
                                @can('tournamentCategory-generateMatches')
                                    <button wire:click="generateMatches({{ $category->id }})" type="button" class="btn btn-primary me-sm-3 me-1">
                                        Generate Matches
                                    </button>
                                @endcan
                            @endif
                        </div>

                    </div>
                    <div class="tab-pane fade" id="navs-pills-justified-stages" role="tabpanel">


                    </div>
                    <div class="tab-pane fade" id="navs-pills-justified-map" role="tabpanel">
                        <p>
                            Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                            cupcake gummi bears cake chocolate.
                        </p>
                        <p class="mb-0">
                            Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                            roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                            jelly-o tart brownie jelly.
                        </p>
                    </div>
                    <div class="tab-pane fade" id="navs-pills-justified-matches" role="tabpanel">
                        <p>
                            Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                            cupcake gummi bears cake chocolate.
                        </p>
                        <p class="mb-0">
                            Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                            roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                            jelly-o tart brownie jelly.
                        </p>
                    </div>
                </div>
            </div>
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
