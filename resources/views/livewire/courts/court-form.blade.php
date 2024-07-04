<div>
    <div class="row">
        <div class="col-xl">
            <form class="row g-3">
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Court</h5>
                        <a href="{{ route('tournaments') }}"
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
                                        wire:model.live="countryId"
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
                                @error('selectedCategoriesIds') <div class="text-danger">{{ $message }}</div> @enderror
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

    </script>
    @endscript
</div>

