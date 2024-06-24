<div>
    <div class="row">
        <div class="col-xl">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Payment</h5>
                    <a href="{{ route('payment') }}" class="btn btn-primary mb-2 text-nowrap">
                    Payments
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mt-3">
                            <label class="form-label" for="till_id">Tills <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select wire:model="till_id" id="till_id" class="form-select selectpicker w-100" aria-label="Default select example" title="Select Till" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                    @foreach($tills as $till)
                                        <option value="{{ $till->id }}" @selected($till->id == $till_id)>{{ $till->name . " / " . $till->user?->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('till_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6 mt-3">
                            <label class="form-label" for="paid_to">Paid To <span class="text-danger">*</span></label>
                            <input
                                wire:model="paid_to"
                                type="text"
                                id="paid_to"
                                name="paid_to"
                                class="form-control"
                                placeholder="Paid To"/>

                            @error('paid_to') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6 mt-3">
                            <label class="form-label" for="category_id">Category <span class="text-danger">*</span></label>
                            <select wire:model="category_id" class="form-select selectpicker w-100" id="category_id" title="Select Category" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id == $category_id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6 mt-3 ">
                            <label class="form-label" for="sub_category_id">Sub Category <span class="text-danger">*</span></label>
                            <select wire:model="sub_category_id" class="form-select selectpicker w-100" id="sub_category_id" title="Select Sub Category" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @selected($subCategory->id == $sub_category_id)>{{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                            @error('sub_category_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-12 mt-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea
                                wire:model.defer="description"
                                type="text"
                                id="description"
                                name="description"
                                class="form-control"
                                placeholder="Description"
                            >
                            </textarea>
                            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>


                    <div class="col-12 col-md-12 mt-3">

                        @foreach($paymentAmounts as $key => $paymentAmount)

                            <div wire:key="paymentAmount-{{ $key }}">

                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-between">
                                        <label class="form-label mt-3 d-none d-md-block" for="amount-{{$key}}">
                                            Amount<span class="text-danger">*</span>
                                        </label>
                                        <span class="form-label mt-3 available-amounts" wire:ignore id="amount-available-{{ $key }}"></span>
                                    </div>
                                    <div class="col-5 d-none d-md-block">
                                        <label class="form-label mt-3" for="currency-{{$key}}">Currency <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-5 col-sm-12 sm-mb ">
                                        <input class="form-control  cleave-input w-100 me-2" id="amount{{$key}}" wire:model="paymentAmounts.{{ $key }}.amount" type="text" placeholder="Amount" required>
                                        @error('paymentAmounts.'. $key .'.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-12 col-md-5 col-sm-12 sm-mb ">
                                        <div wire:ignore>
                                            <select class="form-select selectpicker w-100 currency"
                                                aria-label="Default select example"
                                                id="currency{{$key}}"
                                                wire:model="paymentAmounts.{{ $key }}.currency_id"
                                                title="Select Currency"
                                                data-style="btn-default"
                                                data-live-search="true"
                                                data-icon-base="ti"
                                                data-tick-icon="ti-check text-white"
                                                data-key="{{ $key }}"
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
                                        <div class="col-12 col-md-2 col-sm-12 ">
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

            <div class="card mb-4 mt-2">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Invoice Upload
                        @if($this->invoice)
                            - <a href="{{ asset(\Illuminate\Support\Facades\Storage::url($this->invoice)) }}" download>Download Link</a>
                        @endif
                    </h5>
                    <h6>
                        @error('invoice')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            @php
                                $uploadedFile = $this->invoice ? asset(\Illuminate\Support\Facades\Storage::url($this->invoice)) : null;
                            @endphp
                            <x-filepond wire:model="invoice" delete-event="deleteInvoice" file-path="{{ $uploadedFile }}" is-multiple="false" />
                        </div>
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

    @script
    <script>

        triggerCleave()
        $('.selectpicker').selectpicker();

        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
            triggerCleave()
        })

        $(document).ready(function () {
            $('#till_id').change();
        })

        $(document).on('change', '.selectpicker', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })

        $(document).on('change', '#till_id', function() {
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

        $(document).on('change', '#category_id', function() {
            $wire.dispatch('getSubCategories')
        })

        $wire.on('refreshSubCategories', function (event) {
            let subCategories = event[0];
            let selectedSubCategoryId = event[1] ?? null;
            if (subCategories.length > 0) {
                let subCategorySelector = $('#sub_category_id');
                subCategorySelector.empty();
                Object.entries(subCategories).forEach(([key, value]) => {
                    let isSelected = value.id == selectedSubCategoryId ? "selected" : "";
                    subCategorySelector.append(`<option value="${value.id}" ${isSelected}>${value.name}</option>`)
                })
                subCategorySelector.selectpicker('refresh');
            }
        })

    </script>
    @endscript
</div>



