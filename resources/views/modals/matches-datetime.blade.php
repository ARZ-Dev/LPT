<div wire:ignore.self class="modal fade date-modal" id="dateTime{{$match->id}}" tabindex="-1" aria-labelledby="userModalLabel{{$match->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel{{$match->id}}">Match Info:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label" for="date-{{ $match->id }}">Date/Time</label>
                            <input id="date-{{ $match->id }}" wire:model="matchDate" type="datetime-local" class="form-control" required min="{{ $category->start_date . " 00:00" }}" max="{{ $category->end_date . " 23:59" }}">
                            @error('matchDate') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        @if($match->type == "Knockouts")
                            <div class="col-12 mt-2">
                                <label class="form-label">Court <span class="text-danger">*</span></label>
                                <div wire:ignore>
                                    <select
                                        wire:model="courtId"
                                        id="court-id-{{ $match->id }}"
                                        class="form-select selectpicker w-100"
                                        aria-label="Default select example"
                                        title="Select Court"
                                        data-style="btn-default"
                                        data-live-search="true"
                                        data-icon-base="ti"
                                        data-tick-icon="ti-check text-white"
                                        required
                                    >
                                        @foreach($courts as $court)
                                            <option value="{{ $court->id }}">{{ $court->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('courtId') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        @endif
                        <div class="col-12 mt-2">
                            <label class="form-label">Scorekeeper <span class="text-danger">*</span></label>
                            <div wire:ignore>
                                <select
                                    wire:model="scorekeeperId"
                                    id="scorekeeper-{{ $match->id }}"
                                    class="form-select selectpicker w-100"
                                    aria-label="Default select example"
                                    title="Select Scorekeeper"
                                    data-style="btn-default"
                                    data-live-search="true"
                                    data-icon-base="ti"
                                    data-tick-icon="ti-check text-white"
                                    required
                                >
                                    @foreach($scorekeepers as $scorekeeper)
                                        <option value="{{ $scorekeeper->id }}">{{ $scorekeeper->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('scorekeeperId') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-match-id="{{ $match->id }}" data-type="{{ $match->type }}" class="btn btn-primary store-date-btn">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
