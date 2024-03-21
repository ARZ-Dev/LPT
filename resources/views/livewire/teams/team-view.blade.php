<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Team #{{ $team->id }}</h5>
                    <a href="{{ route('teams') }}" class="btn btn-primary mb-2 text-nowrap">
                        Teams
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Team:</span>
                            <span class="text-dark" >{{ $team->nickname }} </span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Level Category:</span>
                            <span class="text-dark" >{{ $team->levelCategory?->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Players List</h5>
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
                                            <th>Player</th>
                                            <th>Playing Side</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($team->players as $key => $player)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td class="text-center">{{ $player->full_name }}</td>
                                            <td class="text-center">{{ $player->playing_side }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No players available.</td>
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
