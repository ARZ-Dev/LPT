<div>


    <div class="d-flex mb-2 justify-content-end">
        <a class="btn btn-primary" href="{{ route('tournaments-categories', $category->tournament_id) }}">{{ $category->tournament->name }} Categories</a>
    </div>

    <div class="brackets" style="height: 1000px"></div>

    @script
    <script>
        let rounds = [

            @foreach($category - > knockoutStages as $knockoutStage)

            [

                @foreach($knockoutStage - > games as $game)

                {
                    player1: {
                        name: "{{ $game->homeTeam?->nickname ??  $game->relatedHomeGame?->knockoutRound?->name }}"
                        , winner: true
                        , ID: '{{ $game->homeTeam?->id }}'
                    }
                    , player2: {
                        name: "{{ $game->awayTeam?->nickname ??  $game->relatedAwayGame?->knockoutRound?->name }}"
                        , ID: '{{ $game->homeTeam?->id }}'
                    }
                },

                @endforeach

            ],

            @endforeach

            // Champion
            [{
                player1: {
                    name: "{{ $category->winnerTeam?->nickname ?? "
                    N / A " }}"
                    , winner: true
                    , ID: '{{ $category->winner_team_id }}'
                }
            , }, ],

        ];

        let titles = [

            @foreach($category - > knockoutStages as $knockoutStage)

            '{{$knockoutStage->name}}',

            @endforeach

            'Winner'
        , ];

        $(".brackets").brackets({
            titles: titles
            , rounds: rounds
            , color_title: 'black'
            , border_color: 'black'
            , color_player: 'black'
            , bg_player: 'white'
            , color_player_hover: 'black'
            , bg_player_hover: 'white'
            , border_radius_player: '10px'
            , border_radius_lines: '10px'
        , });

    </script>
    @endscript


</div>
