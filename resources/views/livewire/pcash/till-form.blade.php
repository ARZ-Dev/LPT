<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Till</h5>
                        <a href="{{ route('till') }}" class="btn btn-primary mb-2 text-nowrap">
                        Till
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                        <div class="col-12 col-md-6 ">
                            <label class="form-label" for="user_id">Users <span style="color: red;">*</span></label>
                            <div wire:ignore>
                                <select
                                    wire:model="user_id"
                                    id="user_id"
                                    class="selectpicker w-100"
                                    title="Select User"
                                    data-style="btn-default"
                                    data-live-search="true"
                                    data-icon-base="ti"
                                    data-tick-icon="ti-check text-white" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected($user->id == $user_id)>{{$user->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">Name <span style="color: red;">*</span></label>
                            <input
                            wire:model.defer="name"
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            placeholder="name"
                            />
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-12">
                            <button type="button" class="btn btn-success mt-4 " wire:click="addRow">Add Amount</button>

                            @foreach($tillAmounts as $key => $tillAmount)
                                <div wire:key="tillAmount-{{ $key }}">
                                    <label class="mt-3" for="amount{{$key}}">Amount<span style="color: red;">*</span></label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input class="form-control cleave-input w-100 me-2 " wire:model="tillAmounts.{{ $key }}.amount" type="text" name="tillAmount[{{ $key }}][amount]" placeholder="amount" id="amount{{$key}}" required>
                                        </div>
                                        <div class="col-4">
                                            <div wire:ignore>
                                                <select
                                                    wire:model="tillAmounts.{{ $key }}.currency_id"
                                                    id="currency{{$key}}"
                                                    class="selectpicker w-100"
                                                    title="Select Currency"
                                                    data-style="btn-default"
                                                    data-live-search="true"
                                                    data-icon-base="ti"
                                                    data-tick-icon="ti-check text-white"
                                                    required
                                                >
                                                    @foreach($currencies as $index => $currency)
                                                        <option value="{{$currency->id}}" @selected($tillAmount['currency_id'] == $currency->id) {{in_array($currency->id, $selectedCurrencies) ? "hidden" : ""}} >{{$currency->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            @if($key !== 0)
                                            <button type="button" class="btn btn-danger ms-2"  wire:click="removeTillAmount({{ $key }})">Remove</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @error('tillAmount.*.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                @error('tillAmount.*.currency_id') <div class="text-danger">{{ $message }}</div> @enderror
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

    <script>

        document.addEventListener('livewire:initialized', function () {
            var status={{$status}};
            if (status=="1") {$('input').prop('disabled', true);}
            triggerCleave()

            $('.selectpicker').selectpicker();


            Livewire.on('triggerSelectPicker', function () {
                $('.selectpicker').each(function () {
                    console.log($(this).attr('id'))
                    $(this).selectpicker()
                });
            })
        });

    </script>
</div>


