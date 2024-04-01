<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title mb-3">Available Tills</h4>
            @can('till-create')
            <a href="{{ route('till.create') }}" class="btn btn-primary mb-2 text-nowrap" target="_blank">
                Create Till
            </a>
            @endcan
        </div>
        <div class="card-body">
            <div class="row g-4">
                @foreach($tills as $till)
                    <div class="col-12 col-md-2">
                        <a wire:click="getTillInfo({{ $till->id }})" class="tills cursor-pointer">
                            <div class="bg-light rounded p-3 mb-3 text-center">
                                <h6 class="mb-0">{{ $till->name }}</h6>
                                <small class="text-muted">{{ $till->user?->full_name }}</small>
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>


    <a class="  d-md-none d-sm-block " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fa-solid fa-filter mt-3 mb-3" style="font-size: 48px;"></i>
    </a>

    <div class="collapse show " id="collapseExample">
        <div class="card card-body mt-4">

            <div class="row mt-1 g-4 mb-4 ">
                @can('monthlyEntry-list')
                <div class="col-sm-6 col-xl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <a href="{{ route('monthly-openings-closings') }}" target="_blank">
                                    <div class="content-left">
                                        <h5>Closings</h5>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('payment-list')
                <div class="col-sm-6 col-xl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <a href="{{ route('payment') }}" target="_blank">
                                    <div class="content-left">
                                        <h5>Payments</h5>
                                    </div>
                                </a>
                                <a href="{{ route('payment.create') }}" target="_blank">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('receipt-list')
                <div class="col-sm-6 col-xl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <a href="{{ route('receipt') }}" target="_blank">
                                    <div class="content-left">
                                        <h5>Receipts</h5>
                                    </div>
                                </a>
                                <a href="{{ route('receipt.create') }}" target="_blank">
                                    <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('transfer-list')
                <div class="col-sm-6 col-xl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <a href="{{ route('transfer') }}" target="_blank">
                                    <div class="content-left">
                                        <h5>Transfers</h5>
                                    </div>
                                </a>
                                <a href="{{ route('transfer.create') }}" target="_blank">
                                    <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan

                @can('exchange-list')
                <div class="col-sm-6 col-xl-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <a href="{{ route('exchange') }}" target="_blank">
                                    <div class="content-left">
                                        <h5>Exchanges</h5>
                                    </div>
                                </a>
                                <a href="{{ route('exchange.create') }}" target="_blank">
                                    <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-primary">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>


    <div class="card mt-3">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title mb-3">Summary</h4>
            <a href="#" class="btn btn-primary mb-2 text-nowrap" id="export-excel-btn">Export to Excel</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-lg-5">
                            <label class="form-label">Tills:</label>
                            <div wire:ignore>
                                <select
                                    wire:model="tillIds"
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
                            <div class="form-check form-switch m-2 d-flex justify-content-center">
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
        <div wire:loading wire:target="getReportData">
            @include('.components.spinner')
        </div>
        <div wire:loading.remove wire:target="getReportData" class="card-datatable table-responsive" style="height: {{ count($reportData) ? "750px" : "auto" }}">
            <table id="report-data-table" class="datatables-reportData table table-hover border-top table-bordered">
                <thead class="position-sticky top-0 bg-light border-white">
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
                                <th colspan="7" class="text-center">Totals From {{ \Carbon\Carbon::parse($startDate)->startOfMonth()->format('d-m-Y') }} To {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }}</th>
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
                                    {{ $data['date']->format('d/m/Y H:i') }}
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

                                            {{ number_format($data['amounts'][$currency->id]['debit'], 2) }} {{ $currency->name }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap text-center">
                                        @if(isset($data['amounts'][$currency->id]['credit']) && !empty($data['amounts'][$currency->id]['credit']))

                                            @php($totalCredits[$till->id][$currency->id] = ($totalCredits[$till->id][$currency->id] ?? 0) + $data['amounts'][$currency->id]['credit'])

                                            {{ number_format($data['amounts'][$currency->id]['credit'], 2) }} {{ $currency->name }}
                                        @endif
                                    </td>
                                    <td class="text-nowrap text-center">
                                        @if(isset($data['amounts'][$currency->id]['balance']))

                                            @php($balances[$till->id][$currency->id] = $data['amounts'][$currency->id]['balance'])

                                            {{ number_format($data['amounts'][$currency->id]['balance'], 2) }} {{ $currency->name }}
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

    <div wire.self:ignore class="modal fade" id="tillModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div>
                        <div>
                            <div class="text-center mb-4">
                                <h3 class="mb-2">{{ $selectedTill?->name }} / {{ $selectedTill?->user?->full_name }}</h3>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-4">
                                <div class="d-flex justify-content-center flex-grow-1">
                                    <div class="me-2">
                                        <p class="mb-0 text-dark">Name:</p>
                                        <p class="mb-0 text-muted">{{ $selectedTill?->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-center flex-grow-1">
                                    <div class="me-2">
                                        <p class="mb-0 text-dark">User:</p>
                                        <p class="mb-0 text-muted">{{ $selectedTill?->user?->full_name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-flex justify-content-center flex-grow-1">
                                    <div class="me-2">
                                        <p class="mb-0 text-dark">Created By:</p>
                                        <p class="mb-0 text-muted">{{ $selectedTill?->createdBy?->full_name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-5 table-responsive">
                                <table class="table border">
                                    <thead class="table-light">
                                    <tr class="text-nowrap">

                                        <th class="text-center">Currency</th>
                                        <th class="text-center">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($selectedTill?->tillAmounts ?? [] as $key => $tillAmount)
                                        <tr>

                                            <td class="text-center">
                                                {{ $tillAmount->currency?->name }}
                                            </td>
                                            <td class="text-center">
                                                {{ number_format($tillAmount->amount, 2) }} {{ $tillAmount->currency?->symbol }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="3">No till amounts available yet.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @script
    <script>
        Livewire.hook('request', ({ uri, options, payload, respond, succeed, fail }) => {
            succeed(({ status, json }) => {
                // $('#report-data-table').DataTable().order([[1, 'asc']]).draw();
            })
        })

        $wire.on('showModal', function () {
            $('#tillModal').modal('show')
        })

        $(document).ready(function(){
            function toggleCollapse() {
                if ($(window).width() < 768) {
                    $('#collapseExample').removeClass('show');
                } else {
                    $('#collapseExample').addClass('show');
                }
            }

            toggleCollapse();

            $(window).resize(function() {
                toggleCollapse();
            });
        });

        function exportToExcel() {
            const table = document.getElementById("report-data-table");
            const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet JS" });
            XLSX.writeFile(wb, "summary-report.xlsx");
        }

        $('#export-excel-btn').on('click', function() {
            exportToExcel();
        });

    </script>
    @endscript
</div>

