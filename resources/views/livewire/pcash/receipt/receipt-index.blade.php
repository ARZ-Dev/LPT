<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Receipts List</h4>
            @can('receipt-create')
                <a class="btn btn-primary h-50" href="{{ route('receipt.create') }}">Add Receipt</a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-receipt dataTable table border-top">
                <thead>
                 <tr>
                    <th>ID</th>
                    <th>Created By</th>
                    <th>Till</th>
                    <th>From Customer</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Tournament / Team</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($receipts as $receipt)
                    <tr>
                        <td class="text-nowrap">{{ $receipt->id }}</td>
                        <td class="text-nowrap">{{ $receipt->user?->full_name }}</td>
                        <td class="text-nowrap">{{ $receipt->till?->name }} / {{ $receipt->till?->user?->full_name }}</td>
                        <td class="text-nowrap">{{ $receipt->paid_by }}</td>
                        <td class="text-nowrap">{{ $receipt->category?->name }}</td>
                        <td class="text-nowrap">{{ $receipt->subCategory?->name }}</td>
                        <td class="text-nowrap">{{ $receipt->tournament?->name }} / {{ $receipt->team?->nickname }}</td>
                        <td class="text-nowrap">{{ $receipt->created_at->format('d-m-Y h:i a') }}</td>

                        <td class="text-nowrap"0.>
                            @can('receipt-view')
                                <a href="{{ route('receipt.view', ['id' => $receipt->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('receipt-edit')
                                <a href="{{ route('receipt.edit', $receipt->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan
                            @can('receipt-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $receipt->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

