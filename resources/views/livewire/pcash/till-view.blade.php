<body>
   
    <div wire:ignore class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title mb-3">Till</h4>
            <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-till table border-top">
                <thead>
                 <tr>
                    <th></th>

                    <th>UserName</th>
                    <th>till name</th>
                    <!-- <th>usd opening</th>
                    <th>lbp opening</th> -->

                    <th>Created At</th>

    
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    @script
    <script>
        document.addEventListener('livewire:navigated', function () {
            var dt_till_table = $('.datatables-till')

            var till = @json($till ?? []);
            if (dt_till_table.length) {
                var dt_till = dt_till_table.DataTable({
                    data: till,
                    columns: [
                        { data: '' },

                        { data: 'user_id' },
                        { data: 'name' },
                        // { data: 'usd_opening' },
                        // { data: 'lbp_opening' },

                        { data: 'created_at' },

                        { data: 'action' }
                    ],
                    columnDefs: [
                        {
                            // For Responsive
                            className: 'control',
                            searchable: false,
                            orderable: false,
                            responsivePriority: 2,
                            targets: 0,
                            render: function (data, type, full, meta) {
                                return '';
                            }
                        },
                        
                        {
                           
                            targets: 1,
                            render: function (data, type, full, meta) {
                                var $user_id = full['user']['username'];

                                return '<span class="fw-semibold">' + $user_id + '</span>';
                            }
                        },
                        {
                           
                           targets: 2,
                           render: function (data, type, full, meta) {
                               var $name = full['name'];

                               return '<span class="fw-semibold">' + $name + '</span>';
                           }
                       },
                    //    {
                           
                    //        targets: 3,
                    //        render: function (data, type, full, meta) {
                    //            var $usd_opening = full['usd_opening'];

                    //            return '<span class="fw-semibold">' + $usd_opening + '</span>';
                    //        }
                    //    },
                    //    {
                           
                    //        targets: 4,
                    //        render: function (data, type, full, meta) {
                    //            var $lbp_opening = full['lbp_opening'];

                    //            return '<span class="fw-semibold">' + $lbp_opening + '</span>';
                    //        }
                    //    },
                        {
                            targets: 3,
                            render: function (data, type, full, meta) {
                                var created_at = full['created_at'];

                                var date = new Date(created_at);

                                var formattedDate = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + ' ' + ('0' + date.getHours()).slice(-2) + ':' + ('0' + date.getMinutes()).slice(-2) + ' ' + (date.getHours() >= 12 ? 'pm' : 'am');
                                
                                return '<span class="fw-semibold">' + formattedDate + '</span>';
                            }
                        },

                        {
                            // Actions
                            targets: -1,
                            title: 'Actions',
                            searchable: false,
                            orderable: false,
                            render: function (data, type, full, meta) {
                                let editLink = "{{ route('till.edit', '%id%') }}".replace('%id%', full['id']);
                                let viewLink = "{{ route('till.view', ['id' => '%id%', 'status' => '%status%']) }}".replace('%id%', full['id']).replace('%status%', 1);


                                return (
                                    '<div class="d-flex align-items-center">' +
                                    @can('till-list')
                                    '<a href="'+ viewLink +'" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>' +
                                    @endcan
                                    @can('till-edit')
                                    '<a href="'+ editLink +'" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>' +
                                    @endcan
                                    @can('till-delete')
                                    '<a wire:click="delete(' + full['id'] + ')" href="#" class="text-body delete-record delete-button" data-id="'+ full['id'] +'"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>' +
                                    @endcan
                                    '</div>'
                                );
                            }
                        }
                    ],
                    order: [[1, 'desc']],
                    dom:
                        '<"row me-2"' +
                        '<"col-md-2"<"me-3"l>>' +
                        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                        '>t' +
                        '<"row mx-2"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        '>',
                    language: {
                        sLengthMenu: '_MENU_',
                        search: '',
                        searchPlaceholder: 'Search..'
                    },
                    // Buttons with Dropdown
                    buttons: [
                        {
                            extend: 'collection',
                            className: 'btn btn-label-secondary dropdown-toggle mx-3',
                            text: '<i class="ti ti-screen-share me-1 ti-xs"></i>Export',
                            buttons: [
                                {
                                    extend: 'print',
                                    text: '<i class="ti ti-printer me-2" ></i>Print',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [1, 2, 3, 4, 5],
                                        // prevent avatar to be print
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    },
                                    customize: function (win) {
                                        //customize print view for dark
                                        $(win.document.body)
                                            .css('color', headingColor)
                                            .css('border-color', borderColor)
                                            .css('background-color', bodyBg);
                                        $(win.document.body)
                                            .find('table')
                                            .addClass('compact')
                                            .css('color', 'inherit')
                                            .css('border-color', 'inherit')
                                            .css('background-color', 'inherit');
                                    }
                                },
                                {
                                    extend: 'csv',
                                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [1, 2, 3, 4, 5],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'excel',
                                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [1, 2, 3, 4, 5],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: '<i class="ti ti-file-code-2 me-2"></i>Pdf',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [1, 2, 3, 4, 5],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                },
                                {
                                    extend: 'copy',
                                    text: '<i class="ti ti-copy me-2" ></i>Copy',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [1, 2, 3, 4, 5],
                                        // prevent avatar to be display
                                        format: {
                                            body: function (inner, coldex, rowdex) {
                                                if (inner.length <= 0) return inner;
                                                var el = $.parseHTML(inner);
                                                var result = '';
                                                $.each(el, function (index, item) {
                                                    if (item.classList !== undefined && item.classList.contains('user-name')) {
                                                        result = result + item.lastChild.firstChild.textContent;
                                                    } else if (item.innerText === undefined) {
                                                        result = result + item.textContent;
                                                    } else result = result + item.innerText;
                                                });
                                                return result;
                                            }
                                        }
                                    }
                                }
                            ]
                        },
                        @can('user-create')
                        {
                            text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Add New User</span>',
                            className: 'add-new btn btn-primary add-new-button',
                            attr: {
                                'data-href': "{{ route('till.create') }}",
                            }
                        }
                        @endcan
                    ],
                    // For responsive popup
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function (row) {
                                    var data = row.data();
                                    return 'Details of ' + data['full_name'];
                                }
                            }),
                            type: 'column',
                            renderer: function (api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ? '<tr data-dt-row="' +
                                        col.rowIndex +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>'
                                        : '';
                                }).join('');

                                return data ? $('<table class="table"/><tbody />').append(data) : false;
                            }
                        }
                    },
                    initComplete: function () {
                        // Adding role filter once table initialized
                        this.api()
                            .columns(2)
                            .every(function () {
                                var column = this;
                                var select = $(
                                    '<select id="UserRole" class="form-select text-capitalize"><option value=""> Filter by Role </option></select>'
                                )
                                    .appendTo('.user_role')
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                                    });

                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        select.append('<option value="' + d + '">' + d + '</option>');
                                    });
                            });

                    }
                });
            }

            $(document).on('click', '.delete-button', function () {
                const id = $(this).data('id');
                $wire.dispatch('deleteConfirm', {
                    method: "delete",
                    id: id,
                });
            })

            $(document).on('click', '.add-new-button', function () {
                window.location.href = $(this).data('href');
            })
        })

    </script>
    @endscript

    </body>

