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
                            <label class="form-label" for="user_id">Users <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select wire:model="user_id" id="user_id" class="selectpicker w-100" title="Select User" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected($user->id == $user_id)>{{$user->full_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <input wire:model.defer="name" type="text" id="name" name="name" class="form-control" placeholder="Name" />
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-12">


                            @foreach($tillAmounts as $key => $tillAmount)
                            <div wire:key="till-amount-{{ $key }}">

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
                                        <input class="form-control cleave-input w-100 me-2 " wire:model="tillAmounts.{{ $key }}.amount" type="text" name="tillAmount[{{ $key }}][amount]" placeholder="Amount {{ $key + 1 }}" id="amount-{{$key}}" required>
                                        @error('tillAmounts.'. $key .'.amount') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-5">
                                        <div wire:ignore>
                                            <select
                                                wire:model="tillAmounts.{{ $key }}.currency_id"
                                                id="currency-{{$key}}" class="w-100 currency selectpicker"
                                                title="Select Currency {{ $key + 1 }}"
                                                data-style="btn-default"
                                                data-live-search="true"
                                                data-icon-base="ti"
                                                data-tick-icon="ti-check text-white"
                                                required
                                            >
                                                @foreach($currencies as $currency)
                                                    <option value="{{$currency->id}}"
                                                        @selected($tillAmount['currency_id'] == $currency->id)
                                                    >
                                                        {{ $currency->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('tillAmounts.'. $key .'.currency_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-2">
                                        @if($key == 0)
                                            @if(count($tillAmounts) < count($currencies))
                                                <button type="button" class="btn btn-success ms-2" wire:click="addRow">Add Amount</button>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-danger ms-2" wire:click="removeRow({{ $key }})">Remove</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </form>
                </div>
            </div>

            @if(!$status)
            <div class="col-12 text-end mt-2">
                <button wire:click="{{ $editing ? "update" : "store" }}" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
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

        $(document).on('change', '.currency', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })
    </script>
    @endscript
</div>
