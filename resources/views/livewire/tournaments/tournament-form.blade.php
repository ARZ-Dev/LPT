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
                                <input wire:model="startDate" value="{{ $startDate }}" type="text" class="form-control flatpickr-date" placeholder="YYYY-MM-DD">
                                @error('startDate') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="form-label">End Date *</label>
                                <input wire:model="endDate" value="{{ $endDate }}" type="text" class="form-control flatpickr-date" placeholder="YYYY-MM-DD">
                                @error('endDate') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            @can('tournament-setSubscriptionFees')
                            <div class="col-12 col-sm-12 mt-3">
                                <label class="switch switch-primary">
                                    <input wire:model.live="is_free" @checked($is_free ?? false) type="checkbox" class="switch-input" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                          <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                          <i class="ti ti-x"></i>
                                        </span>
                                    </span>
                                    <span class="switch-label">Free of Charges?</span>
                                </label>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>

                @can('tournament-setSubscriptionFees')
                    @if(!$is_free)
                        @foreach($selectedCategoriesIds as $key => $categoryId)
                            <div class="card mt-2 mb-2">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">{{ $levelCategories->where('id', $categoryId)->first()->name }} Subscrition Fees</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        @foreach($currencies as $currency)
                                            <div class="col-12 col-md-4">
                                                <label class="form-label" for="subscription-fee-{{ $categoryId }}-{{ $currency->id }}">Subscription Fee in {{ $currency->name }} *</label>
                                                <input
                                                    wire:model="subscriptionFees.{{ $categoryId }}.{{ $currency->id }}"
                                                    wire:keyup.debounce.500ms="getExchangedFees({{ $categoryId }})"
                                                    type="text"
                                                    id="subscription-fee-{{ $categoryId }}-{{ $currency->id }}"
                                                    name="subscription-fee-{{ $categoryId }}-{{ $currency->id }}"
                                                    class="form-control cleave-input"
                                                    placeholder="Subscription Fee"
                                                    @disabled(!$currency->is_default)
                                                />
                                                @error('subscriptionFees.' . $categoryId . '.' . $currency->id) <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endcan


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

        triggerCleave()

        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
            triggerCleave()
        })

        $(document).on('change', '.selectpicker', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })

    </script>
    @endscript
</div>

