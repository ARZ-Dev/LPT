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
                        <label class="form-label" for="category_name">Category Name <span style="color: red;">*</span></label>
                        <input  
                        wire:model.defer="category_name"
                        type="text"
                        id="category_name"
                        name="category_name"
                        class="form-control "
                        placeholder="category_name"
                        />
                        @error('category_name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        @if(!$status)
                            <button type="button" class="btn btn-success mt-4 " wire:click="addRow">Add Sub-category</button>
                        @endif
                    </div>

                    @foreach($sub_category as $index => $subcategory)
                    <div wire:key="subcategory-{{ $index }}">
                        <label for="sub_category[{{ $index }}][sub_category_name]">Sub-category Name <span style="color: red;">*</span> </label>
                        <div class="d-flex flex-row">
                        <input class="form-control w-50 me-2" wire:model="sub_category.{{ $index }}.sub_category_name" type="text" id="sub_category[{{ $index }}][sub_category_name]" name="sub_category[{{ $index }}][sub_category_name]" required>
                        @if($index !== 0)
                            @if(!$status)
                                <button type="button" class="btn btn-danger"  wire:click="removeSubCategory({{ $index }})">Remove</button>
                            @endif
                        @endif
                        </div>
                    </div>
                    @error('sub_category.'. $index .'.sub_category_name') <div class="text-danger">{{ $message }}</div> @enderror
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


