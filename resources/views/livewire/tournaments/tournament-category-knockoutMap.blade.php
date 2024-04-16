<div>

<head>
    <link rel="stylesheet" href="{{ asset('assets/css/gracket.css') }}" />
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/test.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.gracket.min.js') }}"></script>
</head>

<body>

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
                
				[
                @foreach($final->knockoutsMatches as  $knockoutsMatches)

                [
                    {"name" : "{{$knockoutsMatches->winnerTeam->nickname}}", "id" : "erik-zettersten", "seed" : 3},
                    {"name" : "{{$knockoutsMatches->looserTeam->nickname}}", "id" : "ryan-anderson", "seed" : 4}
                ],
                @endforeach

				],

				[
                @foreach($final->knockoutsMatches as  $knockoutsMatches)

					[ 
                        {"name" : "{{$knockoutsMatches->winnerTeam->nickname}}", "id" : "erik-zettersten", "seed" : 5} 
                    ]
                @endforeach

				]
			];


			$(".my_gracket").gracket({ src : win.TestData });

		})(window, document, jQuery);
	</script>

	<script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
</body>


</div>
