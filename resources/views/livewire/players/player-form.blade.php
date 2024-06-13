<div>
    <div class="row">
        <div class="col-xl">
            <form>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Personal Informations</h5>
                        <a href="{{ route('players') }}"
                           class="btn btn-primary mb-2 text-nowrap"
                        >
                            Players
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="first_name">First Name *</label>
                                <input
                                    wire:model="first_name"
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    class="form-control"
                                    placeholder="First Name"
                                />
                                @error('first_name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="middle_name">Middle Name *</label>
                                <input
                                    wire:model="middle_name"
                                    type="text"
                                    id="middle_name"
                                    name="middle_name"
                                    class="form-control"
                                    placeholder="Middle Name"
                                />
                                @error('middle_name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label" for="last_name">Last Name *</label>
                                <input
                                    wire:model="last_name"
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    class="form-control"
                                    placeholder="Last Name"
                                />
                                @error('last_name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="birthdate">Birthdate *</label>
                                <input
                                    wire:model="birthdate"
                                    type="date"
                                    id="birthdate"
                                    name="birthdate"
                                    class="form-control"
                                    max="{{ now()->format('Y-m-d') }}"
                                />
                                @error('birthdate') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input
                                    wire:model="email"
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Email"
                                />
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="phone_number">Phone Number *</label>
                                <input
                                    wire:model="phone_number"
                                    type="text"
                                    id="phone_number"
                                    name="phone_number"
                                    class="form-control"
                                    placeholder="Phone Number"
                                />
                                @error('phone_number') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="country_id">Country *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="country_id"
                                        id="country_id"
                                        class="selectpicker w-100"
                                        title="Select Country"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-size="5"
                                        data-tick-icon="ti-check text-white" required>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" @selected($country->id == $country_id)>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('country_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="nickname">Nickname *</label>
                                <input
                                    wire:model="nickname"
                                    type="text"
                                    id="nickname"
                                    name="nickname"
                                    class="form-control"
                                    placeholder="Nickname"
                                />
                                @error('nickname') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label" for="gender">Gender *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="gender"
                                        id="gender"
                                        class="selectpicker w-100 @error('team_id') invalid-validation-select @enderror"
                                        title="Select Gender"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-tick-icon="ti-check text-white" required>
                                        <option value="male" @selected("male" == $gender)>Male</option>
                                        <option value="female" @selected("female" == $gender)>Female</option>
                                    </select>
                                </div>
                                @error('gender') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Team Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="team_id">Current Team</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="current_team_id"
                                        id="team_id"
                                        class="selectpicker w-100 @error('team_id') invalid-validation-select @enderror"
                                        title="Select Team"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-size="5"
                                        data-tick-icon="ti-check text-white" required>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}" @selected($team->id == $current_team_id)>{{ $team->nickname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('team_id') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label" for="playing_side">Playing Side *</label>
                                <div wire:ignore>
                                    <select
                                        wire:model="playing_side"
                                        id="playing_side"
                                        class="selectpicker w-100 @error('playing_side') invalid-validation-select @enderror"
                                        title="Select Playing Side"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-tick-icon="ti-check text-white" required>
                                        <option value="left" @selected("left" == $playing_side)>Left</option>
                                        <option value="right" @selected("right" == $playing_side)>Right</option>
                                    </select>
                                </div>
                                @error('playing_side') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            @if(count($playerTeams))
                                <div class="col-12 col-md-6">
                                    <label class="form-label" for="teamsIds">Teams</label> <br>
                                    @foreach($playerTeams as $team)
                                        <span class='badge bg-label-warning m-1'>{{ $team->nickname }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            National ID Upload
                            @if($player?->national_id_upload)
                                - <a href="{{ asset(\Illuminate\Support\Facades\Storage::url($player->national_id_upload)) }}" download>Download Link</a>
                            @endif
                        </h5>

                        <h6>
                            @error('nationalIdFile')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                @php
                                    $uploadedFile = $player?->national_id_upload ? [asset(\Illuminate\Support\Facades\Storage::url($player->national_id_upload))] : [];
                                @endphp
                                <x-filepond :files="$uploadedFile" wire:model="nationalIdFile" delete-event="deleteNationalIdFile" />
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

    @script
    <script>

    </script>
    @endscript

</div>

