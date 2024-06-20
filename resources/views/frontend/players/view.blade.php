@extends('main')

@section('content')

    <section class="section section-md bg-gray-100">
        <div class="container">
            <div class="row row-30">
                <div class="col-lg-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">{{ $player->full_name }} Overview</h5>
                        </div>
                    </article>
                    <!-- Player Info Corporate-->
                    <div class="player-info-corporate">
                        <div class="player-info-main">
                            <h4 class="player-info-title">General Info</h4>
                            <hr/>
                            <div class="player-info-table">
                                <div class="table-custom-wrap">
                                    <table class="table-custom">
                                        <tr>
                                            <td>Country</td>
                                            <td>{{ $player->country?->name }}</td>
                                            <th>Gender</th>
                                            <th>{{ $player->gender }}</th>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <th>{{ \Carbon\Carbon::parse($player->birthdate)->age }}</th>
                                            <td>Nickname</td>
                                            <td>{{ $player->nickname }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <!-- Player Info Corporate-->
                    <div class="player-info-corporate">
                        <div class="player-info-main">
                            <h4 class="player-info-title">Career Info</h4>
                            <hr/>
                            <div class="player-info-table">
                                <div class="table-custom-wrap">
                                    <table class="table-custom">
                                        <tr>
                                            <th>Current Team</th>
                                            <th>{{ $player->currentTeam?->nickname }}</th>
                                            <th>Playing Side</th>
                                            <th>{{ $player->playing_side }}</th>
                                        </tr>
                                        <tr>
                                            <th>Rank</th>
                                            <th>{{ $player->rank }}</th>
                                            <th>Matches Played</th>
                                            <th>{{ $player->matches }}</th>
                                        </tr>
                                        <tr>
                                            <th>Losses</th>
                                            <th>{{ $player->losses }}</th>
                                            <th>Wins</th>
                                            <th>{{ $player->wins }}</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  Block Player Info-->
                    <div class="block-player-info">
                        <h4>Teams</h4>
                        <article class="quote-modern">
                            <div class="quote-modern-text">
                                <p>
                                    {{ implode(', ', $player->teams->pluck('nickname')->toArray()) }}
                                </p>
                            </div>
                        </article>
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
