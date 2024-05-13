<div>
    <div class="row">
        <div class="col-xl">
            <form class="row g-3">
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Tournament Type</h5>
                        <a href="{{ route('types') }}"
                           class="btn btn-primary mb-2 text-nowrap"
                        >
                            Tournament Types
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="name">Name *</label>
                                <input
                                    wire:model="name"
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Name"
                                />
                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="points" class="form-label">Points *</label>
                                <input wire:model="points" id="points" type="text" class="form-control cleave-input">
                                @error('points') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Points Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-3"></div>
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center w-50">Stage</th>
                                                <th class="text-center w-50">Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($stagePoints as $key => $stagePoint)
                                            <tr>
                                                <td class="text-center">{{ $stagePoint['stage'] }}</td>
                                                <td class="text-center">
                                                    <input wire:model="stagePoints.{{ $key }}.points" type="text" class="form-control cleave-input">
                                                    @error('stagePoints.' . $key . '.points') <div class="text-danger">{{ $message }}</div> @enderror
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-3"></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-end mt-2">
                    <button wire:click="store" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
                </div>
            </form>

        </div>
    </div>

    @script
    <script>


    </script>
    @endscript
</div>

