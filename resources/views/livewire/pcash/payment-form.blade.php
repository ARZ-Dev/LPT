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
                        <label class="form-label" for="category_id">Categories<span style="color: red;">*</span></label>
                        <select wire:model="category_id" wire:change="updateSubCategories" class="form-select selectpickerz w-100" aria-label="Default select example" name="category_id" title="Select User" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                            <option>Open this select menu</option>
                            @foreach($categories as $category)
                                <option {{ $category->id == $category_id ? 'selected' : '' }} value='{{ $category->id }}'>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="sub_category_id">Sub Category<span style="color: red;">*</span></label>
                        <select wire:model="sub_category_id" class="form-select selectpickerz w-100" aria-label="Default select example" name="sub_category_id" id="sub_category_id">
                            <option>Open this select menu</option>
                            @foreach($subCategories as $subCategory)
                                <option {{ $subCategory->id == $sub_category_id ? 'selected' : '' }} value='{{ $subCategory->id }}'>{{ $subCategory->sub_category_name }}</option>
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
                           {{-- @if(!$status)
                                <button type="button" class="btn btn-success mt-4 " wire:click="addRow">Add Amount</button>
                            @endif --}}
                        @foreach($paymentAmount as $key => $paymentAmount)

                       
                        <div wire:key="paymentAmount-{{ $key }}">
                            <label class="mt-3" for="amount{{$key}}">amount<span style="color: red;">*</span></label>

                            <div class="d-flex flex-row mt-3 mb-3">
                                <input class="form-control  cleave-input w-100 me-2" wire:model="paymentAmount.{{ $key }}.amount" type="text" name="paymentAmount[{{ $key }}][amount]" placeholder="amount" required>

                                <select class="form-select " aria-label="Default select example" wire:model="paymentAmount.{{ $key }}.currency_id">
                                    <option selected>Open this select menu*</option>
                                    @foreach($currencies as $index => $currency)
                                        <option value="{{$currency->id}}">{{$currency->name}}</option>
                                    @endforeach
                                </select>

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
            if (status=="1") {
                $('input').prop('disabled', true);
                $('option').prop('disabled', true);
                $('textarea').prop('disabled', true);


            
            }
            triggerCleave();
        });

        function submit(action)
        {
            window.livewire.emit(action)
        }
     
        </script>
    </div>
</div>


