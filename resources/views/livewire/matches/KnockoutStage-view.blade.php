<div>
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between">
            <h4 class="card-title mb-3">{{ $tournament->name }}</h4>
            <a class="btn btn-primary h-50" href="{{ route('tournaments-categories', $tournament->id) }}">{{ $tournament->name }} Tournament</a>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-matches dataTable table border-top">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Tournament Deuce Type</th>
                    <th>Name</th>
                    <th>Nb Of Sets</th>
                    <th>Nb Of Games</th>
                    <th>Is Completed</th>
            
                </tr>
                </thead>
                <tbody>
                @foreach($knockoutStages as $knockoutStage)
                    <tr>
                        <td>{{ $knockoutStage->id }}</td>
                        <td>{{ $knockoutStage->tournamentDeuceType?->name }}</td>
                        <td>{{ $knockoutStage->name }}</td>
                        <td>{{ $knockoutStage->nb_of_sets }}</td>
                        <td>{{ $knockoutStage->nb_of_games }}</td>
                        <td>@if ( $knockoutStage->is_completed  == 0) Not Completed @else Completed @endif</td>
                        


                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>


    @script
    @include('livewire.deleteConfirm')
    @endscript

    @script
    <script>
        $(document).on('click', '.submit-btn', function () {
            let matchId = $(this).data('match-id');
            let winnerId = $('#winner-' + matchId).val();
            let data = {
                matchId, winnerId
            };

            $wire.dispatch('chooseWinner', data)
        })
    </script>
    @endscript

</div>

