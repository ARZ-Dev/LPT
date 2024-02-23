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
                        <label class="form-label" for="from_till_id">From Tills</label>
                            <select wire:model="from_till_id" class="form-select selectpicker w-100 " aria-label="Default select example" name="from_till_id" id="from_till_id">
                                <option>Open this select menu</option>
                                    @foreach($fromTills as $fromTill)
                                        <option {{ $fromTill->id == $from_till_id ? 'selected' : '' }} value='{{$fromTill->id}}'>{{$fromTill->name}}</option>
                                    @endforeach
                            </select>
                            @error('from_till_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6 ">
                        <label class="form-label" for="to_till_id">From Tills</label>
                            <select wire:model="to_till_id" class="form-select selectpicker w-100 " aria-label="Default select example" name="to_till_id" id="to_till_id">
                                <option>Open this select menu</option>
                                    @foreach($toTills as $toTill)
                                        <option {{ $toTill->id == $to_till_id ? 'selected' : '' }} value='{{$toTill->id}}'>{{$toTill->name}}</option>
                                    @endforeach
                            </select>
                            @error('to_till_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="usd_amount">usd_amount</label>
                            <input  
                            wire:model="usd_amount"
                            type="text"
                            id="usd_amount"
                            name="usd_amount"
                            class="form-control cleave-input "
                            placeholder="usd_amount"
                         
                            />
                            @error('usd_amount') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="lbp_amount">lbp_amount</label>
                            <input  
                            wire:model="lbp_amount"
                            type="text"
                            id="lbp_amount"
                            name="lbp_amount"
                            class="form-control cleave-input"
                            placeholder="lbp_amount"
                           
                            />
                            @error('lbp_amount') <div class="text-danger">{{ $message }}</div> @enderror
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


