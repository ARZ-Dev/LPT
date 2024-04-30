<div>
    <h4 class="py-3 mb-4 d-flex justify-content-between align-items-center">
        <span class="text-muted fw-light">Match / {{$match->homeTeam->nickname}} VS {{$match->awayTeam->nickname}}</span>
        <span class="text-muted fw-light">
            <a href="{{ route('matches', $category->id ) }}" class="btn btn-primary text-nowrap ms-2">
              Matches
            </a>
        </span>
    </h4>

    <div class="row overflow-hidden">
        <div class="col-12">
            <ul class="timeline timeline-center mt-5">
            @foreach($points as $point)
                <li class="timeline-item timeline-item-{{ $point->point_team_id == $match->home_team_id ? "left" : "right" }} mt-1">

                <span class="timeline-indicator timeline-indicator-primary" data-aos="zoom-in" data-aos-delay="200">
                  <i class="ti ti-ball-tennis ti-sm"></i>
                </span>
                    <div class="timeline-event card p-0" data-aos="fade-left">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="card-title mb-0">
                                {{ $point->point_team_id == $match->home_team_id ? $match->homeTeam->nickname : $match->awayTeam->nickname }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"> {{$point->home_team_score}} - {{$point->away_team_score}}</p>
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <p class="text-muted mb-2">Point Nb : {{$point->point_number}}</p>
                                    <ul class="list-unstyled users-list d-flex align-items-center avatar-group"></ul>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-event-time">{{ \Carbon\Carbon::parse($point->created_at)->format('H:i:s') }}</div>
                    </div>
              </li>
            @endforeach
            </ul>
        </div>
    </div>
</div>



