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
                    <div class="row">
                        <div class="col-12 col-md-4 mt-3">
                            <label class="form-label" for="till_id">Tills<span class="text-danger">*</span></label>
                            <select wire:model="till_id"  class="form-select selectpicker w-100" aria-label="Default select example" title="Select User" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                @foreach($tills as $till)
                                    <option {{ $till->id == $till_id ? 'selected' : '' }} value='{{ $till->id }}'>{{ $till->name }}</option>
                                @endforeach
                            </select>
                            @error('till_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>


                        <div class="col-12 col-md-4 mt-3">
                            <label class="form-label" for="category_id">Categories<span class="text-danger">*</span></label>
                            <select wire:model="category_id" wire:change="updateSubCategories" class="form-select selectpickerz w-100" aria-label="Default select example" title="Select User" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                <option>Open this select menu</option>
                                @foreach($categories as $category)
                                    <option {{ $category->id == $category_id ? 'selected' : '' }} value='{{ $category->id }}'>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>


                        <div class="col-12 col-md-4 mt-3 ">
                            <label class="form-label" for="sub_category_id">Sub Category<span class="text-danger">*</span></label>
                            <select wire:model="sub_category_id" class="form-select selectpickerz w-100" aria-label="Default select example" id="sub_category_id">
                                <option>Open this select menu</option>
                                @foreach($subCategories as $subCategory)
                                    <option {{ $subCategory->id == $sub_category_id ? 'selected' : '' }} value='{{ $subCategory->id }}'>{{ $subCategory->sub_category_name }}</option>
                                @endforeach
                            </select>
                            @error('sub_category_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-12 mt-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea
                            wire:model.defer="description"
                            type="text"
                            id="description"
                            name="description"
                            class="form-control"
                            placeholder="description">
                        </textarea>
                        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 col-md-12 mt-3">

                        @foreach($paymentAmounts as $key => $paymentAmount)

                            <div wire:key="paymentAmount-{{ $key }}">

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
                                        <input class="form-control  cleave-input w-100 me-2" id="amount{{$key}}" wire:model="paymentAmounts.{{ $key }}.amount" type="text" placeholder="amount" required>
                                        @error('paymentAmounts.'. $key .'.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-5">
                                        <div wire:ignore>
                                            <select class="form-select selectpicker w-100 currency"
                                                aria-label="Default select example"
                                                id="currency{{$key}}"
                                                wire:model="paymentAmounts.{{ $key }}.currency_id"
                                                title="Select Currency {{ $key + 1 }}"
                                                data-style="btn-default"
                                                data-live-search="true"
                                                data-icon-base="ti"
                                                data-tick-icon="ti-check text-white"
                                                required
                                            >
                                                @foreach($currencies as $index => $currency)
                                                    <option @if($status == 1) disabled @endif value="{{$currency->id}}" @selected($paymentAmount['currency_id'] == $currency->id)>
                                                        {{$currency->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('paymentAmounts.'. $key .'.currency_id') <div class="text-danger">{{ $message }}</div> @enderror
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
                </div>

            </div>
            @if(!$status)
            <div class="col-12 text-end mt-3">
                <button wire:click="{{ $editing ? "update" : "store" }}"  type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
            </div>
            @endif

        </div>
    </div>
</div>

@script
    <script>
        document.addEventListener('livewire:navigated', function () {
            var status="{{$status}}";
            if (status=="1") {
                $('input').prop('disabled', true);
                $('option').prop('disabled', true);
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
@endscript


