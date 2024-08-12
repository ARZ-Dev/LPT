<div>
    <div class="row">
        @foreach($categories as $category)
            <div class="col-lg-6 col-sm-12">
                <div class="card m-2">
                    <div class="card-header justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $category->name }} Rankings</h5>
                    </div>
                    <div class="card-body" style="height: 400px; overflow-x: auto;">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="dt-row-grouping table border table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Rank</th>
                                        <th class="text-center">Team</th>
                                        <th class="text-center">P/W/L</th>
                                        <th class="text-center">Points</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($category->teams as $team)
                                        <tr>
                                            <td class="text-center">{{ $team->rank }}</td>
                                            <td class="text-center">{{ $team->nickname }}</td>
                                            <td class="text-center">{{ $team->matches }}/{{ $team->wins }}/{{ $team->losses }}</td>
                                            <td class="text-center">{{ number_format($team->points) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No teams available.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
