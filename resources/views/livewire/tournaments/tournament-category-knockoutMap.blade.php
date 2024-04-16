<div>

    <div class="my_gracket"></div>


    @script
	<script type="text/javascript">

        let data = [
            @foreach($category->knockoutStages as $knockoutStage)

            [

                @foreach($knockoutStage->games as $game)

                    [
                        {"name" : "{{ $game->homeTeam?->nickname ?? ( "Winner of " . $game->relatedHomeGame->knockoutRound?->name) }}", "id" : "{{ $game->home_team_id }}"},
                        {"name" : "{{ $game->awayTeam?->nickname ?? ( "Winner of " . $game->relatedAwayGame->knockoutRound?->name) }}", "id" : "{{ $game->away_team_id }}"}
                    ],

                @endforeach

            ],

            @endforeach

        ];

        console.log("data")
        console.log(data)

        $(".my_gracket").gracket({ src : data });

	</script>
    @endscript


</div>
