<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Currencies List</h4>
            <a class="btn btn-primary h-50" href="{{ route('currency.create') }}">Add Currency</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-currency dataTable table border-top">
                <thead>
                 <tr>
                    <th>name</th>
                    <th>Symbol</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($currencies as $currency)
                    <tr>
                        <td>{{ $currency->name }}</td>
                        <td>{{ $currency->symbol }}</td>
                        <td>{{ $currency->created_at->format('m-d-Y h:i a') }}</td>
                        <td>
                            @can('currency-edit')
                                <a href="{{ route('currency.edit', $currency->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                            @endcan
                            @can('currency-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $currency->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

