<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Categories List</h4>

        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-reportData dataTable table border-top">
                <thead>
                 <tr>
                    <th>description</th>
                    <th>section</th>
                    <th>date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reportData as $data)
                    <tr>
                        <td>
                            @if($data['section'] == 'categories')
                            Category:<a href="{{ route('category.edit', $data['id']) }}"><u> {{$data['category_name']}}</u></a> was added 
                            with subcategory :
                            @foreach ($data['subcategories'] as $subcategory)
                            <a href="{{ route('category.edit', $data['id']) }}"><u>
                                 {{ $subcategory->sub_category_name }}
                            </u></a> &nbsp;
                            @endforeach
                                
                            @elseif($data['section'] == 'currencies')
                                Currency: {{$data['name']}} was added

                            @elseif($data['section'] == 'tills')
                                Till :  <a href="{{ route('till.edit', $data['id']) }}"><u>{{$data['name']}}</u></a> was added
                                
                            @elseif($data['section'] == 'payments')
                            
                                Payments: {{$data['category_id']->category_name}}

                            @elseif($data['section'] == 'receipts')
                                Receipt By  {{$data['user_id']->username}} Paid By {{$data['paid_by']}}

                            @elseif($data['section'] == 'transfers')
                            Transfer: {{$data['name']}}

                            @elseif($data['section'] == 'exchanges')
                                Exchange: {{$data['amount']}}

                            @endif
                        </td>
                        <td>{{ $data['section'] }}</td>
                        <td>{{ $data['date']->format('m-d-Y h:i a') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>


</div>

