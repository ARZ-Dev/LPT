<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Currency #{{ $currency->id }}</h5>
                    <a href="{{ route('currency') }}" class="btn btn-primary mb-2 text-nowrap">
                        Currencies
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mt-5">
                        <div class="col-12 col-md-4">
                            <span class="fw-bold text-dark">User:</span>
                            <span class="text-dark" id="user">{{ $currency->user?->full_name }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="fw-bold text-dark">Symbol:</span>
                            <span class="text-dark" id="symbol">{{ $currency->symbol }}</span>
                        </div>
                        <div class="col-12 col-md-4">
                            <span class="fw-bold text-dark">Name:</span>
                            <span class="text-dark" id="name">{{ $currency->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @script
    <script>

    </script>
    @endscript
</div>
