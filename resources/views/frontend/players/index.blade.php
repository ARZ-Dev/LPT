@extends('main')

@section('content')

    <section class="section section-sm bg-gray-100">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-8">
                    <div class="row row-50">
                        <div class="col-sm-12">
                            <!-- Heading Component-->
                            <article class="heading-component">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">All Players
                                    </h5>
                                </div>
                            </article>
                            <!-- Game Result Bug-->
                            <div class="row row-30">
                                @foreach($players as $player)
                                    <div class="col-sm-6 col-lg-4 d-flex">
                                        <a href="{{ route('frontend.players.view', $player->id) }}" class="d-flex flex-column w-100">
                                            <!-- Player Info Modern-->
                                            <div class="player-info-modern-footer flex-grow-1">
                                                <div class="player-info-modern-content">
                                                    <div class="player-info-modern-title">
                                                        <h5>{{ $player->nickname }}</h5>
                                                        <p>Rank {{ $player->rank }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="row row-50">
                        <div class="col-md-6 col-lg-12">
                            <!-- Heading Component-->
                            <article class="heading-component">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Player Standings
                                    </h5>
                                </div>
                            </article>
                            <!-- Game Highlights-->
                            <!-- Table Players-->
                            <div class="table-custom-responsive overflow-x-auto" style="height: {{ count($players) > 5 ? "500px" : "auto" }}">
                                <table class="table-custom table-standings table-modern dataTable">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Player Position</th>
                                        <th>P</th>
                                        <th>W</th>
                                        <th>L</th>
                                        <th>Pts</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($players as $player)
                                        <tr>
                                            <td><span class="table-counter">{{ $player->rank }}</span></td>
                                            <td class="player-inline">
                                                <div class="player-title">
                                                    <div class="player-name">{{ $player->nickname }}</div>
                                                </div>
                                            </td>
                                            <td>{{ $player->matches }}</td>
                                            <td>{{ $player->wins }}</td>
                                            <td>{{ $player->losses }}</td>
                                            <td>{{ $player->points }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
