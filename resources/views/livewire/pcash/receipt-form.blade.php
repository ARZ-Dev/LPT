<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Receipt</h5>
                        <a href="{{ route('receipt') }}"class="btn btn-primary mb-2 text-nowrap">
                        Receipt
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                    <div class="col-12 col-md-12">
                            <label class="form-label" for="paid_by">From Customer<span style="color: red;">*</span></label>
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
                            /></textarea>
                            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-12">
                            @foreach($receiptAmount as $key => $receiptAmount)
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
                          
                                        <input class="form-control cleave-input w-100 me-2 " wire:model="receiptAmount.{{ $key }}.amount" type="text" name="receiptAmount[{{ $key }}][amount]" placeholder="amount" required></div>

                                        <div class="col-5">
                                            <select class="form-select selectpicker " aria-label="Default select example" wire:model="receiptAmount.{{ $key }}.currency_id">
                                                <option @if($status == 1) disabled @endif  selected>Open this select menu*</option>
                                                @foreach($currencies as $index => $currency)
                                                    <option @if($status == 1) disabled @endif value="{{$currency->id}}">{{$currency->name}}</option>
                                                @endforeach
                                            </select>
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
                                @error('receiptAmount.'.$key.'.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                @error('receiptAmount.'.$key.'.currency_id') <div class="text-danger">{{ $message }}</div> @enderror
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
            if (status=="1") {
                $('input').prop('disabled', true);
                $('textarea').prop('disabled', true);

            }

        });
        
        
        triggerCleave()
        $('.selectpicker').selectpicker();

        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
            triggerCleave()
        })

        $(document).on('change', '.currency', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })
        </script>
    </div>
</div>


