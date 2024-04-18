<div>

<script src="{{ asset('assets/js/jquery-1.11.3.js') }}"></script>
<script src="{{ asset('assets/js/brackets.min.js') }}"></script>

<!-- <link rel="stylesheet" href="{{ asset('assets/css/jquery.bracket.min.css') }}" /> -->



<div class="d-flex mb-2 justify-content-end">
    <a class="btn btn-primary" href="{{ route('tournaments-categories', $category->tournament_id) }}">{{ $category->tournament->name }} Categories</a>
</div>

@foreach($category->knockoutStages as $knockoutStage)

@foreach($knockoutStage->games as $game)



@endforeach
@endforeach


<div class="brackets"></div>

<script>
var rounds;

rounds = [

  @foreach($category->knockoutStages as $knockoutStage)
  //-- round 1
  [

  @foreach($knockoutStage->games as $game)

    
      {
        player1: { name: "{{ $game->homeTeam?->nickname ??  $game->relatedHomeGame?->knockoutRound?->name }}", winner: true, ID: '{{ $game->homeTeam?->id }}' },
        player2: { name: "{{ $game->awayTeam?->nickname ??  $game->relatedAwayGame?->knockoutRound?->name }}", ID: '{{ $game->homeTeam?->id }}' }
      },

  @endforeach

  ],

  @endforeach  

  // //-- Champion
  
  [

      {
        player1: { name: "{{ $category->winnerTeam?->nickname ?? "N/A" }}", winner: true, ID: '{{ $category->winner_team_id }}' },
      },
  ],

  

];

var titles = [
  
  @foreach($category->knockoutStages as $knockoutStage) 
  
  '{{$knockoutStage->name}}', 
  
  @endforeach

];

$(".brackets").brackets({
  titles: titles,
  rounds: rounds,
  color_title: 'black',
  border_color: 'black',
  color_player: 'black',
  bg_player: 'white',
  color_player_hover: 'black',
  bg_player_hover: 'white',
  border_radius_player: '0px',
  border_radius_lines: '0px',
});

</script>






</div>
