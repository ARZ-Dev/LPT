<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Hero Sections List</h4>
            <a class="btn btn-primary h-50" href="{{ route('hero-sections.create') }}">Add Hero Section</a>
        </div>
        <div class="card-datatable table-responsive" wire:ignore>
            <table class="datatables-homeSection row-reorder-dt table border-top" id="table">
                <thead>
                <tr>
                    <th>Order</th>
                    <th class="d-none">Id</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($heroSections as $heroSection)
                    <tr>
                        <td>{{ $heroSection->order }}</td>
                        <td class="d-none">{{ $heroSection->id }}</td>
                        <td>
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-4">
                                    <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($heroSection->image)) }}" alt="Avatar" class="rounded-circle">
                                </div>
                            </div>
                        </td>
                        <td>{{ $heroSection->title }}</td>
                        <td>
                            <button class="btn btn-label-{{ $heroSection->is_active ? "warning" : "info" }} toggleStatus btn-sm" data-id="{{ $heroSection->id }}">
                                {{ $heroSection->is_active ? "Hide" : "Show" }}
                            </button>
                        </td>
                        <td>{{ $heroSection->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            <a href="{{ route('hero-sections.edit', $heroSection->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                            <a href="#" class="text-body delete-record delete-button" data-id="{{ $heroSection->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

        $(document).on('click', '.toggleStatus', function () {
            const id = $(this).data('id')
            $wire.dispatch('toggleStatus', {
                id
            });
        })

    </script>
    @endscript

</div>

