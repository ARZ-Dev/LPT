<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Petty Cash</h4>

        </div>
        <div class="card-datatable table-responsive">
            <table id="datatables-reportData" class="datatables-reportData dataTable table border-top">
                <thead>
                 <tr>
                     <th>type</th>
                     <th>date</th>
                     <th>description</th>
                 </tr>
                </thead>
                <tbody>
                @foreach($reportData as $data)
                    <tr>
                        <td>{{ $data['section'] }}</td>
                        <td>{{ $data['date']->format('m-d-Y h:i a') }}</td>
                        <td>{{ $data['model']::reportMessage($data) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <script>

    </script>

</div>

