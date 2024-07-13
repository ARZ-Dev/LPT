@extends('main')

@section('content')

    <section class="section section-sm bg-gray-100">
        <div class="container">
            <div class="row row-50">
                <div class="col-lg-12">
                    <!-- Heading Component-->
                    <article class="heading-component">
                        <div class="heading-component-inner">
                            <h5 class="heading-component-title">Matches schedule
                            </h5>
                            <div class="heading-component-aside">
                                <form id="filtersForm">
                                @csrf
                                    <ul class="list-inline list-inline-xs list-inline-middle">
                                        <li>
                                            <select name="level_category_id" class="select filter-input" data-placeholder="Select an option" data-container-class="select-minimal-xl">
                                                <option label="placeholder"></option>
                                                <option value="All Categories" selected="">All Categories</option>
                                                @foreach($levelCategories as $levelCategory)
                                                    <option value="{{ $levelCategory->id }}">{{ $levelCategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </li>
                                        <li>
                                            <select name="month" class="select filter-input" data-placeholder="Select an option" data-container-class="select-minimal-xs">
                                                <option label="placeholder"></option>
                                                <option value="All">All</option>
                                                <option value="1" {{ now()->month == "1" ? "selected" : "" }}>January</option>
                                                <option value="2" {{ now()->month == "2" ? "selected" : "" }}>February</option>
                                                <option value="3" {{ now()->month == "3" ? "selected" : "" }}>March</option>
                                                <option value="4" {{ now()->month == "4" ? "selected" : "" }}>April</option>
                                                <option value="5" {{ now()->month == "5" ? "selected" : "" }}>May</option>
                                                <option value="6" {{ now()->month == "6" ? "selected" : "" }}>June</option>
                                                <option value="7" {{ now()->month == "7" ? "selected" : "" }}>July</option>
                                                <option value="8" {{ now()->month == "8" ? "selected" : "" }}>August</option>
                                                <option value="9" {{ now()->month == "9" ? "selected" : "" }}>September</option>
                                                <option value="10" {{ now()->month == "10" ? "selected" : "" }}>October</option>
                                                <option value="11" {{ now()->month == "11" ? "selected" : "" }}>November</option>
                                                <option value="12" {{ now()->month == "12" ? "selected" : "" }}>December</option>
                                            </select>
                                        </li>
                                        <li>
                                            <select name="year" class="select filter-input" data-placeholder="Select an option" data-container-class="select-minimal-xs">
                                                <option label="placeholder"></option>
                                                <option value="{{ now()->subYear()->format('Y') }}">{{ now()->subYear()->format('Y') }}</option>
                                                <option value="{{ now()->format('Y') }}" selected="">{{ now()->format('Y') }}</option>
                                                <option value="{{ now()->addYear()->format('Y') }}">{{ now()->addYear()->format('Y') }}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </article>
                    <div id="matches-container">
                        <div class="d-flex justify-content-center d-none" id="spinner-container">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div id="matches">
                            @forelse($matches as $match)
                                @include('frontend.partials.match-card', ['match' => $match])
                            @empty
                                <div class="d-flex justify-content-center">
                                    <h6>No matches available.</h6>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
<script>
    $(document).on('change', '.filter-input', function () {
        let matchesDivSelector = $('#matches');
        let spinnerContainer = $('#spinner-container');

        matchesDivSelector.empty();
        spinnerContainer.removeClass('d-none')
        $.ajax({
            url: "{{ route('frontend.get-matches') }}",
            method: 'post',
            processing: true,
            serverSide: true,
            cache: true,
            processData: false,
            contentType: false,
            dataType: 'json',
            data: new FormData(document.getElementById('filtersForm')),
            success: function(data)
            {
                let matchesHtml = data.matchesHtml;
                matchesDivSelector.append(matchesHtml);
            },
            error: function (xhr, textStatus, errorThrown) {
                ajax_error_display(xhr, textStatus, errorThrown);
            }
        }).always(function() {
            spinnerContainer.addClass('d-none')
        });
    })

    document.addEventListener("DOMContentLoaded", function() {

        $('.matches').each(function () {
            var matchId = $(this).data('match-id');

            // var channel = Echo.channel('match' + matchId);
            // channel.listen('.ScoreUpdated', function(data) {
            //     let scoreContainer = $('#match-score-container-' + matchId);
            //     console.log("data")
            //     console.log(data)
            // });

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('134e03ea8967bdc8deb7', {
                cluster: 'eu'
            });

            var channel = pusher.subscribe('match' + matchId);
            channel.bind('ScoreUpdated', function(data) {
                alert(JSON.stringify(data));
            });

            console.log('test')
        })
    });

</script>
@endsection
