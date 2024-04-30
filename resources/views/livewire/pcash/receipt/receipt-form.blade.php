<div>
    <style>

    </style>
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
                                wire:model="paid_by"
                                type="text"
                                id="paid_by"
                                name="paid_by"
                                class="form-control"
                                placeholder="From Customer"
                            />
                            @error('paid_by') <div class="text-danger">{{ $message }}</div> @enderror
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
                            <select wire:model="sub_category_id"  class="form-select selectpicker w-100" id="sub_category_id" title="Select Sub Category" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @selected($subCategory->id == $sub_category_id)>{{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                            @error('sub_category_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                      
                        
                        <div class="tournaments-teams col-12 col-md-6 mt-3 d-none" wire:ignore>
                            <label class="form-label" for="tournament_id">Tournaments<span class="text-danger"></span></label>
                            <select wire:model="tournament_id" class="form-select selectpicker w-100" id="tournament_id" title="Select Tournament" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                @foreach($tournaments as $tournament)
                                    <option value="{{ $tournament->id }}" @selected($tournament->id == $tournament_id)>{{ $tournament->name }}</option>
                                @endforeach
                            </select>
                            @error('tournament_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="tournaments-teams col-12 col-md-6 mt-3 d-none" wire:ignore>
                            <label class="form-label" for="team_id">Teams<span class="text-danger"></span></label>
                            <select wire:model="team_id" class="form-select selectpicker w-100" id="team_id" title="Select Team" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" @selected($team->id == $team_id)>{{ $team->nickname }}</option>
                                @endforeach
                            </select>
                            @error('team_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                      

                        <div class="col-12 col-md-12">
                            <label class="form-label" for="description">Description</label>
                            <textarea
                                wire:model="description"
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
                                    <div class="row ">
                                        <div class="col-5">
                                            <label class="form-label mt-3 d-none d-md-block " for="amount-{{$key}}">Amount <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-5">
                                            <label class="form-label mt-3 d-none d-md-block" for="currency-{{$key}}">Currency <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-5 col-sm-12 sm-mb">
                                            <input id="amount-{{$key}}" class="form-control cleave-input w-100 me-2" wire:model="receiptAmounts.{{ $key }}.amount" type="text" name="receiptAmount[{{ $key }}][amount]" placeholder="Amount" required>
                                            @error('receiptAmounts.'.$key.'.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-12 col-md-5 col-sm-12 sm-mb">
                                            <select wire:model="receiptAmounts.{{ $key }}.currency_id"
                                                aria-label="Default select example"
                                                id="currency-{{$key}}"
                                                class="w-100 currency selectpicker"
                                                title="Select Currency"
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
                                            <div class="col-12 col-md-2 col-sm-12 sm-mb">
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

        $(document).on('change', '#category_id', function() {
            $wire.dispatch('getSubCategories')
        })
        
        $(document).on('change', '#sub_category_id', function() {
            $wire.dispatch('getTournaments')

            if($('#sub_category_id option:selected').text() == "Team") {
                $('.tournaments-teams').removeClass('d-none');
            } else {
                $('.tournaments-teams').addClass('d-none');
            }
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


