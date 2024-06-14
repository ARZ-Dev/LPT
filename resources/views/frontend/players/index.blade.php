@extends('main')

@section('content')

    <section class="section section-sm bg-gray-100">
        <div class="container">
            <!-- Heading Component-->
            <article class="heading-component">
                <div class="heading-component-inner">
                    <h5 class="heading-component-title">All Players</h5>
                </div>
            </article>
            <div class="row row-30">
                @foreach($players as $player)
                    <div class="col-sm-6 col-lg-4 d-flex">
                        <a href="{{ route('frontend.players.view', $player->id) }}" class="d-flex flex-column w-100">
                            <!-- Player Info Modern-->
                            <div class="player-info-modern-footer flex-grow-1">
                                <div class="player-info-modern-content">
                                    <div class="player-info-modern-title">
                                        <h5>{{ $player->full_name }}</h5>
                                        <p>{{ $player->playing_side }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

@endsection

@section('script')
<script>

</script>
@endsection
