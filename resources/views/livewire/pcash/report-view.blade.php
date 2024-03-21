<div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title mb-3">Summary</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-lg-5">
                            <label class="form-label">Tills:</label>
                            <div wire:ignore>
                                <select wire:model="tillIds"
                                        wire:change="getReportData"
                                        class="form-select selectpicker w-100"
                                        aria-label="Default select example"
                                        title="Select Tills"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-tick-icon="ti-check text-white"
                                        data-selected-text-format="count > 3"
                                        required
                                        multiple
                                >
                                    @foreach($tills as $till)
                                        <option value="{{ $till->id }}" @selected(in_array($till->id, $tillIds))>{{ $till->name . " / " . $till->user?->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('tillId') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-sm-6 col-lg-1">
                            <label class="form-label" for="filterByDate">Filter By Date:</label>
                            <div class="form-check form-switch m-2">
                                <input wire:model.live="filterByDate" wire:change="getReportData" class="form-check-input" type="checkbox" id="filterByDate">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 {{ $filterByDate ? "" : "d-none" }}">
                            <label class="form-label">Start Date:</label>
                            <input wire:model="startDate" wire:change="getReportData" type="date" class="form-control dt-input">
                            @error('startDate') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3 {{ $filterByDate ? "" : "d-none" }}">
                            <label class="form-label">End Date:</label>
                            <input wire:model="endDate" wire:change="getReportData" type="date" class="form-control dt-input">
                            @error('endDate') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div wire:loading>
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <span>Loading data...</span>
            </div>
        </div>
        <div wire:loading.remove class="card-datatable table-responsive">
            <table id="report-data-table" class="datatables-reportData table border-top">
                <thead>
                 <tr>
                     <th class="text-nowrap">ID</th>
                     <th class="text-nowrap">Till</th>
                     <th class="text-nowrap">Date</th>
                     <th class="text-nowrap">Created By</th>
                     <th class="text-nowrap">Paid By / To</th>
                     <th class="text-nowrap">Description</th>
                     <th class="text-nowrap">From / To</th>
                     <th class="text-nowrap">Ctg / Sub Ctg</th>
                     @foreach($currencies as $key => $currency)
                         <th class="text-nowrap">Debit {{ $currency->name }}</th>
                         <th class="text-nowrap">Credit {{ $currency->name }}</th>
                         <th class="text-nowrap">Balance {{ $currency->name }}</th>
                     @endforeach
                 </tr>
                </thead>
                <tbody>
                    @foreach($tillIds as $tillId)
                        @php($totalDebits = [])
                        @php($totalCredits = [])
                        @php($balances = [])
                        @forelse($reportData[$tillId] ?? [] as $data)
                            <tr class="{{ $data['bg_color'] }}">
                                <td class="text-nowrap">
                                    <a href="{{ $data['url'] }}" target="_blank">
                                        {{ $data['section_id'] }}
                                    </a>
                                </td>
                                <td class="text-nowrap">
                                    {{ $data['till']?->name }} / {{ $data['till']?->user?->full_name }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $data['date']->format('d-m-Y H:i') }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $data['user']->username }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $data['paid_by'] ?? $data['paid_to'] }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $data['description'] }}
                                </td>
                                <td class="text-nowrap">
                                    @if($data['from_till'])
                                        {{ $data['from_till']->name }} / {{ $data['from_till']->user?->full_name }} To {{ $data['to_till']?->name }} / {{ $data['to_till']->user?->full_name }}
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if($data['category'])
                                        {{ $data['category']->name }} / {{ $data['sub_category']?->name }}
                                    @endif
                                </td>
                                @foreach($currencies as $currency)
                                    <td>
                                        @if(isset($data['amounts'][$currency->id]['debit']) && !empty($data['amounts'][$currency->id]['debit']))

                                            @php($totalDebits[$tillId][$currency->id] = ($totalDebits[$tillId][$currency->id] ?? 0) + $data['amounts'][$currency->id]['debit'])

                                            {{ number_format($data['amounts'][$currency->id]['debit'], 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($data['amounts'][$currency->id]['credit']) && !empty($data['amounts'][$currency->id]['credit']))

                                            @php($totalCredits[$tillId][$currency->id] = ($totalCredits[$tillId][$currency->id] ?? 0) + $data['amounts'][$currency->id]['credit'])

                                            {{ number_format($data['amounts'][$currency->id]['credit'], 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($data['amounts'][$currency->id]['balance']))

                                            @php($balances[$tillId][$currency->id] = $data['amounts'][$currency->id]['balance'])

                                            {{ number_format($data['amounts'][$currency->id]['balance'], 2) }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 8 + (count($currencies) * 3) }}" class="text-center">No data available</td>
                            </tr>
                        @endforelse

                        <tr class="bg-label-success">
                            <th colspan="8" class="text-center">Totals</th>
                            @foreach($currencies as $currency)
                                <th class="text-nowrap">{{ number_format($totalDebits[$tillId][$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                                <th class="text-nowrap">{{ number_format($totalCredits[$tillId][$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                                <th class="text-nowrap">{{ number_format($balances[$tillId][$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @script
    <script>

        Livewire.hook('request', ({ uri, options, payload, respond, succeed, fail }) => {
            succeed(({ status, json }) => {
                // $('#report-data-table').DataTable().order([[1, 'asc']]).draw();
            })
        })

    </script>
    @endscript
</div>

