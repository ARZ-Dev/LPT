@extends('main')

@section('content')

    <section class="section section-md bg-gray-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">{{ $category->tournament?->name }} - {{ $category->levelCategory?->name }} Overview
                            </h5>
                        </div>
                    </article>
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-statictics">
                                <li>
                                    <a href="#">Start Date</a>
                                    <span class="list-statictics-counter">{{ Carbon\Carbon::parse($category->start_date)->format('d M Y') }}</span>
                                </li>
                                <li>
                                    <a href="#">End Date</a>
                                    <span class="list-statictics-counter">{{ Carbon\Carbon::parse($category->end_date)->format('d M Y') }}</span>
                                </li>
                                <li>
                                    <a href="#">Type</a>
                                    <span class="list-statictics-counter">{{ $category->type?->name }}</span>
                                </li>
                                <li>
                                    <a href="#">Number of Teams</a>
                                    <span class="list-statictics-counter">{{ $category->number_of_teams }}</span>
                                </li>
                                @if($category->has_group_stage)
                                <li>
                                    <a href="#">Number of Groups</a>
                                    <span class="list-statictics-counter">{{ $category->number_of_groups }}</span>
                                </li>
                                <li>
                                    <a href="#">Number of Winners per Group</a>
                                    <span class="list-statictics-counter">{{ $category->number_of_winners_per_group }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">{{ $category->type?->name }} Settings</h5>
                        </div>
                    </article>
                    <!-- Table Players-->
                    <div class="table-custom-responsive">
                        <table class="table-custom table-standings table-modern">
                            <thead>
                            <tr>
                                <th class="text-nowrap">Stage</th>
                                <th class="text-nowrap">Points</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($category->type->settings as $setting)
                                <tr>
                                    <td class="text-nowrap">{{ $setting->stage }}</td>
                                    <td class="text-nowrap">{{ $setting->points }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if(count($category->knockoutStages))
        <div class="container">
            <div class="row">
                    <div class="col-12">
                        <!-- Heading Component-->
                        <article class="heading-component">
                            <div class="heading-component-inner">
                                <h5 class="heading-component-title">Stage Settings</h5>
                            </div>
                        </article>
                        <!-- Table Players-->
                        <div class="table-custom-responsive">
                            <table class="table-custom table-standings table-modern">
                                <thead>
                                <tr>
                                    <th class="text-nowrap">Stage</th>
                                    <th class="text-nowrap">Deuce Type</th>
                                    <th class="text-nowrap">Nb of Sets to Win the Match</th>
                                    <th class="text-nowrap">Nb of Games to Win the Set</th>
                                    <th class="text-nowrap">Tiebreak</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($category->knockoutStages as $stage)
                                    <tr>
                                        <td>{{ $stage->name }}</td>
                                        <td>{{ $stage->tournamentDeuceType?->name ?? "N/A" }}</td>
                                        <td>{{ $stage->nb_of_sets ?? "N/A" }}</td>
                                        <td>{{ $stage->nb_of_games ?? "N/A" }}</td>
                                        <td>{{ $stage->tie_break ?? "N/A" }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
        @endif

        @if(count($category->groups))
        <div class="container">
            <div class="row">
                @foreach($category->groups as $group)
                    <div class="col-lg-6 col-xl-4">
                        <!-- Heading Component-->
                        <article class="heading-component">
                            <div class="heading-component-inner">
                                <h5 class="heading-component-title">{{ $group->name }}</h5>
                            </div>
                        </article>
                        <!-- Table Players-->
                        <div class="table-custom-responsive">
                            <table class="table-custom table-standings table-modern">
                                <thead>
                                <tr>
                                    <th colspan="2">Team Position</th>
                                    <th>P</th>
                                    <th>W</th>
                                    <th>L</th>
                                    <th>+/-</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($group->groupTeams as $groupTeam)
                                    <tr style="background-color: {{ $groupTeam->has_qualified ? "#C7F6C7" : "" }}">
                                        <td>
                                            <span class="table-counter">{{ $groupTeam->rank }}</span>
                                        </td>
                                        <td class="player-inline">
                                            <div class="player-title">
                                                <div class="player-name">{{ $groupTeam->team?->nickname }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $groupTeam->matches_played }}</td>
                                        <td>{{ $groupTeam->wins }}</td>
                                        <td>{{ $groupTeam->losses }}</td>
                                        <td>{{ $groupTeam->score }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">Matches</h5>
                        </div>
                    </article>
                    <!-- Table Players-->
                    <div class="table-custom-responsive overflow-x-auto" style="height: 500px">
                        <table class="table-custom table-standings table-modern">
                            <thead>
                            <tr>
                                <th>Group / Round</th>
                                <th>Home Team</th>
                                <th>Away Team</th>
                                <th>Datetime</th>
                                <th>Winner Team</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($matches as $match)
                            <tr>
                                <td class="text-nowrap">{{ $match->type == "Knockouts" ? $match->knockoutRound?->name : $match->group?->name }}</td>

                                <td>
                                    @if($match->homeTeam)
                                        {{ $match->homeTeam->nickname }}
                                    @elseif($match->relatedHomeGame)
                                        Winner of {{ $match->relatedHomeGame->knockoutRound?->name }}
                                    @endif
                                </td>
                                <td>
                                    @if($match->awayTeam)
                                        {{ $match->awayTeam->nickname }}
                                    @elseif($match->relatedAwayGame)
                                        Winner of {{ $match->relatedAwayGame->knockoutRound?->name }}
                                    @endif
                                </td>
                                <td class="text-nowrap">{{ $match->datetime }}</td>
                                <td>{{ $match->winnerTeam?->nickname }}</td>
                                <td>
                                    @php($badgeLabel = "secondary")
                                    @if($match->status == "started")
                                        @php($badgeLabel = "blue")
                                    @elseif($match->status == "completed")
                                        @php($badgeLabel = "green")
                                    @elseif($match->status == "forfeited")
                                        @php($badgeLabel = "red")
                                    @endif
                                    <div class="badge badge-{{ $badgeLabel }}">
                                        {{ ucfirst($match->status) }}
                                    </div>
                                </td>
                            </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')

@endsection
