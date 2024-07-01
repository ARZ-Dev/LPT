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
                                <h5 class="heading-component-title">{{ $levelCategory->name }} Teams</h5>
                            </div>
                        </article>
                        <!-- Table Players-->
                        <div class="table-custom-responsive overflow-x-auto" style="height: {{ count($levelCategory->teams) > 5 ? "500px" : "auto" }}">
                            <table class="table-custom table-standings table-modern table-custom-striped">
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
                                        <td>{{ $team->rank }}</td>
                                        <td class="team-inline">
                                            @if($team->image)
                                            <div class="team-figure">
                                                <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($team->image)) }}" alt="" width="60" height="41">
                                            </div>
                                            @endif
                                            <div class="team-title">
                                                <div class="team-name">{{ $team->nickname }}</div>
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
