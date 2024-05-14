<div wire:ignore.self class="modal fade absent-modal" id="absentTeam{{$match->id}}" tabindex="-1" aria-labelledby="absentTeam{{$match->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form wire:submit.prevent="storeAbsent({{ $match->id }})">
                <div class="modal-header">
                    <h5 class="modal-title" id="absentTeam{{$match->id}}">Choose Absent Team:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label" for="absent-team">Absent Team *</label>
                    <div wire:ignore>
                        <select
                            wire:model="absentTeamId"
                            id="absent-team-{{ $match->id }}"
                            class="selectpicker w-100"
                            title="Select Absent Team"
                            data-style="btn-default"
                            data-live-search="true"
                            data-icon-base="ti"
                            data-size="5"
                            data-tick-icon="ti-check text-white"
                            required
                        >
                            <option value="{{ $match->homeTeam?->id }}">{{ $match->homeTeam?->nickname }}</option>
                            <option value="{{ $match->awayTeam?->id }}">{{ $match->awayTeam?->nickname }}</option>
                        </select>
                    </div>
                    @error('absentTeamId') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="modal-footer">
                    <button type="submit" data-match-id="{{ $match->id }}" class="btn btn-primary store-absent-btn">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
