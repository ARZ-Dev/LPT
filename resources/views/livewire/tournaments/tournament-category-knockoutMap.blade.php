<div>
	<div class="my_gracket">

    </div>


    @script
	<script type="text/javascript">
		(function(win, doc, $){

			win.TestData = [

				[

                    @foreach($category->knockoutsMatches as $key => $knockoutsMatches)

                        [
                            {"name" : "{{$knockoutsMatches->homeTeam?->nickname}}", "id" : "erik-zettersten", "seed" : 1},
                            {"name" : "{{$knockoutsMatches->awayTeam?->nickname}}", "seed" : 2}
                        ],

                    @endforeach

				],


			];

			$(".my_gracket").gracket({ src : win.TestData });

		})(window, document, jQuery);
	</script>
    @endscript


</div>
