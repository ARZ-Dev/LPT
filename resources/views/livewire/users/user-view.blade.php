<body>
    <!-- Users List Table -->
    <div class="card">
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
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th></th>
                        <th>{{ $user->full_name }}</th>
                        <th>{{ $user->roles[0]->name ?? 'No Role' }}</th>
                        <th>{{ $user->username }}</th>
                        <th>{{ $user->email }}</th>
                        <th>{{ $user->phone }}</th>
                        <th>Actions</th>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        {{ $users->links(data: ['scrollTo' => false]) }}
    </div>

    @script
    <script>
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

    </script>
    @endscript

    </body>

