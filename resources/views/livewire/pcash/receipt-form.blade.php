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
                            <label class="form-label" for="paid_by">From Costumer</label>
                            <textarea
                            wire:model.defer="paid_by"
                            type="text"
                            id="paid_by"
                            name="paid_by"
                            class="form-control"
                            placeholder="From Costumer"
                            /></textarea>
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
                        <button type="button" class="btn btn-success mt-4 " wire:click="addRow">Add Amount</button>

                        @foreach($receiptAmount as $key => $receiptAmount)

                       
                        <div wire:key="receiptAmount-{{ $key }}">
                            <div class="d-flex flex-row mt-3 mb-3">
                                <input class="form-control cleave-input w-100 me-2 " wire:model="receiptAmount.{{ $key }}.amount" type="text" name="receiptAmount[{{ $key }}][amount]" placeholder="amount" required>

                                <select class="form-select " aria-label="Default select example" wire:model="receiptAmount.{{ $key }}.currency_id">
                                    <option selected>Open this select menu</option>
                                    @foreach($currencies as $index => $currency)
                                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                                    @endforeach
                                </select>

                                @if($key !== 0)
                                <button type="button" class="btn btn-danger ms-2"  wire:click="removeReceiptAmount({{ $key }})">Remove</button>
                                @endif
                            </div>
                        </div>
                        @error('receiptAmount.*.amount') <div class="text-danger">{{ $message }}</div> @enderror
                        @error('receiptAmount.*.currency_id') <div class="text-danger">{{ $message }}</div> @enderror


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
            triggerCleave();

        });

        function submit(action)
        {
            window.livewire.emit(action)
        }




    document.getElementById('category_id').addEventListener('change', function (e) {
        @this.set('category_id', e.target.value);
    });
                 
        </script>
    </div>
</div>


