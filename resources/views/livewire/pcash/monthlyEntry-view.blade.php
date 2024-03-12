<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Monthly Entries List</h4>
            <a class="btn btn-primary h-50" href="{{ route('monthlyEntry.create') }}">Add Open Monthly Entry</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-monthlyEntry dataTable table border-top">
                <thead>
                 <tr>
                    <th>user</th>
                    <th>till</th>
                    <th>open date</th>
                    <th>close date</th>
                    <th>created by</th>
                    <th>created at</th>

                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($monthlyEntries as $monthlyEntry)
                    <tr>
                        <td>{{ $monthlyEntry->user->username }}</td>
                        <td>{{ $monthlyEntry->till->name }}</td>

                        <td>{{ \Carbon\Carbon::parse($monthlyEntry->open_date)->format('Y-m') }}</td>
                        <td>{{ \Carbon\Carbon::parse($monthlyEntry->close_date)->format('Y-m') }}</td>
                        
                        <td>{{ $monthlyEntry->createdby->username }}</td>
                        <td>{{ $monthlyEntry->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            @can('monthlyEntry-list')
                                <a href="{{ route('monthlyEntry.view', ['id' => $monthlyEntry->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('monthlyEntry-edit')
                                <a href="{{ route('monthlyEntry.edit', $monthlyEntry->id) }}" class="text-body edit-user-button"><i class="ti ti-circle-x ti-sm"></i></a>
                            @endcan
                            @can('monthlyEntry-delete')
                                <!-- <a href="#" class="text-body delete-record delete-button" data-id="{{ $monthlyEntry->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a> -->
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

