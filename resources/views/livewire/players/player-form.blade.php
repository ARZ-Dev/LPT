<div>
    <div class="row">
        <div class="col-xl">
            <form class="row g-3">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $editing ? ($status == \App\Utils\Constants::VIEW_STATUS ? "View" : ($status == \App\Utils\Constants::CONFIRM_STATUS ? "Confirm" : "Edit")) : "Create" }} Player</h5>
                        <a href="{{ route('players') }}"
                           class="btn btn-primary mb-2 text-nowrap"
                        >
                            Players
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="firstName">First Name</label>
                                <input
                                    wire:model="form.firstName"
                                    type="text"
                                    id="firstName"
                                    name="firstName"
                                    class="form-control"
                                    placeholder="First Name"
                                />
                                @error('form.firstName') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="middleName">Middle Name</label>
                                <input
                                    wire:model="form.middleName"
                                    type="text"
                                    id="middleName"
                                    name="middleName"
                                    class="form-control"
                                    placeholder="Middle Name"
                                />
                                @error('form.middleName') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="lastName">Last Name</label>
                                <input
                                    wire:model="form.lastName"
                                    type="text"
                                    id="lastName"
                                    name="lastName"
                                    class="form-control"
                                    placeholder="Nickname"
                                />
                                @error('form.lastName') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="teamId">Team *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="form.teamId"
                                        id="teamId"
                                        class="selectpicker w-100 @error('teamId') invalid-validation-select @enderror"
                                        title="Select Level Category"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-tick-icon="ti-check text-white" required>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->nickname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('form.teamId') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                @if(!$status)
                    <div class="col-12 text-end mt-2">
                        <button wire:click="{{ $editing ? "update" : "store" }}" type="button" class="btn btn-primary me-sm-3 me-1">Submit</button>
                    </div>
                @endif
            </form>

        </div>
    </div>

    <script>

        document.addEventListener('livewire:navigated', function () {

            $(document).ready(function () {


            });

            var status={{$status}};
            if (status=="1") {$('input').prop('disabled', true);}

        })

    </script>

</div>

