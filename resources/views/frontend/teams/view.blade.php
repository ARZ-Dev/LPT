@extends('main')

@section('content')

    <section class="section section-md bg-gray-100">
        <div class="container">
            <div class="row row-30 d-flex">
                <div class="col-lg-8 col-sm-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">{{ $team->nickname }} Overview</h5>
                        </div>
                    </article>
                    <!-- Player Info Corporate-->
                    <div class="player-info-corporate">
                        <div class="player-info-figure">
                            <div class="player-img">
                                <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($team->image)) }}" alt="" width="368" height="286"/>
                            </div>
                        </div>
                        <div class="player-info-main">
                            <h4 class="player-info-title">General Info</h4>
                            <hr/>
                            <div class="player-info-table">
                                <div class="table-custom-wrap">
                                    <table class="table-custom">
                                        <tr>
                                            <td>Nickname</td>
                                            <td>{{ $team->nickname }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-nowrap">Level Category</td>
                                            <td>{{ $team->levelCategory?->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Players</td>
                                            <td>{{ implode(', ', $team->players->pluck('full_name')->toArray()) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">Team Stats
                            </h5>
                        </div>
                    </article>
                    <div class="table-custom-responsive">
                        <table class="table-custom table-custom-bordered table-team-statistic">
                            <tr>
                                <td>
                                    <p class="team-statistic-counter">{{ $team->rank }}</p>
                                    <p class="team-statistic-title">Rank</p>
                                </td>
                                <td>
                                    <p class="team-statistic-counter">{{ $team->points }}</p>
                                    <p class="team-statistic-title">Points</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="team-statistic-counter">{{ $team->wins }}</p>
                                    <p class="team-statistic-title">Wins</p>
                                </td>
                                <td>
                                    <p class="team-statistic-counter">{{ $team->losses }}</p>
                                    <p class="team-statistic-title">Losses</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">Tournaments Records
                            </h5>
                        </div>
                    </article>
                    <div class="table-custom-responsive">
                        <table class="table-custom table-standings table-modern table-custom-striped">
                            <thead>
                            <tr>
                                <th>Tournament</th>
                                <th>Last Rank</th>
                                <th>Score</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($team->rankings as $ranking)
                                <tr>
                                    <td class="text-nowrap">{{ $ranking->tournamentLevelCategory?->tournament->name }} - {{ $ranking->tournamentLevelCategory?->levelCategory?->name }}</td>
                                    <td>{{ $ranking->last_rank }}</td>
                                    <td>{{ $ranking->score }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <th>Not available yet.</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>

    </script>
@endsection
