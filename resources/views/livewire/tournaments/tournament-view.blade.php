<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Tournament #{{ $tournament->id }}</h5>
                    <div>
              
                        <a href="{{ route('tournaments') }}" class="btn btn-primary mb-2 text-nowrap">
                            Tournaments
                        </a>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Created By:</span>
                            <span class="text-dark" id="user">{{ $tournament->createdBy?->full_name }} / {{ $tournament->createdBy?->username }}</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Tournament Name:</span>
                            <span class="text-dark" id="tillname">{{ $tournament->name }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">Start Date:</span>
                            <span class="text-dark" id="category">{{ $tournament->start_date }}</span>
                        </div>
                        <div class="col-12 col-md-6 mt-5">
                            <span class="fw-bold text-dark">End Date:</span>
                            <span class="text-dark" id="sub_category">{{ $tournament->end_date }}</span>
                        </div>
                    
                    </div>
                </div>
            </div>

        </div>
    </div>


    
</div>
