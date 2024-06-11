@extends('main')

@section('content')

    <!-- Section Breadcrumbs-->
    <section class="section parallax-container breadcrumbs-wrap" data-parallax-img="images/bg-breadcrumbs-1-1920x726.jpg">
        <div class="parallax-content breadcrumbs-custom context-dark">
            <div class="container">
                <h3 class="breadcrumbs-custom-title">404</h3>
                <ul class="breadcrumbs-custom-path">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">Features</a></li>
                    <li class="active">404</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Section Gallery-->
    <section class="section section-variant-1 bg-gray-100 text-center">
        <div class="container">
            <div class="row row-30 justify-content-center">
                <div class="col-xl-10"><span class="icon-xl icon-gray-400 mdi mdi-emoticon-sad"></span>
                    <h2><span class="text-primary">Oops!</span> Page Not found</h2>
                    <p class="big text-gray-800">You may have mistyped the address or the page may have moved.</p><a class="button button-lg button-primary" href="./">Go to home page</a>
                </div>
            </div>
        </div>
    </section>

@endsection
