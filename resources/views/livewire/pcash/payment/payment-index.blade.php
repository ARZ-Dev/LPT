<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Payments List</h4>
            @can('payment-create')
                <a class="btn btn-primary h-50" href="{{ route('payment.create') }}">Add Payment</a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-payment dataTable table border-top">
                <thead>
                 <tr>
                    <th>ID</th>
                    <th>Created By</th>
                    <th>Till</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Paid To</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->user?->full_name }}</td>
                        <td>{{ $payment->till?->name }} / {{ $payment->till?->user?->full_name }}</td>
                        <td>{{ $payment->category?->name }}</td>
                        <td>{{ $payment->subCategory?->name ?? 'N/A' }}</td>
                        <td>{{ $payment->paid_to }}</td>
                        <td>{{ $payment->description }}</td>
                        <td>{{ $payment->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            @can('payment-view')
                                <a href="{{ route('payment.view', ['id' => $payment->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('payment-edit')
                                <a href="{{ route('payment.edit', $payment->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan
                            @can('payment-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $payment->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

