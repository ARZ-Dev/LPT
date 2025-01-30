<div>
    <form>

        <div class="card mb-2">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">
                    {{ $homeTeam->nickname }} VS {{ $awayTeam->nickname }} Match Scoring - {{ $match->type == "Knockouts" ? $match->knockoutRound?->name : $match->group?->name }}
                </h5>
                @can('tournamentCategory-edit')
                    <a class="btn btn-primary h-50" href="{{ route('tournaments-categories.edit', [$category->tournament_id, $category->id]) }}">{{ $category->levelCategory?->name }} Category</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">Started At</label>
                        <input wire:model="startedAt" type="text" class="form-control" readonly disabled>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="form-label">Referee</label>
                        <input wire:model="referee" type="text" class="form-control" readonly disabled>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label">Deuce Type</label>
                        <input type="text" class="form-control" readonly disabled value="{{ $deuceType->name ?? "N/A" }}">
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label">Number of Sets to Win the Match</label>
                        <input type="text" class="form-control" readonly disabled value="{{ $nbOfSetsToWin ?? "N/A" }}">
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label">Number of Games to Win the Set</label>
                        <input type="text" class="form-control" readonly disabled value="{{ $nbOfGamesToWin ?? "N/A" }}">
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <label class="form-label">Tiebreak Winning Points</label>
                        <input type="text" class="form-control" readonly disabled value="{{ $tiebreakPointsToWin ?? "N/A" }}">
                    </div>
                </div>
                <div class="row g-3 mt-4">
                    <div class="col-12 col-sm-12">
                        <div class="d-flex justify-content-center">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <tbody>
                                    <tr>
                                        <td style="width: 20% !important;"></td>
                                        @foreach($sets as $key => $set)
                                            <td style="width: {{ 70 / count($sets) }}% !important;">
                                                <div class="d-flex justify-content-between">
                                                    <span>
                                                        Set {{ $loop->iteration }}
                                                    </span>
                                                    @if($loop->iteration > $nbOfSetsToWin)
                                                    <button type="button" wire:click="removeSet({{ $key }})" class="btn btn-danger rounded-pill btn-icon">
                                                        <span class="ti ti-circle-minus text-white"></span>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        @endforeach
                                        <td style="width: 10% !important;">
                                            @if(count($sets) <= $maxSetsCount)
                                                <button type="button" wire:click="addSet" class="btn btn-primary rounded-pill btn-icon">
                                                    <span class="ti ti-circle-plus text-white"></span>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border text-center">{{ $homeTeam->nickname }}</th>
                                        @foreach($sets ?? [] as $key => $set)
                                            <td class="border">
                                                <input wire:model="sets.{{ $key }}.home_team_score" type="text" class="form-control" />
                                            </td>
                                        @endforeach
                                        <td class="border">
                                            @if($match->is_completed)
                                                @if($match->winner_team_id == $homeTeam->id)
                                                    <span class="badge rounded-pill bg-label-success">
                                                        Winner!
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill bg-label-danger">
                                                        Loser!
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border text-center">{{ $awayTeam->nickname }}</th>
                                        @foreach($sets ?? [] as $key => $set)
                                            <td class="border">
                                                <input wire:model="sets.{{ $key }}.away_team_score" type="text" class="form-control" />
                                            </td>
                                        @endforeach
                                        <td class="border">
                                            @if($match->is_completed)
                                                @if($match->winner_team_id == $awayTeam->id)
                                                    <span class="badge rounded-pill bg-label-success">
                                                        Winner!
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill bg-label-danger">
                                                        Loser!
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    @script
    <script>



    </script>
    @endscript
</div>
