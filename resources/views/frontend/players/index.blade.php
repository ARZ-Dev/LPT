@extends('main')

@section('content')

    <section class="section section-sm bg-gray-100">
        <div class="container">
            <div class="row row-50">
                <div class="col-12">
                    <div class="row row-50">
                        <div class="col-sm-12">
                            <!-- Heading Component-->
                            <article class="heading-component">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Men Players
                                    </h5>
                                </div>
                            </article>
                            <div class="row row-30">
                                @foreach($malePlayers as $player)
                                    <div class="col-sm-6 col-lg-4 d-flex">
                                        <a href="{{ route('frontend.players.view', $player->id) }}" class="d-flex flex-column w-100">
                                            <!-- Player Info Modern-->
                                            <div class="player-info-modern-footer flex-grow-1">
                                                @if($player->image)
                                                    <img src="{{  \Illuminate\Support\Facades\Storage::url($player->image) }}" alt="" style="width: 35%"/>
                                                @endif
                                                <div class="player-info-modern-content">
                                                    <div class="player-info-modern-title">
                                                        <h5>{{ $player->first_name }} {{ $player->last_name }}</h5>
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
                    <div class="row row-50">
                        <div class="col-sm-12">
                            <!-- Heading Component-->
                            <article class="heading-component">
                                <div class="heading-component-inner">
                                    <h5 class="heading-component-title">Women Players
                                    </h5>
                                </div>
                            </article>
                            <div class="row row-30">
                                @foreach($femalePlayers as $player)
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
            </div>
        </div>
    </section>

@endsection

@section('script')
<script>

</script>
@endsection
