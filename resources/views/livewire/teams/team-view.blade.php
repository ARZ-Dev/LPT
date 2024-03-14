<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">View Team #{{ $team->id }}</h5>
                    <a href="{{ route('teams') }}" class="btn btn-primary mb-2 text-nowrap">
                        Teams
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Team:</span>
                            <span class="text-dark" >{{ $team->nickname }} </span>
                        </div>

                        <div class="col-12 col-md-6">
                            <span class="fw-bold text-dark">Level Category:</span>
                            <span class="text-dark" >{{ $team->levelCategory->name }}</span>
                        </div>



                    </div>
                </div>
            </div>



        </div>
    </div>

    @script
    <script>

    </script>
    @endscript
</div>
