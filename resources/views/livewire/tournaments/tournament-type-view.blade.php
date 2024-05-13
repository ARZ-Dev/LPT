<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Tournament Types</h4>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-matches dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Points</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($types as $type)
                    <tr>
                        <td>{{ $type->id }}</td>
                        <td>{{ $type->name }}</td>
                        <td>{{ number_format($type->points) }}</td>

                        <td>
                            @can('tournamentType-edit')
                                <a href="{{ route('types.edit', $type->id) }}" class="text-body"><i class="ti ti-edit ti-sm me-2"></i></a>
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
