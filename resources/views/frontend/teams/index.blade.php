@extends('main')

@section('content')
    <!-- Section Table and Game Result-->
    <section class="section section-sm bg-gray-100">
        <div class="container">
            <div class="row row-50">
                @foreach($levelCategories as $levelCategory)
                    <div class="col-lg-6 col-xl-6 col-sm-12">
                        <!-- Heading Component-->
                        <article class="heading-component">
                            <div class="heading-component-inner">
                                <h5 class="heading-component-title">{{ $levelCategory->name }} Standings</h5>
                            </div>
                        </article>
                        <!-- Table Players-->
                        <div class="table-custom-responsive overflow-x-auto" style="height: 500px">
                            <table class="table-custom table-standings table-modern dataTable">
                                <thead>
                                <tr>
                                    <th colspan="2">Team Position</th>
                                    <th>P</th>
                                    <th>W</th>
                                    <th>L</th>
                                    <th>Pts</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($levelCategory->teams as $team)
                                    <tr>
                                        <td><span class="table-counter">{{ $team->rank }}</span></td>
                                        <td class="player-inline">
                                            <div class="player-title">
                                                <div class="player-name">{{ $team->nickname }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $team->matches }}</td>
                                        <td>{{ $team->wins }}</td>
                                        <td>{{ $team->losses }}</td>
                                        <td>{{ $team->points }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
