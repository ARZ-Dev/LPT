<div>


<div class="layout-wrapper layout-content-navbar">
        <div class="layout-page">
          <div class="content-wrapper">
 

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-4"><span class="text-muted fw-light">Match /</span> {{$match->homeTeam->nickname}} VS {{$match->awayTeam->nickname}} </h4>

              <div class="row overflow-hidden">
                <div class="col-12">
                  <ul class="timeline timeline-center mt-5">


                  @foreach($points as $point)
                  @if($point->home_team_score != 0)
                    <li class="timeline-item timeline-item-right mt-1">
                      @else
                    <li class="timeline-item timeline-item-left">
                      @endif

                      <span
                        class="timeline-indicator timeline-indicator-primary"
                        data-aos="zoom-in"
                        data-aos-delay="200">
                        <i class="ti ti-ball-tennis ti-sm"></i>
                      </span>
                      <div class="timeline-event card p-0"
                        data-aos="fade-left">
                        <div
                          class="card-header d-flex justify-content-between align-items-center flex-wrap">
                          <h6 class="card-title mb-0">@if($point->home_team_score != 0) {{$match->homeTeam->nickname}} @else {{$match->awayTeam->nickname}} @endif</h6>
                          <div class="meta">
                            <span class="badge rounded-pill bg-label-primary">Design</span>
                            <span class="badge rounded-pill bg-label-success">Meeting</span>
                          </div>
                        </div>
                        <div class="card-body">
                          <p class="mb-2">
                            {{$point->home_team_score}} - {{$point->away_team_score}}
                          </p>
                          <div
                            class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                              <p class="text-muted mb-2">Point Nb : {{$point->point_number}}</p>
                              <ul class="list-unstyled users-list d-flex align-items-center avatar-group"></ul>
                            </div>
                          </div>
                        </div>
                        <div class="timeline-event-time" style="font-size: 12px;">{{ \Carbon\Carbon::parse($point->created_at)->format('jS F H:i') }}
                        </div>
                      </div>
                    </li>
                  @endforeach
  
                    </ul>
                  </div>
                </div>
              </div>
            
                </div>
              </div>
            </div>
          </div>
        </div>
</div>

</div>