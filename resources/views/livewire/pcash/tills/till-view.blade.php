<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Till #{{ $till->id }}</h5>
                    <a href="{{ route('till') }}" class="btn btn-primary mb-2 text-nowrap">
                        Tills
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Created By:</span>
                            <span class="text-dark" id="user">{{ $till->createdBy->full_name }}</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Name:</span>
                            <span class="text-dark" id="name">{{ $till->name }} / {{ $till->user?->full_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            @foreach($tillAmounts as $key => $tillAmount)
                    <div class="col-12 col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Till Amount {{ $key + 1 }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 m-2">
                                        <span class="fw-bold text-dark">Currency:</span>
                                        <span class="text-dark">{{ $tillAmount['currency_name'] }}</span>
                                    </div>

                                    <div class="col-12 m-2">
                                        <span class="fw-bold text-dark">Amount:</span>
                                        <span class="text-dark">{{ $tillAmount['amount'] }} {{ $tillAmount['currency']?->symbol }}</span>
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
