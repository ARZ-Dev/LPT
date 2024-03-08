<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Payments List</h4>
            <a class="btn btn-primary h-50" href="{{ route('payment.create') }}">Add Payment</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-payment dataTable table border-top">
                <thead>
                 <tr>
                    <th>Till</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->till?->name }}</td>
                        <td>{{ $payment->category?->category_name }}</td>
                        <td>{{ $payment->subCategory?->sub_category_name ?? 'N/A' }}</td>
                        <td>{{ $payment->description }}</td>
                        <td>{{ $payment->user?->username }}</td>
                        <td>{{ $payment->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            @can('payment-list')
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

