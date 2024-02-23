<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Categories List</h4>
            <a class="btn btn-primary h-50" href="{{ route('category.create') }}">Add Category </a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-category dataTable table border-top">
                <thead>
                 <tr>
                    <th>Category</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->created_at->format('m-d-Y h:i a') }}</td>
                        <td>
                            @can('category-edit')
                                <a href="{{ route('category.edit', $category->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                            @endcan
                            @can('category-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $category->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @script
        @include('livewire.deleteConfirm')
    @endscript


</div>

