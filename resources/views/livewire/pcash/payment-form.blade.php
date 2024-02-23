<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Payment</h5>
                        <a href="{{ route('payment') }}"class="btn btn-primary mb-2 text-nowrap">
                        Payment
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="category_id">Categories</label>
                            <select wire:model="category_id" class="form-select selectpickerz w-100 " aria-label="Default select example" name="category_id" id="category_id">
                                <option>Open this select menu</option>
                                    @foreach($categories as $category)
                                        <option {{ $category->id == $category_id ? 'selected' : '' }} value='{{$category->id}}'>{{$category->category_name}}</option>
                                    @endforeach
                            </select>
                            @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                        <label class="form-label" for="sub_category_id">Sub Category</label>
                            <select wire:model="sub_category_id" class="form-select selectpickerz w-100 " aria-label="Default select example" name="sub_category_id" id="sub_category_id">
                                <option>Open this select menu</option>
                                    @foreach($subCategories as $subCategory)
                                        <option {{ $subCategory->id == $sub_category_id ? 'selected' : '' }} value='{{$subCategory->id}}'>{{$subCategory->sub_category_name}}</option>
                                    @endforeach
                            </select>
                            @error('sub_category_id') <div class="text-danger">{{ $message }}</div> @enderror
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

                        @foreach($paymentAmount as $key => $paymentAmount)

                       
                        <div wire:key="paymentAmount-{{ $key }}">
                            <div class="d-flex flex-row mt-3 mb-3">
                                <input class="form-control  cleave-input w-100 me-2" wire:model="paymentAmount.{{ $key }}.amount" type="text" name="paymentAmount[{{ $key }}][amount]" placeholder="amount" required>

                                <select class="form-select " aria-label="Default select example" wire:model="paymentAmount.{{ $key }}.currency_id">
                                    <option selected>Open this select menu</option>
                                    @foreach($currencies as $index => $currency)
                                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                                    @endforeach
                                </select>

                                @if($key !== 0)
                                <button type="button" class="btn btn-danger ms-2"  wire:click="removePaymentAmount({{ $key }})">Remove</button>
                                @endif
                            </div>
                        </div>
                        @error('paymentAmount.*.amount') <div class="text-danger">{{ $message }}</div> @enderror
                        @error('paymentAmount.*.currency_id') <div class="text-danger">{{ $message }}</div> @enderror


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
            
    //         Livewire.on('triggerCleave', function() {
                
    //             for(let field of $('.cleave-input').toArray()){
    //     new Cleave(field, {
    //         numeral: true,
    //         numeralThousandsGroupStyle: 'thousand'
    //     });
    // }
    //         })

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


