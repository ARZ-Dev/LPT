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
            <table id="report-data-table" class="datatables-reportData table table-hover border-top table-bordered">
                <thead>
                 <tr>
                     <th class="text-nowrap text-center">ID</th>
                     <th class="text-nowrap text-center">Date</th>
                     <th class="text-nowrap text-center">Created By</th>
                     <th class="text-nowrap text-center">Paid By / To</th>
                     <th class="text-nowrap text-center">Description</th>
                     <th class="text-nowrap text-center">From / To</th>
                     <th class="text-nowrap text-center">Ctg / Sub Ctg</th>
                     @foreach($currencies as $key => $currency)
                         <th class="text-nowrap text-center">Debit {{ $currency->name }}</th>
                         <th class="text-nowrap text-center">Credit {{ $currency->name }}</th>
                         <th class="text-nowrap text-center">Balance {{ $currency->name }}</th>
                     @endforeach
                 </tr>
                </thead>
                <tbody>
                    @php($grandTotalDebits = [])
                    @php($grandTotalCredits = [])
                    @php($grandTotalBalances = [])
                    @foreach($selectedTills as $till)
                        @php($totalDebits = [])
                        @php($totalCredits = [])
                        @php($balances = [])

                        <tr class="bg-label-linkedin">
                            <td colspan="7" class="text-center">
                                {{ $till->name }} / {{ $till->user?->full_name }}
                            </td>
                            @foreach($currencies as $currency)
                                <td colspan="3"></td>
                            @endforeach
                        </tr>

                        @if($filterByDate)
                            <tr class="bg-label-warning">
                                <th colspan="7" class="text-center">Totals Before {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}</th>
                                @foreach($currencies as $currency)
                                    @php($grandTotalDebits[$currency->id] = ($grandTotalDebits[$currency->id] ?? 0) + ($totalsBefore[$till->id][$currency->id]['debit'] ?? 0))
                                    @php($grandTotalCredits[$currency->id] = ($grandTotalCredits[$currency->id] ?? 0) + ($totalsBefore[$till->id][$currency->id]['credit'] ?? 0))
                                    @php($grandTotalBalances[$currency->id] = ($grandTotalBalances[$currency->id] ?? 0) + ($totalsBefore[$till->id][$currency->id]['balance'] ?? 0))

                                    <th class="text-nowrap text-center">{{ number_format($totalsBefore[$till->id][$currency->id]['debit'] ?? 0, 2) }} {{ $currency->name }}</th>
                                    <th class="text-nowrap text-center">{{ number_format($totalsBefore[$till->id][$currency->id]['credit'] ?? 0, 2) }} {{ $currency->name }}</th>
                                    <th class="text-nowrap text-center">{{ number_format($totalsBefore[$till->id][$currency->id]['balance'] ?? 0, 2) }} {{ $currency->name }}</th>
                                @endforeach
                            </tr>
                        @endif

                        @forelse($reportData[$till->id] ?? [] as $data)
                            <tr class="{{ $data['bg_color'] }}">
                                <td class="text-nowrap text-center">
                                    <a href="{{ $data['url'] }}" target="_blank">
                                        {{ $data['section_id'] }}
                                    </a>
                                </td>
                                <td class="text-nowrap text-center">
                                    {{ $data['date']->format('d-m-Y H:i') }}
                                </td>
                                <td class="text-nowrap text-center">
                                    {{ $data['user']->username }}
                                </td>
                                <td class="text-nowrap text-center">
                                    {{ $data['paid_by'] ?? $data['paid_to'] }}
                                </td>
                                <td class="text-nowrap text-center">
                                    {{ $data['description'] }}
                                </td>
                                <td class="text-nowrap text-center">
                                    @if($data['from_till'])
                                        {{ $data['from_till']->name }} / {{ $data['from_till']->user?->full_name }} To {{ $data['to_till']?->name }} / {{ $data['to_till']->user?->full_name }}
                                    @endif
                                </td>
                                <td class="text-nowrap text-center">
                                    @if($data['category'])
                                        {{ $data['category']->name }} / {{ $data['sub_category']?->name }}
                                    @endif
                                </td>
                                @foreach($currencies as $currency)
                                    <td class="text-nowrap text-center">
                                        @if(isset($data['amounts'][$currency->id]['debit']) && !empty($data['amounts'][$currency->id]['debit']))

                                            @php($totalDebits[$till->id][$currency->id] = ($totalDebits[$till->id][$currency->id] ?? 0) + $data['amounts'][$currency->id]['debit'])

                                            {{ number_format($data['amounts'][$currency->id]['debit'], 2) }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap text-center">
                                        @if(isset($data['amounts'][$currency->id]['credit']) && !empty($data['amounts'][$currency->id]['credit']))

                                            @php($totalCredits[$till->id][$currency->id] = ($totalCredits[$till->id][$currency->id] ?? 0) + $data['amounts'][$currency->id]['credit'])

                                            {{ number_format($data['amounts'][$currency->id]['credit'], 2) }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap text-center">
                                        @if(isset($data['amounts'][$currency->id]['balance']))

                                            @php($balances[$till->id][$currency->id] = $data['amounts'][$currency->id]['balance'])

                                            {{ number_format($data['amounts'][$currency->id]['balance'], 2) }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 7 + (count($currencies) * 3) }}" class="text-center">No data available</td>
                            </tr>
                        @endforelse

                        <tr class="bg-label-success">
                            <th colspan="7" class="text-center">Totals</th>
                            @foreach($currencies as $currency)
                                @php($grandTotalDebits[$currency->id] = ($grandTotalDebits[$currency->id] ?? 0) + ($totalDebits[$till->id][$currency->id] ?? 0))
                                @php($grandTotalCredits[$currency->id] = ($grandTotalCredits[$currency->id] ?? 0) + ($totalCredits[$till->id][$currency->id] ?? 0))
                                @php($grandTotalBalances[$currency->id] = ($grandTotalBalances[$currency->id] ?? 0) + ($balances[$till->id][$currency->id] ?? 0))

                                <th class="text-nowrap text-center">{{ number_format($totalDebits[$till->id][$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                                <th class="text-nowrap text-center">{{ number_format($totalCredits[$till->id][$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                                <th class="text-nowrap text-center">{{ number_format($balances[$till->id][$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr class="bg-label-danger">
                    <th colspan="7" class="text-center">Grand Totals</th>
                    @foreach($currencies as $currency)
                        <th class="text-nowrap text-center">{{ number_format($grandTotalDebits[$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                        <th class="text-nowrap text-center">{{ number_format($grandTotalCredits[$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                        <th class="text-nowrap text-center">{{ number_format($grandTotalBalances[$currency->id] ?? 0, 2) }} {{ $currency->name }}</th>
                    @endforeach
                </tr>
                </tfoot>
            </table>

        </div>
    </div>

    <div class="row mt-1 g-4 mb-4">
        @can('till-list')
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('till') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <h3>Tills</h3>
                                <p class="mb-0">Total Tills: {{ number_format($sectionTotalsCount['tills']) }}</p>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-cash-banknote ti-sm"></i>
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('monthlyEntry-list')
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('monthly-openings-closings') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <h3>Monthly Openings/Closings</h3>
                                <p class="mb-0">Total Monthly Openings/Closings: {{ number_format($sectionTotalsCount['monthly_entries']) }}</p>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-calendar-stats ti-sm"></i>
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('payment-list')
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('payment') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <h3>Payments</h3>
                                <p class="mb-0">Total Payments: {{ number_format($sectionTotalsCount['payments']) }}</p>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-report-money ti-sm"></i>
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('receipt-list')
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('receipt') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <h3>Receipts</h3>
                                <p class="mb-0">Total Receipts: {{ number_format($sectionTotalsCount['receipts']) }}</p>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-file-invoice ti-sm"></i>
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('transfer-list')
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('transfer') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <h3>Transfers</h3>
                                <p class="mb-0">Total Transfers: {{ number_format($sectionTotalsCount['transfers']) }}</p>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-primary">
                                <i class="fa fa-money-bill-transfer fa-sm"></i>
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

        @can('exchange-list')
        <div class="col-sm-6 col-xl-4">
            <a href="{{ route('exchange') }}" target="_blank">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <h3>Exchanges</h3>
                                <p class="mb-0">Total Exchanges: {{ number_format($sectionTotalsCount['exchanges']) }}</p>
                            </div>
                            <div class="avatar">
                              <span class="avatar-initial rounded bg-label-primary">
                                <i class="fa fa-exchange fa-sm"></i>
                              </span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endcan

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

