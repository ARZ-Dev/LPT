<div class="col-md-4 my-2">
    <div class="card bg-light rounded">
        <div class="card-header d-flex justify-content-between">
            <div>
                <span>Match #{{ $match->id }}</span> <br>
                <span>{{ $match->type == "Knockouts" ? $match->knockoutRound->name : $match->group->name }} Round</span> <br>
                <span>Date: {{ $match->datetime ?? "N/A" }}</span>
            </div>
            <div>
                @if($match->datetime)
                    <a href="{{ route('matches.scoring', ['matchId' => $match->id]) }}" class="btn rounded-pill btn-icon btn-success waves-effect waves-light">
                        @if($match->is_started)
                            <span class="ti ti-report text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Results"></span>
                        @else
                            <span class="ti ti-player-play text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Start Game"></span>
                        @endif
                    </a>
                @else
                    <a href="#" data-bs-toggle="modal" data-bs-target="#dateTime{{$match->id}}" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light">
                        <span class="ti ti-calendar text-white"  data-bs-toggle="tooltip" data-bs-placement="top" title="Set Date/Time"></span>
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h5>
                        @if($match->homeTeam)
                            {{ $match->homeTeam->nickname }}
                        @elseif($match->relatedHomeGame)
                            Winner of {{ $match->relatedHomeGame->knockoutRound?->name }}
                        @endif
                    </h5>
                </div>
                <div class="col-12 text-center">
                    <h4>VS</h4>
                </div>
                <div class="col-12 text-center">
                    <h5>
                        @if($match->awayTeam)
                            {{ $match->awayTeam->nickname }}
                        @elseif($match->relatedAwayGame)
                            Winner of {{ $match->relatedAwayGame->knockoutRound?->name }}
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade date-modal" id="dateTime{{$match->id}}" tabindex="-1" aria-labelledby="dateTime{{$match->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form wire:submit.prevent="storeDateTime({{ $match->id }})">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel{{$match->id}}">Choose Date/Time:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="date-{{ $match->id }}" wire:model="matchDate" type="datetime-local" class="form-control" required min="{{ $category->start_date . " 00:00" }}" max="{{ $category->end_date . " 23:59" }}">
                    @error('matchDate') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="modal-footer">
                    <button type="submit" data-match-id="{{ $match->id }}" class="btn btn-primary store-date-btn">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

