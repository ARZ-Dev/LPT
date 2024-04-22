<div>

<div class="d-flex mb-2 justify-content-end">
        <a class="btn btn-primary" href="{{ route('matches', $match->knockoutRound->tournamentLevelCategory->id) }}">{{ $match->homeTeam->nickname }} vs {{ $match->awayTeam->nickname }} </a>
    </div>
    
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title m-0">Shipping activity</h5>
                </div>
            <div class="card-body">
                <ul class="timeline pb-0 mb-0">
                <li
                    class="timeline-item timeline-item-transparent border-primary">
                    <span
                    class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                    <div class="timeline-header">
                        <h6 class="mb-0">Order was placed (Order ID:
                        #32543)</h6>
                        <span class="text-muted">Tuesday 11:29 AM</span>
                    </div>
                    <p class="mt-2">Your order has been placed
                        successfully</p>
                    </div>
                </li>
                <li
                    class="timeline-item timeline-item-transparent border-primary">
                    <span
                    class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                    <div class="timeline-header">
                        <h6 class="mb-0">Pick-up</h6>
                        <span class="text-muted">Wednesday 11:29 AM</span>
                    </div>
                    <p class="mt-2">Pick-up scheduled with courier</p>
                    </div>
                </li>
                <li
                    class="timeline-item timeline-item-transparent border-primary">
                    <span
                    class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                    <div class="timeline-header">
                        <h6 class="mb-0">Dispatched</h6>
                        <span class="text-muted">Thursday 11:29 AM</span>
                    </div>
                    <p class="mt-2">Item has been picked up by
                        courier</p>
                    </div>
                </li>
                <li
                    class="timeline-item timeline-item-transparent border-primary">
                    <span
                    class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                    <div class="timeline-header">
                        <h6 class="mb-0">Package arrived</h6>
                        <span class="text-muted">Saturday 15:20 AM</span>
                    </div>
                    <p class="mt-2">Package arrived at an Amazon
                        facility, NY</p>
                    </div>
                </li>
                <li
                    class="timeline-item timeline-item-transparent border-left-dashed">
                    <span
                    class="timeline-point timeline-point-primary"></span>
                    <div class="timeline-event">
                    <div class="timeline-header">
                        <h6 class="mb-0">Dispatched for delivery</h6>
                        <span class="text-muted">Today 14:12 PM</span>
                    </div>
                    <p class="mt-2">Package has left an Amazon facility,
                        NY</p>
                    </div>
                </li>
                <li
                    class="timeline-item timeline-item-transparent border-transparent pb-0">
                    <span
                    class="timeline-point timeline-point-secondary"></span>
                    <div class="timeline-event pb-0">
                    <div class="timeline-header">
                        <h6 class="mb-0">Delivery</h6>
                    </div>
                    <p class="mt-2 mb-0">Package will be delivered by
                        tomorrow</p>
                    </div>
                </li>
                </ul>
            </div>
            </div>
        </div>
                
    </div>
</div>
