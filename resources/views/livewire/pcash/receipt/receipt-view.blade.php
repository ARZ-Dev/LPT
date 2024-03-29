<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Receipt #{{ $receipt->id }}</h5>
                    <a href="{{ route('receipt') }}" class="btn btn-primary mb-2 text-nowrap">
                        Receipts
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Created By:</span>
                            <span class="text-dark" id="user">{{ $receipt->user?->full_name }} / {{ $receipt->user?->username }}</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Till Name:</span>
                            <span class="text-dark" id="till_name">{{ $receipt->till?->name }} / {{ $receipt->till?->user?->full_name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Category:</span>
                            <span class="text-dark" id="category">{{ $receipt->category?->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Sub Category:</span>
                            <span class="text-dark" id="sub_category">{{ $receipt->subCategory?->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Paid By:</span>
                            <span class="text-dark" id="sub_category">{{ $receipt->paid_by }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Description:</span>
                            <span class="text-dark" id="description">{{ $receipt->description }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
            @foreach($receipt->receiptAmounts as $key => $receiptAmount)
                    <div class="col-12 col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Receipt Amount {{ $key + 1 }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 m-2">
                                        <span class="fw-bold text-dark">Currency:</span>
                                        <span class="text-dark">{{$receiptAmount->currency?->name}}</span>
                                    </div>
                                    <div class="col-12 m-2">
                                        <span class="fw-bold text-dark">Amount :</span>
                                        <span class="text-dark">{{ number_format($receiptAmount->amount, 2) }} {{$receiptAmount->currency?->symbol}}</span>
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

    </script>
    @endscript
</div>
