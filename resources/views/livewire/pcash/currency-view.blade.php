<div>

    {{-- <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">Currencies List</h4>
            <a class="btn btn-primary h-50" href="{{ route('currency.create') }}">Add Currency</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-currency dataTable table border-top">
                <thead>
                 <tr>
                    <th>name</th>
                    <th>Symbol</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($currencies as $currency)
                    <tr>
                        <td>{{ $currency->name }}</td>
                        <td>{{ $currency->symbol }}</td>
                        <td>{{ $currency->created_at->format('d-m-Y h:i a') }}</td>
                        <td>
                            @can('currency-list')
                                <a href="{{ route('currency.view', ['id' => $currency->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                            @endcan
                            @can('currency-edit')
                                <a href="{{ route('currency.edit', $currency->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                            @endcan
                            @can('currency-delete')
                                <a href="#" class="text-body delete-record delete-button" data-id="{{ $currency->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    @script
        @include('livewire.deleteConfirm')
    @endscript --}}










<style>
    .table {
    border: 1px solid #ccc;
    border-collapse: collapse;
    }
    .table th,
    .table td {
    border: 1px solid #ccc;
    }
    .table th,
    .table td {
    padding: 0.5rem;
    }
    .draggable {
    cursor: move;
    user-select: none;
    }
    .placeholder {
    background-color: #edf2f7;
    border: 2px dashed #cbd5e0;
    }
    .clone-list {
    border-top: 1px solid #ccc;
    }
    .clone-table {
    border-collapse: collapse;
    border: none;
    }
    .clone-table th,
    .clone-table td {
    border: 1px solid #ccc;
    border-top: none;
    padding: 0.5rem;
    }
    .dragging {
    background: #fff;
    border-top: 1px solid #ccc;
    z-index: 999;
    }
</style>
<div style="padding: 4rem 0">
    <div class="card-header border-bottom d-flex justify-content-between">
        <h4 class="card-title mb-3">Currencies List</h4>
        <a class="btn btn-primary h-50" href="{{ route('currency.create') }}">Add Currency</a>
    </div>
    <table id="table" class="table datatable" style="background-color:white;">
        <thead>
            <tr>
                <th>name</th>
                <th>Symbol</th>
                <th>List order</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($currencies->sortBy('list_order') as $currency)
                <tr>
                    <td>{{ $currency->name }}</td>
                    <td>{{ $currency->symbol }}</td>
                    <td>{{ $currency->list_order }}</td>
                    <td>{{ $currency->created_at->format('d-m-Y h:i a') }}</td>
                    <td>
                        @can('currency-list')
                            <a href="{{ route('currency.view', ['id' => $currency->id, 'status' => '1']) }}" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>
                        @endcan
                        @can('currency-edit')
                            <a href="{{ route('currency.edit', $currency->id) }}" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>
                        @endcan
                        @can('currency-delete')
                            <a href="#" class="text-body delete-record delete-button" data-id="{{ $currency->id }}"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
    </table>
</div>


<button class="btn btn-primary h-50" wire:click="store">Save List Order</button>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('table');

    let draggingEle;
    let draggingRowIndex;
    let placeholder;
    let list;
    let isDraggingStarted = false;

    // The current position of mouse relative to the dragging element
    let x = 0;
    let y = 0;

    // Swap two nodes
    const swap = function (nodeA, nodeB) {
        const parentA = nodeA.parentNode;
        const siblingA = nodeA.nextSibling === nodeB ? nodeA : nodeA.nextSibling;

        // Move nodeA to before the nodeB
        nodeB.parentNode.insertBefore(nodeA, nodeB);

        // Move nodeB to before the sibling of nodeA
        parentA.insertBefore(nodeB, siblingA);
    };

    // Check if nodeA is above nodeB
    const isAbove = function (nodeA, nodeB) {
        // Get the bounding rectangle of nodes
        const rectA = nodeA.getBoundingClientRect();
        const rectB = nodeB.getBoundingClientRect();

        return rectA.top + rectA.height / 2 < rectB.top + rectB.height / 2;
    };

    const cloneTable = function () {
        const rect = table.getBoundingClientRect();
        const width = parseInt(window.getComputedStyle(table).width);

        list = document.createElement('div');
        list.classList.add('clone-list');
        list.style.position = 'absolute';
        list.style.left = rect.left + 'px';
        list.style.top = rect.top + 'px';
        table.parentNode.insertBefore(list, table);

        // Hide the original table
        table.style.visibility = 'hidden';

        table.querySelectorAll('tr').forEach(function (row) {
            // Create a new table from given row
            const item = document.createElement('div');
            item.classList.add('draggable');

            const newTable = document.createElement('table');
            newTable.setAttribute('class', 'clone-table');
            newTable.style.width = width + 'px';

            const newRow = document.createElement('tr');
            const cells = [].slice.call(row.children);
            cells.forEach(function (cell) {
                const newCell = cell.cloneNode(true);
                newCell.style.width = parseInt(window.getComputedStyle(cell).width) + 'px';
                newRow.appendChild(newCell);
            });

            newTable.appendChild(newRow);
            item.appendChild(newTable);
            list.appendChild(item);
        });
    };

    const mouseDownHandler = function (e) {
        // Get the original row
        const originalRow = e.target.parentNode;
        draggingRowIndex = [].slice.call(table.querySelectorAll('tr')).indexOf(originalRow);

        // Determine the mouse position
        x = e.clientX;
        y = e.clientY;

        // Attach the listeners to document
        document.addEventListener('mousemove', mouseMoveHandler);
        document.addEventListener('mouseup', mouseUpHandler);
    };

    const mouseMoveHandler = function (e) {
        if (!isDraggingStarted) {
            isDraggingStarted = true;

            cloneTable();

            draggingEle = [].slice.call(list.children)[draggingRowIndex];
            draggingEle.classList.add('dragging');

            // Let the placeholder take the height of dragging element
            // So the next element won't move up
            placeholder = document.createElement('div');
            placeholder.classList.add('placeholder');
            draggingEle.parentNode.insertBefore(placeholder, draggingEle.nextSibling);
            placeholder.style.height = draggingEle.offsetHeight + 'px';
        }

        // Set position for dragging element
        draggingEle.style.position = 'absolute';
        draggingEle.style.top = (draggingEle.offsetTop + e.clientY - y) + 'px';
        draggingEle.style.left = (draggingEle.offsetLeft + e.clientX - x) + 'px';

        // Reassign the position of mouse
        x = e.clientX;
        y = e.clientY;

        // The current order
        // prevEle
        // draggingEle
        // placeholder
        // nextEle
        const prevEle = draggingEle.previousElementSibling;
        const nextEle = placeholder.nextElementSibling;

        // The dragging element is above the previous element
        // User moves the dragging element to the top
        // We don't allow to drop above the header
        // (which doesn't have previousElementSibling)
        if (prevEle && prevEle.previousElementSibling && isAbove(draggingEle, prevEle)) {
            // The current order    -> The new order
            // prevEle              -> placeholder
            // draggingEle          -> draggingEle
            // placeholder          -> prevEle
            swap(placeholder, draggingEle);
            swap(placeholder, prevEle);
            return;
        }

        if (nextEle && isAbove(nextEle, draggingEle)) {
            // The current order    -> The new order
            // draggingEle          -> nextEle
            // placeholder          -> placeholder
            // nextEle              -> draggingEle
            swap(nextEle, placeholder);
            swap(nextEle, draggingEle);
        }
    };

    const mouseUpHandler = function () {
        // Remove the placeholder
        placeholder && placeholder.parentNode.removeChild(placeholder);

        draggingEle.classList.remove('dragging');
        draggingEle.style.removeProperty('top');
        draggingEle.style.removeProperty('left');
        draggingEle.style.removeProperty('position');

        // Get the end index
        const endRowIndex = [].slice.call(list.children).indexOf(draggingEle);

        isDraggingStarted = false;

        // Remove the list element
        list.parentNode.removeChild(list);

        // Move the dragged row to endRowIndex
        let rows = [].slice.call(table.querySelectorAll('tr'));
        draggingRowIndex > endRowIndex
            ? rows[endRowIndex].parentNode.insertBefore(rows[draggingRowIndex], rows[endRowIndex])
            : rows[endRowIndex].parentNode.insertBefore(
                    rows[draggingRowIndex],
                    rows[endRowIndex].nextSibling
                );

        // Bring back the table
        table.style.removeProperty('visibility');

        // Remove the handlers of mousemove and mouseup
        document.removeEventListener('mousemove', mouseMoveHandler);
        document.removeEventListener('mouseup', mouseUpHandler);
    };

    table.querySelectorAll('tr').forEach(function (row, index) {
        // Ignore the header
        // We don't want user to change the order of header
        if (index === 0) {
            return;
        }

        const firstCell = row.firstElementChild;
        firstCell.classList.add('draggable');
        firstCell.addEventListener('mousedown', mouseDownHandler);
    });
});







</script>

@script
        @include('livewire.deleteConfirm')
@endscript

</div>

