<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Currency</h5>
                        <a href="{{ route('currency') }}"class="btn btn-primary mb-2 text-nowrap">
                        Currency
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                        <div class="col-12 col-md-6">
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
                            <label class="form-label" for="symbol">symbol</label>
                            <input
                            wire:model.defer="symbol"
                            type="text"
                            id="symbol"
                            name="symbol"
                            class="form-control"
                            placeholder="symbol"
                            />
                            @error('symbol') <div class="text-danger">{{ $message }}</div> @enderror
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
        });

        function submit(action)
        {
            window.livewire.emit(action)
        }

        </script>
    </div>
</div>


