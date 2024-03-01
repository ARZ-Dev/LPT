<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Exchanges List</h4>
            <a class="btn btn-primary h-50" href="{{ route('exchange.create') }}">Add Exchange</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-exchange dataTable table border-top">
                <thead>
                 <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>amount</th>
                    <th>rate</th>
                    <th>description</th>
                    <th>result</th>


                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($exchanges as $exchange)
                    <tr>
                        <td>{{ $exchange->fromCurrency->name }}</td>
                        <td>{{ $exchange->toCurrency->name }}</td>
                        <td>{{ $exchange->amount }}</td>
                        <td>{{ $exchange->rate }}</td>
                        <td>{{ $exchange->description }}</td>
                        <td>{{ $exchange->result }}</td>


                        <td>{{ $exchange->created_at->format('m-d-Y h:i a') }}</td>
                        <td>
                            @can('exchange-list')
                                <a href="{{ route('exchange.view', ['id' => $exchange->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('exchange-edit')
                                <a href="{{ route('exchange.edit', $exchange->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                            @endcan
                            @can('exchange-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $exchange->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

