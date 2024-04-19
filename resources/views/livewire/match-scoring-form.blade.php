<div>
    <form>

        <div class="card mb-2">
            <div class="card-header d-flex justify-content-center align-items-center">
                <h5 class="mb-0">
                    {{ $homeTeam->nickname }} VS {{ $awayTeam->nickname }} Match Scoring
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-sm-6">
                        <label class="form-label">Started At</label>
                        <input wire:model="startedAt" type="text" class="form-control" readonly disabled>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label class="form-label">Referee</label>
                        <input wire:model="referee" type="text" class="form-control" readonly disabled>
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
                <div class="row g-3 mt-2">
                    <div class="col-12 col-sm-6">
                        <h5>{{ $homeTeam->nickname }}</h5>
                        <div class="d-flex justify-content-center">
                            <button wire:click="scorePoint({{ $homeTeam->id }})" type="button" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light">
                                <span class="ti ti-plus"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h5>{{ $awayTeam->nickname }}</h5>
                        <div class="d-flex justify-content-center">
                            <button wire:click="scorePoint({{ $awayTeam->id }})" type="button" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light">
                                <span class="ti ti-plus"></span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-12 col-sm-12">
                        <div class="d-flex justify-content-center">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>
                                                @if($currentSetGame?->serving_team_id == $homeTeam->id)
                                                    <i class="ti ti-ball-tennis ti-xs"></i>
                                                @endif
                                            </td>
                                            <th>{{ $homeTeam->nickname }}</th>
                                            @foreach($match?->sets ?? [] as $set)
                                                <td>{{ $set->home_team_score }}</td>
                                                @if(!$set->is_completed)
                                                    <td>{{ $set->setGames()->where('is_completed', false)->first()?->home_team_score ?? 0 }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($currentSetGame?->serving_team_id == $awayTeam->id)
                                                    <i class="ti ti-ball-tennis ti-xs"></i>
                                                @endif
                                            </td>
                                            <th>{{ $awayTeam->nickname }}</th>
                                            @foreach($match?->sets ?? [] as $set)
                                                <td>{{ $set->away_team_score }}</td>
                                                @if(!$set->is_completed)
                                                    <td>{{ $set->setGames()->where('is_completed', false)->first()?->away_team_score ?? 0 }}</td>
                                                @endif
                                            @endforeach
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
