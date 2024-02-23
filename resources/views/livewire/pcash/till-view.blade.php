<div>
  
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Tills List</h4>
            <a class="btn btn-primary h-50" href="{{ route('till.create') }}">Add Till</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-till dataTable table border-top">
                <thead>
                 <tr>
                    <th>UserName</th>
                    <th>till name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tills as $till)
                    <tr>
                        <td>{{ $till->user->username ?? 'N/A' }}</td>
                        <td>{{ $till->name }}</td>
                        <td>{{ $till->created_at->format('m-d-Y h:i a') }}</td>

                        <td>
                            @can('till-edit')
                                <a href="{{ route('till.edit', $till->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                            @endcan
                            @can('till-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $till->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

