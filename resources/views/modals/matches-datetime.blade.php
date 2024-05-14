<div wire:ignore.self class="modal fade date-modal" id="dateTime{{$match->id}}" tabindex="-1" aria-labelledby="userModalLabel{{$match->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form wire:submit.prevent="storeDateTime({{ $match->id }})">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel{{$match->id}}">Choose Date/Time:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="date-{{ $match->id }}" wire:model="matchDate" type="datetime-local" class="form-control" required min="{{ $category->start_date . " 00:00" }}" max="{{ $category->end_date . " 23:59" }}">
                    @error('matchDate') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="modal-footer">
                    <button type="submit" data-match-id="{{ $match->id }}" class="btn btn-primary store-date-btn">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
