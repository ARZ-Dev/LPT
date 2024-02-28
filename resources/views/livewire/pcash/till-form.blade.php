<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Till</h5>
                        <a href="{{ route('till') }}"class="btn btn-primary mb-2 text-nowrap">
                        Till
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                        <div class="col-12 col-md-6 ">
                        <label class="form-label" for="user_id">Users <span style="color: red;">*</span></label>
                            <select wire:model="user_id" class="form-select selectpickerz w-100 " aria-label="Default select example" name="user_id" id="user_id">
                                <option>Open this select menu</option>
                                    @foreach($users as $user)
                                        <option {{ $user->id == $user_id ? 'selected' : '' }} value='{{$user->id}}'>{{$user->username}}</option>
                                    @endforeach
                            </select>
                            @error('user_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">name <span style="color: red;">*</span></label>
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

                            @foreach($tillAmount as $key => $tillAmount)
                            <div wire:key="tillAmount-{{ $key }}">
                                    <label class="mt-3" for="amount{{$key}}">amount<span style="color: red;">*</span></label>
                                    <div class="d-flex flex-row mt-3 mb-3">
                                        <input class="form-control cleave-input w-100 me-2 " wire:model="tillAmount.{{ $key }}.amount" type="text" name="tillAmount[{{ $key }}][amount]" placeholder="amount" id="amount{{$key}}" required>

                                        <select class="form-select " aria-label="Default select example" wire:model="tillAmount.{{ $key }}.currency_id" id="currency{{$key}}" >
                                            <option selected>Open this select menu <span style="color: red;">*</span></option>
                                            @foreach($currencies as $index => $currency)
                                                <option value="{{$currency->id}}" >{{$currency->name}}</option>
                                            @endforeach
                                        </select>
                                      
                                        @if($key !== 0)
                                        <button type="button" class="btn btn-danger ms-2"  wire:click="removeTillAmount({{ $key }})">Remove</button>
                                        @endif
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

        <script>
            
            


            document.addEventListener('livewire:navigated', function () {
                var status={{$status}};
                if (status=="1") {$('input').prop('disabled', true);}
                triggerCleave()
            });

            function submit(action)
            {
                window.livewire.emit(action)
            }

        </script>
    </div>
</div>


