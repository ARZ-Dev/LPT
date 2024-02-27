<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Transfer</h5>
                        <a href="{{ route('transfer') }}"class="btn btn-primary mb-2 text-nowrap">
                        Transfer
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                        <div class="col-12 col-md-6 ">
                        <label class="form-label" for="from_till_id">From Tills</label>
                            <select wire:model="from_till_id" class="form-select selectpickerz w-100 " aria-label="Default select example" name="from_till_id" id="from_till_id">
                                <option>Open this select menu</option>
                                    @foreach($fromTills as $fromTill)
                                        <option {{ $fromTill->id == $from_till_id ? 'selected' : '' }} value='{{$fromTill->id}}'>{{$fromTill->name}}</option>
                                    @endforeach
                            </select>
                            @error('from_till_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6 ">
                        <label class="form-label" for="to_till_id">From Tills</label>
                            <select wire:model="to_till_id" class="form-select selectpickerz w-100 " aria-label="Default select example" name="to_till_id" id="to_till_id">
                                <option>Open this select menu</option>
                                    @foreach($toTills as $toTill)
                                        <option {{ $toTill->id == $to_till_id ? 'selected' : '' }} value='{{$toTill->id}}'>{{$toTill->name}}</option>
                                    @endforeach
                            </select>
                            @error('to_till_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-12">
                            <button type="button" class="btn btn-success mt-4 " wire:click="addRow">Add Amount</button>

                            @foreach($transferAmount as $key => $transferAmount)
                            <div wire:key="transferAmount-{{ $key }}">
                                    <label class="mt-3" for="amount{{$key}}">amount<span style="color: red;">*</span></label>
                                    <div class="d-flex flex-row mt-3 mb-3">
                                        <input class="form-control cleave-input w-100 me-2 " wire:model="transferAmount.{{ $key }}.amount" type="text" name="transferAmount[{{ $key }}][amount]" placeholder="amount" id="amount{{$key}}" required>

                                        <select class="form-select " aria-label="Default select example" wire:model="transferAmount.{{ $key }}.currency_id" id="currency{{$key}}"wire:change="checkCurrencies($event.target.value)">
                                            <option selected>Open this select menu <span style="color: red;">*</span></option>
                                            @foreach($currencies as $index => $currency)
                                                <option value="{{$currency->id}}" {{in_array($currency->id, $selectedCurrencies) ? "hidden" : ""}}>{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                      
                                        @if($key !== 0)
                                        <button type="button" class="btn btn-danger ms-2"  wire:click="removeTransferAmount({{ $key }})">Remove</button>
                                        @endif
                                    </div>
                                </div>
                                @error('transferAmount.*.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                @error('transferAmount.*.currency_id') <div class="text-danger">{{ $message }}</div> @enderror
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

        <script>
            
            


            document.addEventListener('livewire:navigated', function () {
                var status={{$status}};
                if (status=="1") {$('input').prop('disabled', true);}
                triggerCleave()
            });

            function submit(action)
            {
                window.livewire.emit(action)
            }

        </script>
    </div>
</div>


