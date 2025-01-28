<div>
    <form>
        <div class="row g-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Sport Center</h5>
                    <a href="{{ route('sport-centers') }}"
                       class="btn btn-primary mb-2 text-nowrap"
                    >
                        Sport Centers
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
                            <label class="form-label" for="governorateId">Governorate *</label>
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
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="cityId">City *</label>
                            <div wire:ignore>
                                <select
                                    wire:model="cityId"
                                    id="cityId"
                                    class="selectpicker w-100 @error('cityId') invalid-validation-select @enderror"
                                    title="Select City"
                                    data-style="btn-default"
                                    data-live-search="true"
                                    data-icon-base="ti"
                                    data-size="5"
                                    data-tick-icon="ti-check text-white" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" @selected($city->id == $cityId)>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('cityId') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Courts
                    </h5>
                    <button type="button" wire:click="addCourt" class="btn btn-success">
                        Add Court
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @forelse($courts as $index => $court)
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-10">
                                    <label class="form-label" for="name">Court {{ $index + 1 }} *</label>
                                    <input
                                        wire:model="courts.{{ $index }}.name"
                                        type="text"
                                        id="name"
                                        name="name"
                                        class="form-control"
                                        placeholder="Name"
                                    />
                                    @error('courts.' . $index . '.name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-2">
                                    <br>
                                    <button type="button" wire:click="removeCourt({{ $index }})" class="btn btn-danger btn-icon rounded-pill">
                                        <span class="ti ti-x text-white"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                            <h6 class="text-center">No courts available.</h6>
                        @endforelse
                    </div>
                </div>
            </div>

            @if(!$status)
                <div class="col-12 text-end mt-2">
                    <button wire:click="store" type="button" class="btn btn-primary">Submit</button>
                </div>
            @endif
        </div>
    </form>

    @script
    <script>


        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
        })

        $(document).on('change', '.selectpicker', function() {
            $wire.set($(this).attr('wire:model'), $(this).val())
        })

        $(document).on('change', '#countryId', function() {
            $wire.dispatch('getGovernorates')
        })

        $wire.on('refreshGovernorates', function (event) {
            let governorates = event[0];
            let selectedGovernorateId = event[1] ?? null;
            let governorateSelector = $('#governorateId');

            let citySelector = $('#cityId');
            citySelector.selectpicker('destroy');
            citySelector.empty();
            citySelector.selectpicker('refresh');

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

        $(document).on('change', '#governorateId', function() {
            $wire.dispatch('getCities')
        })

        $wire.on('refreshCities', function (event) {
            let cities = event[0];
            let selectedCityId = event[1] ?? null;
            let citySelector = $('#cityId');
            citySelector.selectpicker('destroy');
            citySelector.empty();
            citySelector.selectpicker();
            if (cities.length > 0) {
                Object.entries(cities).forEach(([key, value]) => {
                    let isSelected = value.id == selectedCityId ? "selected" : "";
                    citySelector.append(`<option value="${value.id}" ${isSelected}>${value.name}</option>`)
                })
            }
            citySelector.selectpicker('refresh');
        })

    </script>
    @endscript
</div>

