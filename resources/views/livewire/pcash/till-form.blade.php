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

                        <div class="col-12 col-md-2">
                        <label class="form-label" for="user_id">Users</label>
                            <select wire:model="user_id" class="form-select selectpicker " aria-label="Default select example" name="user_id" id="user_id">
                                <option>Open this select menu</option>
                                    @foreach($users as $user)
                                        <option {{ $user->id == $user_id ? 'selected' : '' }} value='{{$user->id}}'>{{$user->username}}</option>
                                    @endforeach
                            </select>
                            @error('user_id') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-10">
                            <label class="form-label" for="name">name</label>
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

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="usd_opening">usd_opening</label>
                            <input  
                            wire:model="usd_opening"
                            type="text"
                            id="usd_opening"
                            name="usd_opening"
                            class="form-control cleave-input "
                            placeholder="usd_opening"
                         
                            />
                            @error('usd_opening') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="lbp_opening">lbp_opening</label>
                            <input  
                            wire:model="lbp_opening"
                            type="text"
                            id="lbp_opening"
                            name="lbp_opening"
                            class="form-control cleave-input"
                            placeholder="lbp_opening"
                           
                            />
                            @error('lbp_opening') <div class="text-danger">{{ $message }}</div> @enderror
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


