<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Transfers List</h4>
            @can('transfer-create')
                <a class="btn btn-primary h-50" href="{{ route('transfer.create') }}">Add Transfer</a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-transfer dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Created By</th>
                    <th>Transfer From</th>
                    <th>Transfer To</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transfers as $transfer)
                    <tr>
                        <td>{{ $transfer->id }}</td>
                        <td>{{ $transfer->user?->username }}</td>
                        <td>{{ $transfer->fromTill?->name }} / {{ $transfer->fromTill?->user?->full_name }}</td>
                        <td>{{ $transfer->toTill?->name  }} / {{ $transfer->toTill?->user?->full_name  }}</td>
                        <td>{{ $transfer->created_at->format('d-m-Y h:i a') }}</td>

                        <td>
                            @can('transfer-view')
                                <a href="{{ route('transfer.view', ['id' => $transfer->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('transfer-edit')
                                <a href="{{ route('transfer.edit', $transfer->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan
                            @can('transfer-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $transfer->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

