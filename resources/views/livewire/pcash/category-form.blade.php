<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Category</h5>
                    <a href="{{ route('category') }}" class="btn btn-primary mb-2 text-nowrap">
                        Category
                    </a>
                </div>
                <div class="card-body">
                    <form class="row g-3">

                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                        <input
                        wire:model.defer="name"
                        type="text"
                        id="name"
                        name="name"
                        class="form-control "
                        placeholder="Name"
                        />
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 col-md-6">

                    </div>

                    @foreach($sub_category as $index => $subcategory)
                    <div wire:key="subcategory-{{ $index }}">
                        <label class="form-label" for="sub_category[{{ $index }}][name]">Sub Category Name <span class="text-danger">*</span> </label>
                        <div class="d-flex flex-row">
                            <input class="form-control w-50 me-2" wire:model="sub_category.{{ $index }}.name" type="text" id="sub_category[{{ $index }}][name]" name="sub_category[{{ $index }}][name]" placeholder="Sub Category Name" required>
                            @if(!$status)
                                @if($index == 0)
                                    <button type="button" class="btn btn-success" wire:click="addRow">Add Sub Category</button>
                                @else
                                    <button type="button" class="btn btn-danger" wire:click="removeSubCategory({{ $index }})">Remove</button>
                                @endif
                            @endif
                        </div>
                    </div>
                    @error('sub_category.'. $index .'.name') <div class="text-danger">{{ $message }}</div> @enderror
                    @endforeach

                    </form>
                </div>

            </div>

            @if(!$status)
            <div class="col-12 text-end mt-2">
                @if(!$status)
                    <button wire:click="{{ $editing ? "update" : "store" }}"  type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
                @endif
            </div>
            @endif
        </div>

    <script>
        document.addEventListener('livewire:navigated', function () {
            var status={{$status}};
            if (status=="1") {$('input').prop('disabled', true);}
        });

    </script>
    </div>
</div>


