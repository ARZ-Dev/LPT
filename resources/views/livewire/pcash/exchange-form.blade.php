<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Exchange</h5>
                        <a href="{{ route('exchange') }}"class="btn btn-primary mb-2 text-nowrap">
                        Exchange
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="till_id">Till <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select wire:model="till_id" class="form-select selectpicker w-100 " name="till_id" title="Select Till" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                    @foreach($tills as $till)
                                        <option value="{{$till->id}}" @selected($till->id == $till_id)>{{ $till->name . " / " . $till->user?->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('from_till_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="from_currency_id">From Currency <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select wire:model="from_currency_id" wire:change="emptyAmountsFields()"  class="selectpicker w-100" title="Select From Currency" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white">
                                    @foreach($currencies as $currency)
                                        <option @if($status == 1) disabled @endif  {{ $currency->id == $from_currency_id ? 'selected' : '' }} value='{{ $currency->id }}'>{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('from_currency_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="to_currency_id">To Currency <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select wire:model="to_currency_id" wire:change="emptyAmountsFields()" id="to_currency_id" class="selectpicker w-100" title="Select To Currency" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white">
                                    @foreach($currencies as $currency)
                                        <option @if($status == 1) disabled @endif  {{ $currency->id == $to_currency_id ? 'selected' : '' }} value='{{ $currency->id }}'>{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('to_currency_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="amount">Amount <span class="text-danger">*</span></label>
                            <input
                                wire:model="amount"
                                wire:keyup="calculateResult('amount')"
                                type="text"
                                id="amount"
                                class="form-control cleave-input"
                                placeholder="Amount"
                            />
                            @error('amount') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="rate">Rate <span class="text-danger">*</span></label>
                            <input
                                wire:model="rate"
                                wire:keyup="calculateResult('rate')"
                                type="text"
                                id="rate"
                                class="form-control cleave-input"
                                placeholder="Rate"
                            />
                            @error('rate') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="rate">Result <span class="text-danger">*</span></label>
                            <input
                                wire:model="result"
                                wire:keyup="calculateResult('result')"
                                type="text"
                                id="result"
                                class="form-control cleave-input"
                                placeholder="Result"
                            />
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="description">Description <span class="text-danger"></span></label>
                            <textarea
                                wire:model="description"
                                type="text"
                                id="description"
                                class="form-control"
                                placeholder="Description"
                            ></textarea>
                            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                    </form>
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

            Livewire.on('emptyToCurrencyId', function () {
                $('#to_currency_id').val("");
                $('[data-id="to_currency_id"]').find(".filter-option-inner-inner").text("Select To Currency");
            });

            triggerCleave();
            $('.selectpicker').selectpicker();

        </script>
        @endscript
    </div>
</div>


