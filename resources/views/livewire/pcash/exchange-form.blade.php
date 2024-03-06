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
                            <label class="form-label" for="from_currency_id">from<span style="color: red;">*</span></label>
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
                            <label class="form-label" for="to_currency_id">to<span style="color: red;">*</span></label>
                            <div wire:ignore>
                                <select wire:model="to_currency_id" wire:change="emptyAmountsFields()"  class="selectpicker w-100" title="Select To Currency" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white">
                                    @foreach($currencies as $currency)
                                        <option @if($status == 1) disabled @endif  {{ $currency->id == $to_currency_id ? 'selected' : '' }} value='{{ $currency->id }}'>{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('to_currency_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="amount">amount<span style="color: red;">*</span></label>
                            <input
                            wire:model="amount"
                            wire:change="calculateResult()"
                            type="text"
                            id="amount"
                            class="form-control cleave-input"
                            placeholder="amount"
                            />
                            @error('amount') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="rate">rate<span style="color: red;">*</span></label>
                            <input
                            wire:model="rate"
                            wire:change="calculateResult()"
                            type="text"
                            id="rate"
                            class="form-control cleave-input"
                            placeholder="rate"
                            />
                            @error('rate') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="rate">result<span style="color: red;">*</span></label>
                            <input
                            wire:model="result"
                            wire:change="calculateResult()"
                            type="text"
                            id="result"
                            class="form-control cleave-input"
                            placeholder="result"
                            
                            />
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="description">description<span style="color: red;"></span></label>
                            <textarea
                            wire:model="description"
                            type="text"
                            id="description"
                            class="form-control"
                            placeholder="description"
                            /></textarea>
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
        document.addEventListener('livewire:navigated', function () {
            var status={{$status}};
            if (status=="1") {
                $('input').prop('disabled', true);
                $('textarea').prop('disabled', true);

            }
        });

        triggerCleave()
        $('.selectpicker').selectpicker();

    </script>
    @endscript
    </div>
</div>


