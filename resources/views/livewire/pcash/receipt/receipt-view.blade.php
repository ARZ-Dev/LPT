<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Receipt #{{ $receipt->id }}</h5>
                    <div>
                        <a href="#" class="btn btn-primary mb-2 text-nowrap" id="print-receipt">Print</a>
                        <a href="{{ route('receipt') }}" class="btn btn-primary mb-2 text-nowrap">
                            Receipts
                        </a>
                    </div>
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
                        @if($receipt->tournament)
                            <div class="col-12 col-md-6 mt-5">
                                <span class="fw-bold text-dark">Tournament:</span>
                                <span class="text-dark" id="category">{{ $receipt->tournament?->name }}</span>
                            </div>
                        @endif
                        @if($receipt->team)
                            <div class="col-12 col-md-6 mt-5">
                                <span class="fw-bold text-dark">Team:</span>
                                <span class="text-dark" id="sub_category">{{ $receipt->team?->nickname }}</span>
                            </div>
                        @endif
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
           $('#print-receipt').on('click', function() {

           var printWindow = window.open('', '_blank');

           printWindow.document.write('<html><head><title>Receipt #{{ $receipt->id }}</title>');
           printWindow.document.write('<style>');
           printWindow.document.write('body { font-family: Arial, sans-serif; font-size: 14px; }');
           printWindow.document.write('.invoice { border: 1px solid #ccc; padding: 20px; margin: 20px; }');
           printWindow.document.write('.invoice h1 { font-size: 24px; margin-bottom: 20px; }');
           printWindow.document.write('.invoice span { display: block; margin-bottom: 10px; }');
           printWindow.document.write('.invoice .fw-bold { font-weight: bold; }');
           printWindow.document.write('</style>');
           printWindow.document.write('</head><body>');

           printWindow.document.write('<div class="invoice">');
           printWindow.document.write('<h1>Receipt #{{ $receipt->id }}</h1>');
           printWindow.document.write('<span class="fw-bold">Created By:</span>');
           printWindow.document.write('<span>{{ $receipt->user?->full_name }} / {{ $receipt->user?->username }}</span>');
           printWindow.document.write('<span class="fw-bold">Till Name:</span>');
           printWindow.document.write('<span>{{ $receipt->till?->name }} / {{ $receipt->till?->user?->full_name }}</span>');
           printWindow.document.write('<span class="fw-bold">Category:</span>');
           printWindow.document.write('<span>{{ $receipt->category?->name }}</span>');
           printWindow.document.write('<span class="fw-bold">Sub Category:</span>');
           printWindow.document.write('<span>{{ $receipt->subCategory?->name }}</span>');
           printWindow.document.write('<span class="fw-bold">Paid By:</span>');
           printWindow.document.write('<span>{{ $receipt->paid_by }}</span>');
           printWindow.document.write('<span class="fw-bold">Description:</span>');
           printWindow.document.write('<span>{{ $receipt->description }}</span>');

           @foreach($receipt->receiptAmounts as $key => $receiptAmount)
                printWindow.document.write('<h1></h1>');
                printWindow.document.write('<h1>Receipt Amount {{ $key + 1 }}</h1>');
                printWindow.document.write('<span class="fw-bold">Currency:</span>');
                printWindow.document.write('<span>{{$receiptAmount->currency?->name}}</span>');
                printWindow.document.write('<span class="fw-bold">Amount:</span>');
                printWindow.document.write('<span>{{ number_format($receiptAmount->amount, 2) }} {{$receiptAmount->currency?->symbol}}</span>');
            @endforeach


           printWindow.document.write('</div>');

           printWindow.document.write('</body></html>');
           printWindow.document.close();

           printWindow.print();
          });

    </script>
    @endscript
</div>
