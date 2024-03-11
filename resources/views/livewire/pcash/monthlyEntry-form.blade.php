<div>
    <div class="row">
        <div class="col-xl">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} MonthlyEntry</h5>
                    <a href="{{ route('monthlyEntry') }}"class="btn btn-primary mb-2 text-nowrap">
                    MonthlyEntry
                    </a>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-12 col-md-12 mt-3">
                            <label class="form-label" for="till_id">Tills <span class="text-danger">*</span></label>
                            <select wire:model="till_id"  class="form-select selectpicker w-100" aria-label="Default select example" title="Select Till" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required wire:change="getTillAmounts">
                                @foreach($tills as $till)
                                    <option value="{{ $till->id }}" @selected($till->id == $till_id)>{{ $till->name }}</option>
                                @endforeach
                            </select>
                            @error('till_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>


                    @if($this->editing == false)
                    <div class="col-12 col-md-12 mt-3">
                        <label class="form-label" for="open_date">open_date</label>
                        <input
                            wire:model.defer="open_date"
                            type="date"
                            id="open_date"
                            name="open_date"
                            class="form-control"
                            placeholder="open_date">
                        </input>
                        @error('open_date') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    @else
                        <div class="col-12 col-md-12 mt-3">
                            <label class="form-label" for="close_date">close_date</label>
                            <input
                                wire:model.defer="close_date"
                                type="date"
                                id="close_date"
                                name="close_date"
                                class="form-control"
                                placeholder="close_date">
                            </input>
                            @error('close_date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    @endif

                     <div class="col-12 col-md-12 mt-3">

                        @foreach($this->tillAmounts as $key => $tillAmount)
                            <div wire:key="tillAmount-{{ $key }}">

                                <div class="row">
                                    <div class="col-4">
                                        <label class="form-label mt-3" for="currency-{{$key}}">Currency {{ $key + 1 }} <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label mt-3" for="amount-{{$key}}">Amount {{ $key + 1 }} <span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <input class="form-control w-100 me-2" id="currency{{$key}}" type="text" value="{{$tillAmount->currency->name}}" readonly disabled>
                                    </div>
                                    <div class="col-4">
                                        <input class="form-control cleave-input me-2" id="amount{{$key}}" type="text" value="{{$tillAmount->amount}}" readonly disabled>
                                    </div>
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
            $wire.dispatch('getTillAmounts')
        })



    </script>
    @endscript
</div>



