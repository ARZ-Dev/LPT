<div>
    <div class="row">
        <div class="col-xl">
            <form class="row g-3">
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Tournament</h5>
                        <a href="{{ route('tournaments') }}"
                           class="btn btn-primary mb-2 text-nowrap"
                        >
                            Tournaments
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="name">Name *</label>
                                <input
                                    wire:model="name"
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Name"
                                />
                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="selectedCategoriesIds">Level Categories *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model.live="selectedCategoriesIds"
                                        id="selectedCategoriesIds"
                                        class="selectpicker w-100 @error('selectedCategoriesIds') invalid-validation-select @enderror"
                                        title="Select Level Categories"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-size="5"
                                        data-tick-icon="ti-check text-white" required multiple>
                                        @foreach($levelCategories as $levelCategory)
                                            <option value="{{ $levelCategory->id }}" @selected(in_array($levelCategory->id, $selectedCategoriesIds))>{{ $levelCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('selectedCategoriesIds') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Start Date *</label>
                                <input wire:model="startDate" type="date" class="form-control dt-input">
                                @error('startDate') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">End Date *</label>
                                <input wire:model="endDate" type="date" class="form-control dt-input">
                                @error('endDate') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                @error('categoriesInfo') <div class="text-danger">Please add the categories info.</div> @enderror

                @foreach($selectedCategoriesIds as $key => $categoryId)
                    <div class="card mb-2">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                {{ $levelCategories->firstWhere('id', $categoryId)?->name }}
                            </h5>
                            <a wire:click="removeCategory({{ $categoryId }})" href="#" data-category-id="{{ $categoryId }}"
                               class="btn btn-danger mb-2 text-nowrap remove-category-btn"
                            >
                                Remove
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="tournament-type-{{ $categoryId }}">Type *</label>
                                    <div wire:ignore>
                                        <select
                                            wire:model="categoriesInfo.{{ $categoryId }}.type_id"
                                            id="tournament-type-{{ $categoryId }}"
                                            class="selectpicker w-100 @error('levelCategoryId') invalid-validation-select @enderror"
                                            title="Select Type"
                                            data-style="btn-default"
                                            data-live-search="true"
                                            data-icon-base="ti"
                                            data-size="5"
                                            data-tick-icon="ti-check text-white" required>
                                            @foreach($tournamentTypes as $tournamentType)
                                                <option value="{{ $tournamentType->id }}" @selected(($categoriesInfo[$categoryId]['type_id'] ?? null) == $tournamentType->id)>{{ $tournamentType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('categoriesInfo.' . $categoryId . '.type_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label for="nb-of-teams-{{ $categoryId }}" class="form-label">Number of Teams:</label>
                                    <input wire:model="categoriesInfo.{{ $categoryId }}.nb_of_teams" id="nb-of-teams-{{ $categoryId }}" type="number" class="form-control dt-input" placeholder="Number of Teams" disabled readonly>
                                    @error('categoriesInfo.' . $categoryId . '.nb_of_teams') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-sm-12">
                                    <label for="nb-of-teams-{{ $categoryId }}" class="form-label">Teams:</label>
                                    <div class="row">
                                        @forelse($teams->where('level_category_id', $categoryId) as $team)
                                            <div class="col-md-3 mb-4">
                                                <div class="card bg-label-{{ in_array($team->id, $categoriesInfo[$categoryId]['teams'] ?? []) ? "linkedin" : "danger" }}">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <h5 class="card-title">{{ $team->nickname }}</h5>
                                                            <a wire:click="toggleTeam({{ $categoryId }}, {{ $team->id }})" class="btn rounded-pill btn-{{ in_array($team->id, $categoriesInfo[$categoryId]['teams'] ?? []) ? "warning" : "success" }} mb-2 text-nowrap text-white">
                                                                {{ in_array($team->id, $categoriesInfo[$categoryId]['teams'] ?? []) ? "Remove" : "Select" }}
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
                                <div class="col-12 col-sm-6 mt-4">
                                    <label class="switch switch-primary">
                                        <input wire:model="categoriesInfo.{{ $categoryId }}.has_group_stage" @checked($categoriesInfo[$categoryId]['has_group_stage'] ?? false) type="checkbox" class="switch-input" />
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
                            </div>
                        </div>

                    </div>
                @endforeach

                @if(!$status)
                    <div class="col-12 text-end mt-2">
                        <button wire:click="{{ $editing ? "update" : "store" }}" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    </div>
                @endif
            </form>

        </div>
    </div>

    @script
    <script>

        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
        })

        $(document).on('change', '.selectpicker', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })

        $(document).on('click', '.remove-category-btn', function () {
            const categoriesSelector = $('#selectedCategoriesIds')
            let selectedCategories = categoriesSelector.val();
            let removedCategoryId = $(this).data('category-id');
            selectedCategories = selectedCategories.filter(categoryId => categoryId != removedCategoryId);
            categoriesSelector.selectpicker('val', selectedCategories);
        })

    </script>
    @endscript
</div>

