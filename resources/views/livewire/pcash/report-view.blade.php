<div>

    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Petty Cash</h4>

        </div>
        <div class="card-datatable table-responsive">
            <table id="datatables-reportData" class="datatables-reportData dataTable table border-top">
                <thead>
                 <tr>
                     <th class="text-nowrap">ID</th>
                     <th class="text-nowrap">Date</th>
                     <th class="text-nowrap">Created By</th>
                     <th class="text-nowrap">Till</th>
                     <th class="text-nowrap">Description</th>
                     <th class="text-nowrap">To / From</th>
                     <th class="text-nowrap">Cat / Sub Cat</th>
                     @foreach($currencies as $currency)
                         <th class="text-nowrap">Debit {{ $currency->name }}</th>
                         <th class="text-nowrap">Credit {{ $currency->name }}</th>
                         <th class="text-nowrap">Balance {{ $currency->name }}</th>
                     @endforeach
                     <th>Action</th>
                 </tr>
                </thead>
                <tbody>
                @foreach($reportData as $data)
                    <tr>
                        <td class="text-nowrap">{{ ucfirst($data['section'][0]) }} #{{ $data['id'] }}</td>
                        <td class="text-nowrap">{{ $data['date']->format('m-d-Y h:i a') }}</td>
                        <td class="text-nowrap">{{ $data['user']->username }}</td>
                        <td class="text-nowrap">{{ $data['till']?->name }} / {{ $data['till_user']?->full_name }}</td>
                        <td class="text-nowrap">{{ $data['description'] }}</td>
                        <td class="text-nowrap">{{ $data['paid_by'] }}</td>
                        <td class="text-nowrap">
                            @if($data['category'])
                                {{ $data['category']->name }} / {{ $data['sub_category']?->name }}
                            @endif
                        </td>
                        @foreach($currencies as $currency)
                            <td>
                                @if(isset($data['amounts'][$data['till_id']][$currency->id]['debit']) && !empty($data['amounts'][$data['till_id']][$currency->id]['debit']))
                                    {{ number_format($data['amounts'][$data['till_id']][$currency->id]['debit'], 2) }}
                                @endif
                            </td>
                            <td>
                                @if(isset($data['amounts'][$data['till_id']][$currency->id]['credit']) && !empty($data['amounts'][$data['till_id']][$currency->id]['credit']))
                                    {{ number_format($data['amounts'][$data['till_id']][$currency->id]['credit'], 2) }}
                                @endif
                            </td>
                            <td>
                                @if(isset($data['amounts'][$data['till_id']][$currency->id]['balance']))
                                    {{ number_format($data['amounts'][$data['till_id']][$currency->id]['balance'], 2) }}
                                @endif
                            </td>
                        @endforeach
                        <td>Action</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
    <script>

    </script>

</div>

