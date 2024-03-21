<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Category #{{ $category->id }}</h5>
                    <a href="{{ route('category') }}" class="btn btn-primary mb-2 text-nowrap">
                        Category
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">User:</span>
                            <span class="text-dark" id="user">{{ $category->user?->full_name }}</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Name:</span>
                            <span class="text-dark" id="name">{{ $category->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            @foreach($category->subCategories as $key => $subCategory)
                    <div class="col-12 col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Sub Category {{ $key + 1 }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 m-2">
                                        <span class="fw-bold text-dark">Name:</span>
                                        <span class="text-dark">{{$subCategory->name}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
            </div>
        </div>
    </div>

    @script
    <script>

    </script>
    @endscript
</div>
