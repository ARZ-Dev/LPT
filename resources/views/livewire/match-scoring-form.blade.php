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
            </div>
        </div>

    </form>

    @script
    <script>



    </script>
    @endscript
</div>
