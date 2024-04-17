<div>

    <div class="d-flex mb-2 justify-content-end">
        <a class="btn btn-primary" href="{{ route('tournaments-categories', $category->tournament_id) }}">{{ $category->tournament->name }} Categories</a>
    </div>

    <div class="my_gracket mt-4"></div>

    @script
    <script type="text/javascript">
            let data = [

                @foreach($category->knockoutStages as $knockoutStage)

                [

                    @foreach($knockoutStage->games as $game)

                    [
                        { name: "{{ $game->homeTeam?->nickname ?? "Winner of " . $game->relatedHomeGame?->knockoutRound?->name }}", id: "{{ $game->homeTeam?->id }}"},
                        { name: "{{ $game->awayTeam?->nickname ?? "Winner of " . $game->relatedAwayGame?->knockoutRound?->name }}", id: "{{ $game->awayTeam?->id }}"},
                    ],

                    @endforeach

                ],

                @endforeach

                // WINNER
                [
                    [
                        { name: "{{ $category->winnerTeam?->nickname ?? "N/A" }}", id: "{{ $category->winner_team_id }}",}
                    ]
                ],
            ];

            // initializer
            $(".my_gracket").gracket({ src: data });
    </script>
    @endscript


</div>
