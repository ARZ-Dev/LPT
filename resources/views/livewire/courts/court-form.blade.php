<div>
    <div class="row">
        <div class="col-xl">
            <form class="row g-3">
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Court</h5>
                        <a href="{{ route('courts') }}"
                           class="btn btn-primary mb-2 text-nowrap"
                        >
                            Courts
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
                                <label class="form-label" for="countryId">Country *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="countryId"
                                        id="countryId"
                                        class="selectpicker w-100 @error('countryId') invalid-validation-select @enderror"
                                        title="Select Country"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-size="5"
                                        data-tick-icon="ti-check text-white" required>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" @selected($country->id == $countryId)>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('countryId') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="countryId">Governorate *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="governorateId"
                                        id="governorateId"
                                        class="selectpicker w-100 @error('governorateId') invalid-validation-select @enderror"
                                        title="Select Governorate"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-size="5"
                                        data-tick-icon="ti-check text-white" required>
                                        @foreach($governorates as $governorate)
                                            <option value="{{ $governorate->id }}" @selected($governorate->id == $governorateId)>{{ $governorate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('governorateId') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>


                @if(!$status)
                    <div class="col-12 text-end mt-2">
                        <button wire:click="store" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
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

        $(document).on('change', '#countryId', function() {
            $wire.dispatch('getGovernorates')
        })

        $wire.on('refreshGovernorates', function (event) {
            let governorates = event[0];
            let selectedGovernorateId = event[1] ?? null;
            let governorateSelector = $('#governorateId');
            governorateSelector.selectpicker('destroy');
            governorateSelector.empty();
            governorateSelector.selectpicker();
            if (governorates.length > 0) {
                Object.entries(governorates).forEach(([key, value]) => {
                    let isSelected = value.id == selectedGovernorateId ? "selected" : "";
                    governorateSelector.append(`<option value="${value.id}" ${isSelected}>${value.name}</option>`)
                })
            }
            governorateSelector.selectpicker('refresh');
        })

    </script>
    @endscript
</div>

