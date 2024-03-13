<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Transfer #{{ $transfer->id }}</h5>
                    <a href="{{ route('transfer') }}" class="btn btn-primary mb-2 text-nowrap">
                        Transfer
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">User:</span>
                            <span class="text-dark" id="user">{{ $transfer->user->full_name }} / {{ $transfer->user->username }}</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">From Till:</span>
                            <span class="text-dark" id="tillname">{{ $transfer->fromTill->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">To Till:</span>
                            <span class="text-dark" id="tillname">{{ $transfer->ToTill->name }}</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
            @foreach($transfer->transferAmounts as $key => $transferAmount)
                    <div class="col-12 col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Transfer Amount {{ $key + 1 }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 m-2">
                                        <span class="fw-bold text-dark">Currency:</span>
                                        <span class="text-dark">{{$transferAmount->currency->name}}</span>
                                    </div>
                                    <div class="col-12 m-2">
                                        <span class="fw-bold text-dark">Amount :</span>
                                        <span class="text-dark">{{ number_format($transferAmount->amount) }} {{$transferAmount->currency->symbol}}</span>
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
