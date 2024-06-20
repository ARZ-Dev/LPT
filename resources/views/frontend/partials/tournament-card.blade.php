<article class="game-result">
    <div class="game-info game-info-classic">
        <p class="game-info-subtitle">
            From {{ Carbon\Carbon::parse($tournament->start_date)->format('d M') }} To {{ Carbon\Carbon::parse($tournament->end_date)->format('d M Y') }}
        </p>
        <h3 class="game-info-title">{{ $tournament->name }}</h3>
        <!-- Table Game Info-->
        <div class="table-game-info-wrap">
            <span class="table-game-info-title">Categories</span>
            <div class="table-game-info-main table-custom-responsive">
                <table class="table-custom table-game-info">
                    <tbody>
                    @foreach($tournament->levelCategories as $levelCategory)
                        <tr>
                            <td class="table-game-info-category">
                                {{ $levelCategory->levelCategory->name }}
                            </td>
                            <td class="text-nowrap">
                                <a class="button button-xs button-primary" href="{{ route('frontend.tournaments.categories.view', $levelCategory->id) }}">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</article>
