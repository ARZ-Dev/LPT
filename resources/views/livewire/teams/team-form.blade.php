<div>
    <div class="row">
        <div class="col-xl">
            <form class="row g-3">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Team</h5>
                        <a href="{{ route('teams') }}"
                           class="btn btn-primary mb-2 text-nowrap"
                        >
                            Teams
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="nickname">Nickname</label>
                                <input
                                    wire:model="nickname"
                                    type="text"
                                    id="nickname"
                                    name="nickname"
                                    class="form-control"
                                    placeholder="Nickname"
                                />
                                @error('nickname') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="levelCategoryId">Level Category *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="levelCategoryId"
                                        id="levelCategoryId"
                                        class="selectpicker w-100 @error('levelCategoryId') invalid-validation-select @enderror"
                                        title="Select Level Category"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-size="5"
                                        data-tick-icon="ti-check text-white" required>
                                        @foreach($levelCategories as $levelCategory)
                                            <option value="{{ $levelCategory->id }}" @selected($levelCategory->id == $levelCategoryId)>{{ $levelCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('levelCategoryId') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="playersIds">Players *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="playersIds"
                                        id="playersIds"
                                        class="selectpicker w-100 @error('playersIds') invalid-validation-select @enderror"
                                        title="Select Players"
                                        data-style="btn-default"
                                        multiple
                                        data-size="5"
                                        data-selected-text-format="count > 5"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-tick-icon="ti-check text-white" required>
                                        @foreach($players as $player)
                                            <option value="{{ $player->id }}" @selected(in_array($player->id, $playersIds))>{{ $player->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('playersIds') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                @if(!$status)
                    <div class="col-12 text-end mt-2">
                        <button wire:click="{{ $editing ? "update" : "store" }}" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    </div>
                @endif
            </form>

        </div>
    </div>

    <script>

        document.addEventListener('livewire:navigated', function () {

            $(document).ready(function () {


            });

            var status={{$status}};
            if (status=="1") {$('input').prop('disabled', true);}

        })

    </script>

</div>

