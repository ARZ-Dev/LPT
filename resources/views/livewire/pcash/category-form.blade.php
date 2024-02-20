<div>
    <div class="row">
        <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Category</h5>
                        <a href="{{ route('category') }}"class="btn btn-primary mb-2 text-nowrap">
                        Category
                        </a>
                    </div>
                <div class="card-body">
                    <form class="row g-3">

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="category_name">category name</label>
                            <input  
                            wire:model.defer="category_name"
                            type="text"
                            id="category_name"
                            name="category_name"
                            class="form-control"
                            placeholder="category_name"
                            />
                            @error('category_name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label" for="sub_category_name">sub-category name</label>
                            <input
                            wire:model.defer="sub_category_name"
                            type="text"
                            id="sub_category_name"
                            name="sub_category_name"
                            class="form-control"
                            placeholder="sub_category_name"
                            />
                            @error('sub_category_name') <div class="text-danger">{{ $message }}</div> @enderror
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


