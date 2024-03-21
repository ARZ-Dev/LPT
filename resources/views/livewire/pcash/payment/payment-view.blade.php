<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Payment #{{ $payment->id }}</h5>
                    <a href="{{ route('payment') }}" class="btn btn-primary mb-2 text-nowrap">
                        Payments
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Created By:</span>
                            <span class="text-dark" id="user">{{ $payment->user?->full_name }} / {{ $payment->user?->username }}</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Till Name:</span>
                            <span class="text-dark" id="tillname">{{ $payment->till?->name }} / {{ $payment->till?->user?->full_name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Category:</span>
                            <span class="text-dark" id="category">{{ $payment->category?->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Sub Category:</span>
                            <span class="text-dark" id="sub_category">{{ $payment->subCategory?->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Paid To:</span>
                            <span class="text-dark" id="paid_to">{{ $payment->paid_to }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Description:</span>
                            <span class="text-dark" id="description">{{ $payment->description }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($payment->paymentAmounts as $key => $paymentAmount)
                        <div class="col-12 col-md-4">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Payment Amount {{ $key + 1 }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 m-2">
                                            <span class="fw-bold text-dark">Currency: </span>
                                            <span class="text-dark">{{$paymentAmount->currency?->name}} </span><br>
                                        </div>
                                        <div class="col-12 m-2">
                                            <span class="fw-bold text-dark">Amount :</span>
                                            <span class="text-dark">{{ number_format($paymentAmount->amount, 2) }} {{$paymentAmount->currency?->symbol}}</span><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>

            @if($this->invoice)
                <div class="card mb-4 mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            Invoice Upload - <a href="{{ asset(\Illuminate\Support\Facades\Storage::url($this->invoice)) }}" download>Download Link</a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                @php
                                    $uploadedFile = [asset(\Illuminate\Support\Facades\Storage::url($this->invoice))];
                                @endphp
                                <x-filepond :files="$uploadedFile" wire:model="invoice" delete-event="deleteInvoice" allow-remove="false" />
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    @script
    <script>

    </script>
    @endscript
</div>
