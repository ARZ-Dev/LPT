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
                @if(!$isAlreadyStarted)
                    <div class="row g-3 mt-2">
                        <div class="col-12 col-sm-6">
                            <label class="form-label" for="servingTeamId">First Serving Team <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select wire:model="servingTeamId" id="servingTeamId" class="form-select selectpicker w-100" aria-label="Default select example" title="Select Serving Team" data-style="btn-default" data-live-search="true" data-icon-base="ti" data-tick-icon="ti-check text-white" required>
                                    <option value="{{ $homeTeam->id }}" @selected($homeTeam->id == $servingTeamId)>{{ $homeTeam->nickname }}</option>
                                    <option value="{{ $awayTeam->id }}" @selected($awayTeam->id == $servingTeamId)>{{ $awayTeam->nickname }}</option>
                                </select>
                            </div>
                            @error('servingTeamId') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                @endif
                <div class="row g-3 mt-4">
                    <div class="col-12 col-sm-12">
                        <div class="d-flex justify-content-center">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            @if(!$match->is_completed)
                                                <td style="min-width: 60px" class="border text-center">
                                                    @if($servingTeamId == $homeTeam->id)
                                                        <i class="ti ti-ball-tennis ti-xs"></i>
                                                    @endif
                                                </td>
                                            @endif
                                            <th class="border text-center">{{ $homeTeam->nickname }}</th>
                                            @foreach($match?->sets ?? [] as $set)
                                                <td class="border">
                                                    {{ $set->home_team_score }}
                                                    @if($set->is_completed && ($set->home_team_score == $nbOfGamesToWin + 1 && $set->away_team_score == $nbOfGamesToWin) || ($set->home_team_score == $nbOfGamesToWin && $set->away_team_score == $nbOfGamesToWin + 1))
                                                        <sup>
                                                            {{ $set->setGames()->latest()->first()->points()->latest()->first()->home_team_score }}
                                                        </sup>
                                                    @endif
                                                </td>
                                                @if(!$set->is_completed)
                                                    <td class="border">{{ $set->setGames()->where('is_completed', false)->first()?->home_team_score ?? 0 }}</td>
                                                @endif
                                            @endforeach
                                            <td class="border">
                                                @if(!$match->is_completed)
                                                    <button wire:click="scorePoint({{ $homeTeam->id }})" type="button" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light">
                                                        <span class="ti ti-plus"></span>
                                                    </button>
                                                @else
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
                                            <td style="min-width: 60px" class="border-0">
                                                @if(!$match->is_completed && $lastActionTeamId == $match->home_team_id && $canUndo)
                                                    <button wire:click="undoPoint({{ $homeTeam->id }})" type="button" class="btn rounded-pill btn-icon btn-warning waves-effect waves-light">
                                                        <span class="ti ti-arrow-back"></span>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            @if(!$match->is_completed)
                                                <td style="min-width: 70px" class="border text-center">
                                                    @if($servingTeamId == $awayTeam->id)
                                                        <i class="ti ti-ball-tennis ti-xs"></i>
                                                    @endif
                                                </td>
                                            @endif
                                            <th class="border text-center">{{ $awayTeam->nickname }}</th>
                                            @foreach($match?->sets ?? [] as $set)
                                                <td class="border">
                                                    {{ $set->away_team_score }}
                                                    @if($set->is_completed && ($set->home_team_score == $nbOfGamesToWin + 1 && $set->away_team_score == $nbOfGamesToWin) || ($set->home_team_score == $nbOfGamesToWin && $set->away_team_score == $nbOfGamesToWin + 1))
                                                        <sup>
                                                            {{ $set->setGames()->latest()->first()->points()->latest()->first()->away_team_score }}
                                                        </sup>
                                                    @endif
                                                </td>
                                                @if(!$set->is_completed)
                                                    <td class="border">{{ $set->setGames()->where('is_completed', false)->first()?->away_team_score ?? 0 }}</td>
                                                @endif
                                            @endforeach
                                            <td class="border">
                                                @if(!$match->is_completed)
                                                    <button wire:click="scorePoint({{ $awayTeam->id }})" type="button" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light">
                                                        <span class="ti ti-plus"></span>
                                                    </button>
                                                @else
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
                                            <td style="min-width: 70px" class="border-0">
                                                @if(!$match->is_completed && $lastActionTeamId == $match->away_team_id && $canUndo)
                                                    <button wire:click="undoPoint({{ $awayTeam->id }})" type="button" class="btn rounded-pill btn-icon btn-warning waves-effect waves-light">
                                                        <span class="ti ti-arrow-back"></span>
                                                    </button>
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
