<div>

    <div class="col-xl-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link navs-pills-justified-home nav-btn {{ $lastNav == "home" ? "active" : "" }}"
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
                            class="nav-link navs-pills-justified-stages nav-btn {{ $lastNav == "stages" ? "active" : "" }}"
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
                            class="nav-link navs-pills-justified-matches nav-btn {{ $lastNav == "matches" ? "active" : "" }}"
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
                    <div class="tab-pane fade {{ $lastNav == "home" ? "show active" : "" }}" id="navs-pills-justified-home" role="tabpanel">
                        <form>

                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label">Start Date *</label>
                                    <input wire:model="start_date" id="start_date" type="text" value="{{ $start_date }}" class="form-control flatpickr-date" min="{{ $tournament->start_date }}" max="{{ $tournament->end_date }}" @disabled(!$canEditDetails)>
                                    @error('start_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label">End Date *</label>
                                    <input wire:model="end_date" id="end_date" type="text" value="{{ $end_date }}" class="form-control flatpickr-date" min="{{ $tournament->start_date }}" max="{{ $tournament->end_date }}" @disabled(!$canEditDetails)>
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
                                            data-tick-icon="ti-check text-white"
                                            required
                                            @disabled(!$canEditDetails)
                                        >
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
                                        <input wire:model.live="has_group_stages" @checked($has_group_stages ?? false) type="checkbox" class="switch-input" @disabled(!$canEditDetails)/>
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
                                    <input wire:model="nb_of_groups" id="nb-of-groups" type="number" class="form-control dt-input" placeholder="Number of Groups" @disabled(!$canEditDetails)>
                                    @error('nb_of_groups') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 {{ ($has_group_stages ?? false) ? "" : "d-none" }}">
                                    <label for="nb-of-teams" class="form-label">Number of Winners per Group:</label>
                                    <input wire:model="nb_of_winners_per_group" id="nb-of-winners" type="number" class="form-control dt-input" placeholder="Number of Winners per Group" @disabled(!$canEditDetails)>
                                    @error('nb_of_winners_per_group') <div class="text-danger">{{ $message }}</div> @enderror
                                    @error('knockout_teams') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>Teams @error('selectedTeamsIds') - <div class="text-danger">{{ $message }}</div> @enderror</h4>
                                    </div>
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
                                                            @if($canEditDetails)
                                                                <a wire:click="toggleTeam({{ $team->id }})" class="btn rounded-pill btn-{{ in_array($team->id, $selectedTeamsIds) ? "warning" : "success" }} text-nowrap text-white">
                                                                    {{ in_array($team->id, $selectedTeamsIds) ? "Remove" : "Select" }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <p class="card-text">Players: {{ implode(', ', $team->players->pluck('full_name')->toArray()) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <div class="alert alert-danger" role="alert">
                                                    No teams available / has paid yet.
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-end mt-4">
                                @if($canEditDetails)
                                    <button wire:click="update" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                @endif

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

                        </form>
                    </div>
                    <div class="tab-pane fade {{ $lastNav == "stages" ? "show active" : "" }}" id="navs-pills-justified-stages" role="tabpanel">

                        <form id="stagesForm">

                            @foreach($category->knockoutStages as $stage)
                                <div class="card mt-2 mb-2 shadow-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ $stage->name }}</h5>
                                        @if($stage->name == "Group Stages")
                                            <a class="btn btn-primary h-50" href="{{ route('group-stages.rankings', $stage->tournament_level_category_id) }}">Rankings</a>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-12 col-md-4">
                                                <label class="form-label" for="stage">Tournament Deuce Type</label>
                                                <div wire:ignore>
                                                    <select
                                                        wire:model="stagesDetails.{{ $stage->id }}.tournament_deuce_type_id"
                                                        id="tournament_deuce_type_id"
                                                        class="form-select selectpicker w-100 required"
                                                        aria-label="Default select example"
                                                        title="Select Deuce Type"
                                                        data-style="btn-default"
                                                        data-live-search="true"
                                                        data-icon-base="ti"
                                                        data-tick-icon="ti-check text-white"
                                                        @disabled($stage->is_completed)
                                                    >
                                                        @foreach($deuceTypes as $type)
                                                            <option value="{{ $type->id }}" @selected(($stagesDetails[$stage->id]['tournament_deuce_type_id'] ?? "") == $type->id)>{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('stagesDetails.' . $stage->id . '.tournament_deuce_type_id') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="form-label" for="stage">Nb of Sets to Win the Match</label>
                                                <input
                                                    wire:model="stagesDetails.{{ $stage->id }}.nb_of_sets"
                                                    type="number"
                                                    id="stage"
                                                    name="stage"
                                                    class="form-control number-input required"
                                                    @disabled($stage->is_completed)
                                                />
                                                @error('stagesDetails.' . $stage->id . '.nb_of_sets') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="form-label" for="stage">Nb of Games to Win the Set</label>
                                                <input
                                                    wire:model="stagesDetails.{{ $stage->id }}.nb_of_games"
                                                    type="number"
                                                    id="stage"
                                                    name="stage"
                                                    class="form-control number-input required"
                                                    @disabled($stage->is_completed)
                                                />
                                                @error('stagesDetails.' . $stage->id . '.nb_of_games') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <label class="form-label" for="stage">Tiebreak Points</label>
                                                <input
                                                    wire:model="stagesDetails.{{ $stage->id }}.tie_break"
                                                    type="number"
                                                    id="stage"
                                                    name="stage"
                                                    class="form-control number-input required"
                                                    @disabled($stage->is_completed)
                                                />
                                                @error('stagesDetails.' . $stage->id . '.tie_break') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-2">
                                                <label class="form-label" for="stage">Status</label>
                                                <span class="badge text-bg-{{ $stage->is_completed  == 0 ? "warning" : "info" }} form-control mt-2">
                                                    {{ $stage->is_completed == 0 ? "Pending" : "Completed" }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if(!$category->is_completed)
                                <div class="col-12 text-end mt-4">
                                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                </div>
                            @endif

                        </form>

                    </div>
                    <div class="tab-pane fade {{ $lastNav == "matches" ? "show active" : "" }}" id="navs-pills-justified-matches" role="tabpanel">
                        @foreach($category->knockoutStages as $stage)
                            @if($stage->name == "Group Stages")
                                @php($showSubmitButton = false)
                                @foreach($category->groups as $group)
                                    <div class="card mt-4 mb-4 bg-light">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">{{ $group->name }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row d-flex align-items-stretch">
                                                <div class="col-lg-6 col-sm-12 d-flex">
                                                    <div class="card m-2 flex-fill d-flex flex-column">
                                                        <div class="card-header d-flex justify-content-between align-items-center">
                                                            <h5 class="mb-0">Rankings</h5>
                                                        </div>
                                                        <div class="card-body flex-fill">
                                                            <div class="col-12">
                                                                <div class="table-responsive">
                                                                    <table class="dt-row-grouping table border table-bordered">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="text-center">Rank</th>
                                                                            <th class="text-center">Team</th>
                                                                            <th class="text-center">P/W/L</th>
                                                                            <th class="text-center">Score</th>
                                                                            <th class="text-center">Action</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($group->groupTeams as $groupTeam)
                                                                            @php($rowBg = "")
                                                                            @if($groupTeam->has_qualified)
                                                                                @php($rowBg = "bg-label-success")
                                                                            @elseif($group->qualification_status == "draw" && in_array($groupTeam->team_id, json_decode($group->drawn_teams_ids ?? [])))
                                                                                @php($rowBg = "bg-label-warning")
                                                                            @endif
                                                                            <tr class="{{ $rowBg }}">
                                                                                <td class="text-center">{{ $groupTeam->rank }}</td>
                                                                                <td class="text-center">{{ $groupTeam->team?->nickname }}</td>
                                                                                <td class="text-center">{{ $groupTeam->matches_played }}/{{ $groupTeam->wins }}/{{ $groupTeam->losses }}</td>
                                                                                <td class="text-center">{{ $groupTeam->score }}</td>
                                                                                <td class="text-center">
                                                                                    @if($group->qualification_status == "draw" && in_array($groupTeam->team_id, json_decode($group->drawn_teams_ids ?? [])))
                                                                                        @php($showSubmitButton = true)
                                                                                        <input wire:click="toggleQualifiedTeams({{ $group->id }}, {{ $groupTeam->team_id }})" type="checkbox" name="qualified-team-{{ $group->id }}" class="form-check-input">
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            @if($showSubmitButton)
                                                                <div class="row">
                                                                    <div class="col-8 mt-4">
                                                                        @error('qualifiedTeamsIds.' . $group->id) <div class="text-danger">{{ $message }}</div> @enderror
                                                                    </div>
                                                                    <div class="col-4 text-end mt-4">
                                                                        <button wire:click="qualifyDrawnTeams({{ $group->id }})" type="button" class="btn btn-primary me-sm-3 me-1">Qualify</button>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 d-flex">
                                                    <div class="card m-2 flex-fill d-flex flex-column">
                                                        <div class="card-header d-flex justify-content-between align-items-center">
                                                            <h5 class="mb-0">Court Details</h5>
                                                        </div>
                                                        <div class="card-body flex-fill">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label class="form-label" for="courtId">Court <span class="text-danger">*</span></label>
                                                                    <div wire:ignore>
                                                                        <select
                                                                            wire:model="courtsIds.{{ $group->id }}"
                                                                            wire:change="getCourtDetails({{ $group->id }}, $event.target.value)"
                                                                            class="form-select selectpicker w-100"
                                                                            aria-label="Default select example"
                                                                            title="Select Court"
                                                                            data-style="btn-default"
                                                                            data-live-search="true"
                                                                            data-icon-base="ti"
                                                                            data-tick-icon="ti-check text-white"
                                                                            required
                                                                            @disabled($group->is_completed)
                                                                        >
                                                                            @foreach($courts as $court)
                                                                                <option value="{{ $court->id }}" @selected($group->court_id == $court->id)>{{ $court->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    @error('courtsIds.' . $group->id) <div class="text-danger">{{ $message }}</div> @enderror
                                                                </div>
                                                                <div class="col-12 mt-4">
                                                                    <label class="form-label" for="courtId">Location</label>
                                                                    <input wire:model="courtsDetails.{{ $group->id }}" class="form-control" readonly disabled />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            @if(!$group->is_completed)
                                                                <div class="col-12 text-end mt-4">
                                                                    <button wire:click="storeGroupCourt({{ $group->id }})" type="button" class="btn btn-primary me-sm-3 me-1">Save</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @include('livewire.partials.matches-table', ['games' => $group->games, 'courts' => $courts, 'group' => $group, 'scorekeepers' => $scorekeepers])
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="card mt-4 mb-4 bg-light">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ $stage->name }}(s)</h5>
                                    </div>
                                    <div class="card-body">

                                        @include('livewire.partials.matches-table', ['games' => $stage->games, 'courts' => $courts, 'stage' => $stage, 'scorekeepers' => $scorekeepers])
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    @script
    <script>

        let lastPage = "navs-pills-justified-home";

        $(document).on('click', '.nav-btn', function () {
            lastPage = $(this).attr('aria-controls');
        })

        $(document).on('change', '.selectpicker', function() {
            $wire.set($(this).attr('wire:model'), $(this).val(), false)
        })

        $('#stagesForm').submit(function(event) {
            // Prevent the default form submission
            event.preventDefault();

            // Clear previous error messages
            $('.text-danger').remove();

            // Initialize a flag for tracking validation status
            let isValid = true;

            $('#stagesForm .required').each(function() {
                let input = $(this);
                let inputValue = input.val().trim();

                if (inputValue === '') {
                    if (input.attr('wire:model') !== undefined) {
                        if (input.hasClass('selectpicker')) {
                            input.next().after('<div class="text-danger">This field is required.</div>');
                        } else {
                            input.after('<div class="text-danger">This field is required.</div>');
                        }
                        isValid = false;
                    }
                }
            });

            if (isValid) {
                @this.storeStages();
            }

        });

        $(document).on('click', '.store-date-btn', function () {
            let matchId = $(this).data('match-id');
            let type = $(this).data('type');
            let date = $('#date-' + matchId).val();
            let courtId = $('#court-id-' + matchId).val();
            let scorekeeperId = $('#scorekeeper-' + matchId).val();
            if (date !== "" && date !== undefined && (courtId !== "" && courtId !== undefined || type === "Group Stages") && scorekeeperId !== "" && scorekeeperId !== undefined) {
                $wire.dispatch('storeDateTime', {
                    matchId
                })
                $('.date-modal').modal('hide');
            }
        })

        $(document).on('click', '.store-absent-btn', function () {
            let matchId = $(this).data('match-id');
            let absentTeamId = $('#absent-team-' + matchId).val()
            if (absentTeamId !== "" && absentTeamId !== undefined) {
                $wire.dispatch('storeAbsent', {
                    matchId
                })
                $('.absent-modal').modal('hide');
            }
        })

        $(document).ready(function () {

            $('#start_date').flatpickr({
                dateFormat: "Y-m-d",
                minDate: "{{ $tournament->start_date }}",
                maxDate: "{{ $tournament->end_date }}",
            })

            $('#end_date').flatpickr({
                dateFormat: "Y-m-d",
                minDate: "{{ $tournament->start_date }}",
                maxDate: "{{ $tournament->end_date }}",
            })

        })

    </script>
    @endscript
</div>
