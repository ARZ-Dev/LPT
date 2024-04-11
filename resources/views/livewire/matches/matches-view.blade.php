<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Tournament #{{ $matches->id }}</h5>
                    <div>
                        <a href="{{ route('matches-view', $matches->id ) }}" class="btn btn-primary mb-2 text-nowrap">
                            Matches
                        </a>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Type</span>
                            <span class="text-dark" id="user">{{ $matches->type}}</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Knockout Round:</span>
                            <span class="text-dark" id="tillname">{{ $matches->knockoutRound->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Home Team :</span>
                            <span class="text-dark" id="category">{{ $matches->homeTeam->nickname }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Away Team :</span>
                            <span class="text-dark" id="category">{{ $matches->awayTeam->nickname }}</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>



</div>
