<div>
<script src="{{ asset('assets/js/jquery-1.6.2.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/jquery.bracket.min.css') }}" />
<script src="{{ asset('assets/js/jquery.bracket.min.js') }}"></script>


<div class="d-flex mb-2 justify-content-end">
    <a class="btn btn-primary" href="{{ route('tournaments-categories', $category->tournament_id) }}">{{ $category->tournament->name }} Categories</a>
</div>



<div class="tournament"></div>
<script>
var singleElimination = {
  "teams": [              
    @foreach($category->knockoutsMatches as $teams)

    ["{{$teams->homeTeam->nickname ?? 'Unknown' }}", "{{$teams->awayTeam->nickname ?? 'Unknown' }}"], 
    @endforeach
  ],

  "results": [            
    [                   
      [  
    @foreach($category->knockoutsMatches as $teams)
    @if($teams->homeTeam?->id == $teams->winnerTeam?->id )

        [1, 0],

        @else

        [0, 0],

        @endif

    @endforeach

      ],
      [   
                      
        @foreach($semiFinal->knockoutsMatches as $teams)
        @if($teams->homeTeam?->id == $teams->winnerTeam?->id )

          [1, 0],

          @else

          [0, 0],

          @endif
        @endforeach              
      ],
      [                   
        @foreach($semiFinal->knockoutsMatches as $teams)
        @if($teams->homeTeam?->id == $teams->winnerTeam?->id )

          [1, 0],

          @else

          [0, 0],

          @endif
        @endforeach  
      ]
    ]
  ]

}

$('.tournament').bracket({
  init: singleElimination
});

// $('.demo').bracket({
//   init: null, // data to initialize
//   save: null, // called whenever bracket is modified
//   userData: null, // custom user data
//   onMatchClick: null, // callback
//   onMatchHover: null, // callback
//   decorator: null, // a function
//   skipSecondaryFinal: false,
//   skipGrandFinalComeback: false,
//   skipConsolationRound: false,
//   dir: 'rl', // "rl" or  "lr",
//   disableToolbar: false,
//   disableTeamEdit: false,
//   teamWidth: '', // number
//   scoreWidth: '', // number
//   roundMargin: '', // number
//   matchMargin: '', // number
// });



    </script>




</div>
