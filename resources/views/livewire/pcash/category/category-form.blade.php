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
                        <label class="form-label" for="type">Type <span class="text-danger">*</span></label>
                        <div wire:ignore>
                            <select wire:model="type"  class="form-select selectpicker w-100" aria-label="Default select example" title="Select Type" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                <option value="payment" @selected($type == "payment")>Payment</option>
                                <option value="receipt" @selected($type == "receipt")>Receipt</option>
                            </select>
                        </div>
                        @error('type') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    @foreach($subCategories as $index => $subcategory)
                    <div wire:key="subcategory-{{ $index }}">

                        <div class="row ">
                            <div class="col-5">
                                <label class="form-label" for="sub_category[{{ $index }}][name]">Sub Category Name <span class="text-danger">*</span> </label>
                            </div>
                            <div class="col-5">
                                <label class="form-label" for="charge-{{$index}}">Charge</label>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-12 col-md-5 col-sm-12 sm-mb">
                                <input class="form-control"
                                       wire:model="subCategories.{{ $index }}.name"
                                       type="text" id="sub_category[{{ $index }}][name]"
                                       name="sub_category[{{ $index }}][name]"
                                       placeholder="Sub Category Name"
                                       required
                                >
                                @error('subCategories.'. $index .'.name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-5 col-sm-12 sm-mb">
                                <input
                                    wire:model="subCategories.{{ $index }}.charge"
                                    class="form-control cleave-input"
                                    type="text" id="sub_category[{{ $index }}][charge]"
                                    name="sub_category[{{ $index }}][charge]"
                                    placeholder="Charge"
                                >
                                @error('subCategories.'. $index .'.charge') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            @if(!$status)
                                <div class="col-12 col-md-2 col-sm-12 sm-mb">
                                    @if($index == 0)
                                        <button type="button" class="btn btn-success ms-2" wire:click="addRow">Add Sub Category</button>
                                    @else
                                        <button type="button" class="btn btn-danger ms-2" wire:click="removeSubCategory({{ $index }})">Remove</button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
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

    </div>

    @script
    <script>

        triggerCleave()

        Livewire.hook('morph.added', ({ el }) => {
            triggerCleave()
        })

    </script>
    @endscript
</div>


