<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Blogs List</h4>
            <a class="btn btn-primary h-50" href="{{ route('blogs.create') }}">Add Blog</a>
        </div>
        <div class="card-datatable table-responsive" wire:ignore>
            <table class="datatables-blogs row-reorder-dt table border-top" id="table">
                <thead>
                <tr>
                    <th>Order</th>
                    <th class="d-none">Id</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($blogs as $blog)
                    <tr>
                        <td>{{ $blog->order }}</td>
                        <td class="d-none">{{ $blog->id }}</td>
                        <td>
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-4">
                                    <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($blog->image)) }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                        </td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $blog->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                            <a href="#" class="text-body delete-record delete-button" data-id="{{ $blog->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

    @script
    <script>

        $(document).ready(function () {
            // Array to store ordered row IDs
            var slidersOrder = [];

            var table = $('#table').DataTable({
                rowReorder: true,
            });
            table.on('draw', function () {

                slidersOrder = [];
                table.rows().every(function () {
                    var data = this.data();
                    var rowId = data[1];
                    slidersOrder.push(rowId);
                });
                $wire.dispatch('updateOrder', {
                    slidersOrder
                })
            });
        })

    </script>
    @endscript

</div>

