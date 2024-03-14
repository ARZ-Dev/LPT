<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Monthly Opening/Closing #{{ $monthlyEntry->id }}</h5>
                    <a href="{{ route('monthlyEntry') }}" class="btn btn-primary mb-2 text-nowrap">
                        Monthly Opening/Closing
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mt-5">
                        <div class="col-12 col-md-4">
                            <span class="fw-bold text-dark">User:</span>
                            <span class="text-dark" id="user">{{ $monthlyEntry->user?->full_name }} / {{ $monthlyEntry->user?->username }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="fw-bold text-dark">Till Name:</span>
                            <span class="text-dark" id="tillname">{{ $monthlyEntry->till?->name }} / {{ $monthlyEntry->till?->user?->full_name }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="fw-bold text-dark">Month:</span>
                            <span class="text-dark" id="open_date">{{ Carbon\Carbon::parse($monthlyEntry->open_date)->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
            @foreach($monthlyEntry->monthlyEntryAmounts as $key => $monthlyEntryAmount)
                    <div class="col-12 col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Monthly Amount {{ $key + 1 }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                <div class="col-12 m-2">
                                    <span class="fw-bold text-dark">Currency:</span>
                                    <span class="text-dark">{{$monthlyEntryAmount->currency->name}}</span>
                                </div>

                                <div class="col-12 m-2">
                                    <span class="fw-bold text-dark">Opening Amount: </span>
                                    <span class="text-dark">{{ number_format($monthlyEntryAmount->amount, 2) }} {{ $monthlyEntryAmount->currency->symbol }}</span>
                                </div>

                                <div class="col-12 m-2">
                                    <span class="fw-bold text-dark">Closing Amount:</span>
                                    <span class="text-dark">
                                        @if($monthlyEntryAmount->closing_amount)
                                            {{ number_format($monthlyEntryAmount->closing_amount, 2) }} {{ $monthlyEntryAmount->currency->symbol }}
                                        @endif
                                    </span>
                                </div>

                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
            </div>

        </div>
    </div>

    @script
    <script>
        document.addEventListener('livewire:navigated', function () {
            var status={{$status}};
            if (status=="1") {$('input').prop('disabled', true);}
        });

        triggerCleave()
        $('.selectpicker').selectpicker();

        Livewire.hook('morph.added', ({ el }) => {
            $('.selectpicker').selectpicker();
            triggerCleave()
        })

        $(document).on('change', '.currency', function() {
            @this.set($(this).attr('wire:model'), $(this).val())
        })
    </script>
    @endscript
</div>
