<div>
    <div class="row">
        <div class="col-xl">
            <form class="row g-3">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Create/Edit Blog</h5>
                        <a href="{{ route('hero-sections') }}"
                           class="btn btn-primary mb-2 text-nowrap"
                        >
                            Blogs
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
                            <div class="col-12 col-md-12 mt-3">
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
                        </div>
                    </div>

                </div>

                <div class="card mb-4 mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            Image Upload (Large Size: 770x580 - Medium Size: 370x280) *
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

    </script>
    @endscript
</div>

