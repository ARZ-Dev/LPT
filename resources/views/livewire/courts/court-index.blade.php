<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Courts List</h4>
            @can('court-create')
                <a class="btn btn-primary h-50" href="{{ route('courts.create') }}">Create Court</a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-courts dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Governorate</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courts as $court)
                    <tr>
                        <td>{{ $court->id }}</td>
                        <td>{{ $court->name }}</td>
                        <td>{{ $court->country?->name }}</td>
                        <td>{{ $court->governorate?->name }}</td>
                        <td>{{ $court->created_at->format('d-m-Y h:i') }}</td>
                        <td class="text-nowrap">
                            @can('court-edit')
                                <a href="{{ route('courts.edit', $court->id) }}" class="text-body edit-court-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan
                            @can('court-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $court->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

    @script
    <script>

    </script>
    @endscript

</div>
