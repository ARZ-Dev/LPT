<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Exchange #{{ $exchange->id }}</h5>
                    <a href="{{ route('exchange') }}" class="btn btn-primary mb-2 text-nowrap">
                        Exchange
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">User:</span>
                            <span class="text-dark" id="user">{{ $exchange->user->full_name }}</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Till Name:</span>
                            <span class="text-dark" id="symbol">{{ $exchange->till->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">From:</span>
                            <span class="text-dark" id="name">{{ $exchange->fromCurrency->name }} / {{ $exchange->fromCurrency->symbol }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">To:</span>
                            <span class="text-dark" id="name">{{ $exchange->toCurrency->name }} / {{ $exchange->toCurrency->symbol }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Amount:</span>
                            <span class="text-dark" id="name">{{ $exchange->amount }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Rate:</span>
                            <span class="text-dark" id="name">{{ $exchange->rate }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Result:</span>
                            <span class="text-dark" id="name">{{ $exchange->result }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Description:</span>
                            <span class="text-dark" id="name">{{ $exchange->description }}</span>
                        </div>
                    </div>
                </div>
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