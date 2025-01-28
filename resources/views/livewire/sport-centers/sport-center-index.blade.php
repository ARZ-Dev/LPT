<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Sport Centers List</h4>
            @can('sportCenter-create')
                <a class="btn btn-primary h-50" href="{{ route('sport-centers.create') }}">Create Sport Center</a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-sport-centers dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Courts Count</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sportCenters as $sportCenter)
                    <tr>
                        <td>{{ $sportCenter->id }}</td>
                        <td>{{ $sportCenter->name }}</td>
                        <td>{{ $sportCenter->country?->name }} / {{ $sportCenter->governorate?->name }} / {{ $sportCenter->city?->name }}</td>
                        <td>{{ $sportCenter->courts_count }}</td>
                        <td>{{ $sportCenter->created_at->format('d-m-Y h:i') }}</td>
                        <td class="text-nowrap">
                            @can('sportCenter-edit')
                                <a href="{{ route('sport-centers.edit', $sportCenter->id) }}" class="text-body edit-sportCenter-button"><i class="ti ti-edit ti-sm"></i></a>
                            @endcan
                            @can('sportCenter-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $sportCenter->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
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
