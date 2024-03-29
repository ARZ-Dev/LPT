<div>
    <div class="row">
        <div class="col-xl">

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Close")) : "Open" }} Monthly Entry</h5>
                    <a href="{{ route('monthly-openings-closings') }}" class="btn btn-primary mb-2 text-nowrap">Monthly Openings/Closings</a>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-12 col-md-6 mt-3">
                            <label class="form-label" for="till_id">Till</label>
                            @if($editing)
                                <input class="form-control" id="till_id" type="text" value="{{ $selectedTill->name . " / " . $selectedTill->user?->full_name }}" disabled readonly />
                            @else
                                <select wire:model="till_id"  class="form-select selectpicker w-100" aria-label="Default select example" title="Select Till" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required wire:change="getTillAmounts">
                                    @foreach($tills as $till)
                                        <option value="{{ $till->id }}" @selected($till->id == $till_id)>{{ $till->name . " / " . $till->user?->full_name }}</option>
                                    @endforeach
                                </select>
                                @error('till_id') <div class="text-danger">{{ $message }}</div> @enderror
                            @endif
                        </div>


                        <div class="col-12 col-md-6 mt-3">
                            @if($this->editing == false)
                                <label class="form-label" for="open_date">Open Month</label>
                                <input
                                    wire:model.defer="open_date"
                                    type="month"
                                    id="open_date"
                                    name="open_date"
                                    class="form-control"
                                    placeholder="open_date"
                                />
                                @error('open_date') <div class="text-danger">{{ $message }}</div> @enderror
                            @else
                                <label class="form-label" for="close_date">Close Month</label>
                                <input
                                    wire:model.defer="close_date"
                                    type="month"
                                    id="close_date"
                                    name="close_date"
                                    class="form-control"
                                    placeholder="close_date"
                                />
                                @error('close_date') <div class="text-danger">{{ $message }}</div> @enderror
                            @endif
                        </div>

                        <div class="col-2"></div>
                        <div class="col-8 mt-5 table-responsive">
                            <table class="table border border-1 table-striped">
                                <thead class="table-light text-center">
                                <tr class="text-nowrap">
                                    <th class="w-25">Currency</th>
                                    <th class="w-50">Till Amount</th>
                                    @if($editing)
                                        <th class="w-50">Closing Amount</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($tillAmounts as $key => $tillAmount)
                                        <tr>
                                            <td class="ps-4 text-center text-dark">
                                                {{ $tillAmount['currency']['name'] }}
                                            </td>
                                            <td class="ps-4 text-center text-dark">
                                                <span id="amount-{{ $key }}">{{ $tillAmount['amount'] }}</span>
                                            </td>
                                            @if($editing)
                                                <td class="ps-4 text-center">
                                                    <div class="input-group input-group-merge">
                                                        <input class="form-control cleave-input border-success closing-amounts" id="closing-amount-{{$key}}" data-key="{{ $key }}" type="text" wire:model="tillAmounts.{{ $key }}.closing_amount" />
                                                        <span id="closing-amount-span-{{ $key }}" class="input-group-text border-success">
                                                            <i id="closing-amount-icon-{{ $key }}" class="ti ti-check text-success"></i>
                                                        </span>
                                                    </div>
                                                    @error('tillAmounts.' . $key . '.closing_amount') <div class="text-danger">{{ $message }}</div> @enderror
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $editing ? 3 : 2 }}" class="text-center">No data available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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

        $(document).on('input', '.closing-amounts', function () {
            let key = $(this).data('key');
            let amount = $(`#amount-${key}`).text();
            let closingAmount = $(this).val();
            let spanTextSelector = $(`#closing-amount-span-${key}`);
            let iconSelector = $(`#closing-amount-icon-${key}`)

            amount = parseFloat(amount.replace(/,/g, ""));
            closingAmount = parseFloat(closingAmount.replace(/,/g, ""));

            if (amount == closingAmount) {
                $(this).removeClass('border-danger')
                $(this).addClass('border-success')

                spanTextSelector.removeClass('border-danger')
                spanTextSelector.addClass('border-success')

                iconSelector.removeClass('ti-alert-circle')
                iconSelector.removeClass('text-danger')

                iconSelector.addClass('ti-check')
                iconSelector.addClass('text-success')
            } else {
                $(this).removeClass('border-success')
                $(this).addClass('border-danger')

                spanTextSelector.removeClass('border-success')
                spanTextSelector.addClass('border-danger')

                iconSelector.removeClass('ti-check')
                iconSelector.removeClass('text-success')

                iconSelector.addClass('ti-alert-circle')
                iconSelector.addClass('text-danger')
            }
        })

    </script>
    @endscript
</div>



