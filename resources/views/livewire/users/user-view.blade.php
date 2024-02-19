<body>
    <!-- Users List Table -->
    <div wire:ignore class="card">
        <div class="card-header border-bottom">
            <h4 class="card-title mb-3">Users List</h4>
            <div class="d-flex justify-content-between align-items-center row pb-2 gap-3 gap-md-0">
                <div class="col-md-4 user_role"></div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top">
                <thead>
                 <tr>
                    <th></th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:navigated', function () {
            var dt_user_table = $('.datatables-users')

            var users = @json($users ?? []);
            if (dt_user_table.length) {
                var dt_user = dt_user_table.DataTable({
                    data: users,
                    columns: [
                        // columns according to JSON
                        { data: '' },
                        { data: 'full_name' },
                        { data: 'role' },
                        { data: 'username' },
                        { data: 'email' },
                        { data: 'phone' },
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
                            // User full name and email
                            targets: 1,
                            responsivePriority: 4,
                            render: function (data, type, full, meta) {
                                var $name = full['full_name'],
                                    $email = full['email'],
                                    $image = full['avatar'];
                                if ($image) {
                                    // For Avatar image
                                    var $output =
                                        '<img src="' + assetsPath + 'img/avatars/' + $image + '" alt="Avatar" class="rounded-circle">';
                                } else {
                                    // For Avatar badge
                                    var stateNum = Math.floor(Math.random() * 10);
                                    var states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'];
                                    var $state = states[stateNum],
                                        $initials = $name.match(/\b\w/g) || [];
                                    $initials = (($initials.shift() || '') + ($initials.pop() || '')).toLowerCase();
                                    $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
                                }
                                // Creates full output for row
                                var $row_output =
                                    '<div class="d-flex justify-content-start align-items-center user-name">' +
                                    '<div class="avatar-wrapper">' +
                                    '<div class="avatar avatar-sm me-3">' +
                                    $output +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="d-flex flex-column">' +
                                    '<a href="#" class="text-body text-truncate"><span class="fw-semibold">' +
                                    $name +
                                    '</span></a>' +
                                    '<small class="text-muted">' +
                                    $email +
                                    '</small>' +
                                    '</div>' +
                                    '</div>';
                                return $row_output;
                            }
                        },
                        {
                            // User Role
                            targets: 2,
                            render: function (data, type, full, meta) {
                                var $role = full['role'];
                                var $othersBadge = '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="ti ti-chart-pie-2 ti-sm"></i></span>';
                                var roleBadgeObj = {
                                    '3': $othersBadge,
                                    '2': '<span class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2"><i class="ti ti-edit ti-sm"></i></span>',
                                    '1': '<span class="badge badge-center rounded-pill bg-label-danger w-px-30 h-px-30 me-2"><i class="ti ti-device-laptop ti-sm"></i></span>',
                                };
                                return "<span class='text-truncate d-flex align-items-center'>" + (roleBadgeObj[full['role_id']] ?? $othersBadge) + $role + '</span>';
                            }
                        },
                        {
                            // Username
                            targets: 3,
                            render: function (data, type, full, meta) {
                                var $username = full['username'];

                                return '<span class="fw-semibold">' + $username + '</span>';
                            }
                        },
                        {
                            // User Email
                            targets: 4,
                            render: function (data, type, full, meta) {
                                var $email = full['email'];

                                return '<span class="fw-semibold">' + $email + '</span>';
                            }
                        },
                        {
                            // User Phone
                            targets: 5,
                            render: function (data, type, full, meta) {
                                var $phone = full['phone'];

                                return '<span class="fw-semibold">' + $phone + '</span>';
                            }
                        },
                        {
                            // Actions
                            targets: -1,
                            title: 'Actions',
                            searchable: false,
                            orderable: false,
                            render: function (data, type, full, meta) {
                                let editLink = "{{ route('users.edit', '%id%') }}".replace('%id%', full['id']);
                                let viewLink = "{{ route('users.view', ['id' => '%id%', 'status' => '%status%']) }}".replace('%id%', full['id']).replace('%status%', 1);


                                return (
                                    '<div class="d-flex align-items-center">' +
                                    @can('user-list')
                                    '<a href="'+ viewLink +'" class="text-body view-user-button"><i class="ti ti-eye ti-sm me-2"></i></a>' +
                                    @endcan
                                    @can('user-edit')
                                    '<a href="'+ editLink +'" class="text-body edit-user-button"><i class="ti ti-edit ti-sm me-2"></i></a>' +
                                    @endcan
                                    @can('user-delete')
                                    '<a href="#" class="text-body delete-record delete-button" data-id="'+ full['id'] +'"><i class="ti ti-trash ti-sm mx-2 text-danger"></i></a>' +
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
                                'data-href': "{{ route('users.create') }}",
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
                window.livewire.emit('deleteConfirm', 'delete', id);
            })

            $(document).on('click', '.add-new-button', function () {
                window.location.href = $(this).data('href');
            })
        })

    </script>

    </body>

