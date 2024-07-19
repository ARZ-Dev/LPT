<div>
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card m-2">
                <div class="card-header justify-content-between align-items-center">
                    <h5 class="mb-0">Men Rankings</h5>
                </div>
                <div class="card-body" style="height: 400px; overflow-x: auto;">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="dt-row-grouping table border table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">Rank</th>
                                    <th class="text-center">Player</th>
                                    <th class="text-center">P/W/L</th>
                                    <th class="text-center">Points</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($menPlayers as $menPlayer)
                                    <tr>
                                        <td class="text-center">{{ $menPlayer->rank }}</td>
                                        <td class="text-center">{{ $menPlayer->full_name }}</td>
                                        <td class="text-center">{{ $menPlayer->matches }}/{{ $menPlayer->wins }}/{{ $menPlayer->losses }}</td>
                                        <td class="text-center">{{ $menPlayer->points }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No players available.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card m-2">
                <div class="card-header justify-content-between align-items-center">
                    <h5 class="mb-0">Women Rankings</h5>
                </div>
                <div class="card-body" style="height: 400px; overflow-x: auto;">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="dt-row-grouping table border table-bordered">
                                <thead>
                                <tr>
                                    <th class="text-center">Rank</th>
                                    <th class="text-center">Player</th>
                                    <th class="text-center">P/W/L</th>
                                    <th class="text-center">Points</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($womenPlayers as $womenPlayer)
                                    <tr>
                                        <td class="text-center">{{ $womenPlayer->rank }}</td>
                                        <td class="text-center">{{ $womenPlayer->full_name }}</td>
                                        <td class="text-center">{{ $womenPlayer->matches }}/{{ $womenPlayer->wins }}/{{ $womenPlayer->losses }}</td>
                                        <td class="text-center">{{ $womenPlayer->points }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No players available.</td>
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
