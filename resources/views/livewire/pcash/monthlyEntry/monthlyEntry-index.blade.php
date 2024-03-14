<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Monthly Entries List</h4>
            <a class="btn btn-primary h-50" href="{{ route('monthlyEntry.create') }}">Open Monthly Entry</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-monthlyEntry dataTable table border-top">
                <thead>
                 <tr>
                    <th>ID</th>
                    <th>created by</th>
                    <th>till</th>
                    <th>Month</th>
                    <th>Status</th>
                    <th>created at</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($monthlyEntries as $monthlyEntry)
                    <tr class="{{ $monthlyEntry->allAmountsClosed() ? "" : "bg-label-danger" }}">
                        <td>{{ $monthlyEntry->id }}</td>
                        <td>{{ $monthlyEntry->user?->full_name }}</td>
                        <td>{{ $monthlyEntry->till?->name }}</td>
                        <td>{{ $monthlyEntry->open_date ? \Carbon\Carbon::parse($monthlyEntry->open_date)->format('M Y') : "" }}</td>
                        <td>
                            <span class="badge bg-label-{{ $monthlyEntry->close_date ? "info" : "warning" }}">
                                {{ $monthlyEntry->close_date ? "Closed" : "Pending" }}
                            </span>
                        </td>
                        <td>{{ $monthlyEntry->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            @can('monthlyEntry-list')
                                <a href="{{ route('monthlyEntry.view', ['id' => $monthlyEntry->id, 'status' => \App\Utils\Constants::VIEW_STATUS]) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('monthlyEntry-edit')
                                @if(!$monthlyEntry->close_date)
                                    <a href="{{ route('monthlyEntry.edit', $monthlyEntry->id) }}" class="text-body edit-user-button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Close Month">
                                        <i class="ti ti-calendar-off ti-sm"></i>
                                    </a>
                                @endif
                            @endcan
                            @can('monthlyEntry-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $monthlyEntry->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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

