<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Receipt</h5>
                        <a href="{{ route('receipt') }}" class="btn btn-primary mb-2 text-nowrap">
                        Receipt
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="till_id">Tills<span class="text-danger">*</span></label>
                            <select wire:model="till_id"  class="form-select selectpicker w-100" aria-label="Default select example" name="till_id" title="Select Till" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                @foreach($tills as $till)
                                    <option value="{{ $till->id }}" @selected($till->id == $till_id)>{{ $till->name . " / " . $till->user?->full_name }}</option>
                                @endforeach
                            </select>
                            @error('till_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="paid_by">From Customer<span class="text-danger">*</span></label>
                            <input
                                wire:model.defer="paid_by"
                                type="text"
                                id="paid_by"
                                name="paid_by"
                                class="form-control"
                                placeholder="From Customer"
                            />
                            @error('paid_by') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="description">Description</label>
                            <textarea
                                wire:model.defer="description"
                                type="text"
                                id="description"
                                name="description"
                                class="form-control"
                                placeholder="description"
                            ></textarea>
                            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-12">
                            @foreach($receiptAmounts as $key => $receiptAmount)
                                <div wire:key="receiptAmount-{{ $key }}">
                                    <div class="row">
                                        <div class="col-5">
                                            <label class="form-label mt-3" for="amount-{{$key}}">Amount {{ $key + 1 }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-5">
                                            <label class="form-label mt-3" for="currency-{{$key}}">Currency {{ $key + 1 }} <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <input id="amount-{{$key}}" class="form-control cleave-input w-100 me-2" wire:model="receiptAmounts.{{ $key }}.amount" type="text" name="receiptAmount[{{ $key }}][amount]" placeholder="amount" required>
                                            @error('receiptAmounts.'.$key.'.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-5">
                                            <select wire:model="receiptAmounts.{{ $key }}.currency_id"
                                                aria-label="Default select example"
                                                id="currency-{{$key}}"
                                                class="w-100 currency selectpicker"
                                                title="Select Currency {{ $key + 1 }}"
                                                data-style="btn-default"
                                                data-live-search="true"
                                                data-icon-base="ti"
                                                data-tick-icon="ti-check text-white"
                                                required
                                            >
                                                @foreach($currencies as $index => $currency)
                                                    <option value="{{$currency->id}}"
                                                        @selected($receiptAmount['currency_id'] == $currency->id)
                                                    >
                                                        {{$currency->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('receiptAmounts.'.$key.'.currency_id') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        @if(!$status)
                                            <div class="col-2">
                                                @if($key == 0)
                                                    <button type="button" class="btn btn-success ms-2" wire:click="addRow">Add Amount</button>
                                                @else
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

            @if(!$status)
            <div class="col-12 text-end mt-2">
                <button wire:click="{{ $editing ? "update" : "store" }}"  type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
            </div>
            @endif
        </div>
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
    </script>
    @endscript
</div>


