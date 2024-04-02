<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Transfer</h5>
                        <a href="{{ route('transfer') }}" class="btn btn-primary mb-2 text-nowrap">
                            Transfers
                        </a>
                    </div>
                    <div class="card-body">
                        <form class="row g-3">

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="from_till_id">From Till <span class="text-danger">*</span></label>
                                <div wire:ignore>
                                    <select
                                        wire:model="from_till_id"
                                        id="from_till_id"
                                        class="form-select selectpicker w-100"
                                        name="from_till_id"
                                        title="Select From Till"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-tick-icon="ti-check text-white"
                                        required
                                    >
                                        @foreach($tills as $till)
                                            <option value="{{ $till->id }}" @selected($till->id == $from_till_id)>{{ $till->name . " / " . $till->user?->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('from_till_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="to_till_id">To Till <span class="text-danger">*</span></label>
                                <div wire:ignore>
                                    <select
                                        wire:model="to_till_id"
                                        id="to_till_id"
                                        class="form-select selectpicker w-100"
                                        name="to_till_id"
                                        title="Select To Till"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-tick-icon="ti-check text-white"
                                        required
                                    >
                                        @foreach($to_tills as $till)
                                            <option value="{{ $till->id }}" @selected($till->id == $to_till_id)>{{ $till->name . " / " . $till->user?->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('to_till_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-12">
                                <label class="form-label" for="description">Description</label>
                                <textarea
                                    wire:model="description"
                                    type="text"
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    placeholder="description"
                                ></textarea>
                                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>



                            <div class="col-12 col-md-12">
                                @foreach($transferAmounts as $key => $transferAmount)
                                    <div wire:key="transferAmount-{{ $key }}">

                                        <div class="row">
                                            <div class="col-5 d-flex justify-content-between">
                                                <label class="form-label mt-3" for="amount-{{$key}}">Amount <span class="text-danger">*</span></label>
                                                <span class="form-label mt-3 available-amounts" wire:ignore id="amount-available-{{ $key }}"></span>
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label mt-3" for="currency-{{$key}}">Currency <span class="text-danger">*</span></label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-5 col-md-5 col-sm-5">
                                                <input class="form-control cleave-input w-100 me-2 " wire:model="transferAmounts.{{ $key }}.amount" type="text" name="transferAmount[{{ $key }}][amount]" placeholder="Amount" id="amount-{{$key}}" required>
                                                @error('transferAmounts.'. $key .'.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>
                                            <div class="col-3 col-md-5 col-sm-3">
                                                <div wire:ignore>
                                                    <select
                                                        wire:model="transferAmounts.{{ $key }}.currency_id"
                                                        id="currency-{{$key}}" class="w-100 currency selectpicker"
                                                        title="Select Currency"
                                                        data-style="btn-default"
                                                        data-live-search="true"
                                                        data-icon-base="ti"
                                                        data-tick-icon="ti-check text-white"
                                                        data-key="{{ $key }}"
                                                        required
                                                    >
                                                        @foreach($currencies as $currency)
                                                            <option @if($status == 1) disabled @endif value="{{$currency->id}}"
                                                                @selected($transferAmount['currency_id'] == $currency->id)
                                                            >
                                                                {{ $currency->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('transferAmounts.'. $key .'.currency_id') <div class="text-danger">{{ $message }}</div> @enderror
                                            </div>

                                            @if(!$status)
                                                <div class="col-4 col-md-2 col-sm-4">
                                                    @if($key == 0)
                                                        <button type="button" class="btn btn-success ms-2" wire:click="addRow">Add Amount</button>
                                                    @endif
                                                    @if($key !== 0)
                                                        <button type="button" class="btn btn-danger ms-2" wire:click="removeRow({{ $key }})">Remove</button>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </form>
                    </div>
                </div>
        </div>
        @if(!$status)
        <div class="col-12 text-end mt-2">
            <button wire:click="{{ $editing ? "update" : "store" }}"  type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
        </div>
        @endif

    </div>

    @script
    <script>
        triggerCleave()
        $('.selectpicker').selectpicker();

        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
            triggerCleave()
        })

        $(document).on('change', '.selectpicker', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })

        $(document).ready(function () {
            $('#from_till_id').change();
        })

        $(document).on('change', '#from_till_id', function() {
            $wire.dispatch('getAvailableAmounts');
        })

        let availableAmounts = [];
        $wire.on('setAvailableAmounts', function (event) {
            availableAmounts = event[0];
            $('.currency').change();
        })

        $(document).on('change', '.currency', function() {
            if ($(this).val()) {
                let key = $(this).data('key');
                let availableAmountSelector = $('#amount-available-' + key);
                availableAmountSelector.text("");
                availableAmountSelector.removeClass("text-danger");

                if (availableAmounts[$(this).val()] !== undefined) {
                    availableAmountSelector.text("Available Amount: " + availableAmounts[$(this).val()])
                } else {
                    availableAmountSelector.addClass("text-danger")
                    availableAmountSelector.text("0.00");
                }
            }
        })
    </script>
    @endscript
</div>


