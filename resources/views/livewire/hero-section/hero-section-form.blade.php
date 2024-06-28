<div>
    <div class="row">
        <div class="col-xl">
            <form class="row g-3">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Create/Edit Hero Section</h5>
                        <a href="{{ route('hero-sections') }}"
                           class="btn btn-primary mb-2 text-nowrap"
                        >
                            Hero Sections
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="title">Title *</label>
                                <input
                                    wire:model="title"
                                    type="text"
                                    id="title"
                                    name="title"
                                    class="form-control"
                                    placeholder="Title"
                                />
                                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="classic col-12 col-md-6">
                                <label class="form-label" for="titleTextColor">Title Text Color</label>
                                <input
                                    wire:model="titleTextColor"
                                    type="color"
                                    id="titleTextColor"
                                    name="titleTextColor"
                                    class="form-control form-control-color"
                                />
                                @error('titleTextColor') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="link">Link</label>
                                <input
                                    wire:model="link"
                                    type="text"
                                    id="link"
                                    name="link"
                                    class="form-control"
                                    placeholder="Link"
                                />
                                @error('link') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-lg-10 col-sm-12">
                                <label class="form-label" for="description">Description *</label>
                                <textarea
                                    wire:model="description"
                                    type="text"
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    placeholder="Description"
                                >
                                </textarea>
                                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-lg-2 col-sm-12">
                                <label class="form-label" for="descriptionTextColor">Description Text Color</label>
                                <input
                                    wire:model="descriptionTextColor"
                                    type="color"
                                    id="descriptionTextColor"
                                    name="descriptionTextColor"
                                    class="form-control form-control-color"
                                />
                                @error('descriptionTextColor') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card mb-4 mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            Image Upload (1920x720) *
                            @if($image)
                                - <a href="{{ asset(\Illuminate\Support\Facades\Storage::url($image)) }}" download>Download Link</a>
                            @endif
                        </h5>
                        <h6>
                            @error('image')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                @php
                                    $uploadedFile = $image ? asset(\Illuminate\Support\Facades\Storage::url($image)) : null;
                                @endphp
                                <x-filepond wire:model="image" delete-event="deleteImage" file-path="{{ $uploadedFile }}" is-multiple="false" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-end mt-2">
                    <button wire:click="store" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
                </div>
            </form>

        </div>
    </div>

    @script
    <script>

        $(document).ready(function () {

            let colorPicker = document.querySelector('#color-picker-classic')

            pickr.create({
                el: colorPicker,
                theme: 'classic',
                default: 'rgba(102, 108, 232, 1)',
                swatches: [
                    'rgba(102, 108, 232, 1)',
                    'rgba(40, 208, 148, 1)',
                    'rgba(255, 73, 97, 1)',
                    'rgba(255, 145, 73, 1)',
                    'rgba(30, 159, 242, 1)'
                ],
                components: {
                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        rgba: true,
                        hsla: true,
                        hsva: true,
                        cmyk: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            });
        })


    </script>
    @endscript
</div>

