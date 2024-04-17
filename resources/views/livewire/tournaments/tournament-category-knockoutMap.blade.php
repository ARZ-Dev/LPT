<div>
<script src="{{ asset('assets/js/jquery-1.6.2.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/jquery.bracket.min.css') }}" />
<script src="{{ asset('assets/js/jquery.bracket.min.js') }}"></script>


<div class="d-flex mb-2 justify-content-end">
    <a class="btn btn-primary" href="{{ route('tournaments-categories', $category->tournament_id) }}">{{ $category->tournament->name }} Categories</a>
</div>

@foreach($category->knockoutsMatches as $teams)

{{$teams->homeTeam?->nickname}}
@endforeach

<div class="tournament"></div>
<script>
var singleElimination = {
  "teams": [              // Matchups
    ["Team 1", "Team 2"], // First match
    ["Team 3", "Team 4"]  // Second match
  ],
  "results": [            // List of brackets (single elimination, so only one bracket)
    [                     // List of rounds in bracket
      [                   // First round in this bracket
        [1, 2],           // Team 1 vs Team 2
        [3, 4]            // Team 3 vs Team 4
      ],
      [                   // Second (final) round in single elimination bracket
        [5, 6],           // Match for first place
        [7, 8]            // Match for 3rd place
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
