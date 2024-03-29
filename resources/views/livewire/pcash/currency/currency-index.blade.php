<div>

<div class="col-md-12 col-12 mb-md-0 mb-4">
    <div class="d-flex justify-content-between">
        <h4 class="fw-semibold">Currencies List Order</h4>
        @can('currency-create')
        <a class="btn btn-primary h-50 mb-4" href="{{ route('currency.create') }}">Add Currency</a>
        @endcan
    </div>

    <ul class="list-group drag-and-drop-lists bg-white" id="row-list">
        @foreach($currencies as $currency)
            <li class="list-group-item drag-item cursor-move d-flex justify-content-between align-items-center" ondblclick="move(this)">
                <input type="hidden" value="{{ $currency->id }}">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-sm me-3">
                        <span class="avatar-initial rounded-circle bg-label-primary order-number" >{{ $currency->list_order }}</span>
                    </div>
                </div>
                <span>{{ $currency->name }} - {{ $currency->symbol }}</span>
                <div>
                    @can('currency-view')
                        <a href="{{ route('currency.view', ['id' => $currency->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                    @endcan
                    @can('currency-edit')
                        <a href="{{ route('currency.edit', $currency->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm"></i></a>
                    @endcan
                    @can('currency-delete')
                        <a href="#" class="text-body delete-record delete-button" data-id="{{ $currency->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                    @endcan
                </div>
            </li>
        @endforeach
    </ul>
</div>


    @script
        @include('livewire.deleteConfirm')
    @endscript


    @script
    <script>
        const rowList = document.getElementById('row-list');

        $(document).ready(function () {
            if (rowList) {
                Sortable.create(rowList, {
                    animation: 150,
                    group: 'taskList',
                    onEnd: updateOrder
                });
            }
        });

        function updateOrder() {
            const currencies = Array.from(rowList.children);
            updateCurrenciesOrder(currencies);
        }

        function updateCurrenciesOrder(currencies) {
            currenciesOrder = [];
            currencies.forEach((supervisor, index) => {
                const input = supervisor.querySelector('input')
                currenciesOrder[index] = input.value;
                const orderSpan = supervisor.querySelector('.order-number');
                orderSpan.textContent = `${index + 1}`;
            });
            $wire.dispatch('updateOrder', { currenciesOrder })
        }

    </script>
    @endscript



</div>

