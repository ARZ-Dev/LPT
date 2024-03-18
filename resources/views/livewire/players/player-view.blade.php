<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Player #{{ $player->id }}</h5>
                    <a href="{{ route('players') }}" class="btn btn-primary mb-2 text-nowrap">
                        Players
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Player Name:</span>
                            <span class="text-dark" >{{ $player->first_name }} {{ $player->middle_name }} {{ $player->last_name }} </span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Current Team:</span>
                            <span class="text-dark" >{{ $player->currentTeam?->nickname }} </span>
                        </div>

                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Birthdate:</span>
                            <span class="text-dark" >{{ $player->birthdate }}</span>
                        </div>

                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Email:</span>
                            <span class="text-dark" >{{ $player->email }}</span>
                        </div>

                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Phone Number:</span>
                            <span class="text-dark" >{{ $player->phone_number }}</span>
                        </div>

                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Country:</span>
                            <span class="text-dark" >{{ $player->country->name }}</span>
                        </div>

                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Nickname:</span>
                            <span class="text-dark" >{{ $player->nickname }}</span>
                        </div>

                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Playing Side:</span>
                            <span class="text-dark" >{{ $player->playing_side }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Teams List</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2"></div>
                        <div class="col-8">
                            <div class="col-12 table-responsive">
                                <table class="table border border-1 table-striped">
                                    <thead class="table-light text-center">
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Team</th>
                                        <th>Level Category</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($player->teams as $key => $team)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ $team->nickname }}</td>
                                            <td class="text-center">{{ $team->levelCategory?->name }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No teams available.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
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
