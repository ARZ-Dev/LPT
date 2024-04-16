<div>

    <link rel="stylesheet" href="{{ asset('assets/css/gracket.css') }}" />
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/test.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.gracket.min.js') }}"></script>


<a  href="{{ route('tournaments-categories', $category->tournament_id) }}"class="btn btn-primary mb-2 text-nowrap">{{ $category->name }} Categories</a>

	<div class="my_gracket"></div>



	<script type="text/javascript">
		(function(win, doc, $){

			win.TestData = [

                /////////////// Semi Final
				[
                @foreach($category->knockoutsMatches as  $knockoutsMatches)

					[ 
                        {"name" : "{{$knockoutsMatches->winnerTeam->nickname}}", "id" : "erik-zettersten", "seed" : 1},
                        {"name" : "{{$knockoutsMatches->looserTeam->nickname}}", "seed" : 2} 
                    ],
			
                @endforeach

				],
                
	
			];


			$(".my_gracket").gracket({ src : win.TestData });

		})(window, document, jQuery);
	</script>


</div>
