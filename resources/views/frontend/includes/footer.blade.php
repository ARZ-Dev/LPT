<!-- Page Footer-->
<footer class="section footer-corporate context-dark">
    <div class="footer-corporate-main">
        <div class="container">
            <div class="row row-50 justify-content-center justify-content-md-between">
                <div class="col-md-5"><a class="brand" href="{{ route('home') }}"><img class="brand-logo " src="{{ asset('assets/frontend/images/tennis/logo-default-144x126.png') }}" alt="" width="144" height="126"/></a>
                    <p class="lh-15 ls-normal">Tennis Blastship connects everyone passionate about tennis. Established in 2005, our website has been providing the best news and updates for tennis fans. From recent tennis matches to event announcements, we cover everything you may want to know about.</p>
                    <ul class="list-sm mt-4">
                        <li>
                            <div class="unit unit-horizontal unit-spacing-xs align-items-center">
                                <div class="unit-left"><span class="icon align-middle icon-xs-big icon-primary icomoon-phone"></span></div>
                                <div class="unit-body"><a class="heading-4 link-light ls-normal" href="tel:#">+1 234 567 8901</a></div>
                            </div>
                        </li>
                        <li>
                            <div class="unit unit-horizontal unit-spacing-xs align-items-center">
                                <div class="unit-left"><span class="icon align-middle icon-xs-big icon-primary icomoon-mail"></span></div>
                                <div class="unit-body"><a class="link-light ls-normal" href="mailto:#">info@arzgt.com</a></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="row row-50">
                        <div class="col-6 col-lg-4">
                            <h6 class="footer-corporate-title">Quick Links</h6>
                            <ul class="list-xxs">
                                <li><a class="link-light" href="{{ route('home') }}">Home</a></li>
                                <li><a class="link-light" href="{{ route('frontend.tournaments') }}">Tournaments</a></li>
                                <li><a class="link-light" href="{{ route('frontend.matches') }}">Matches</a></li>
                                <li><a class="link-light" href="{{ route('frontend.teams') }}">Teams</a></li>
                                <li><a class="link-light" href="{{ route('frontend.players') }}">Players</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-lg-4">
                            <h6 class="footer-corporate-title">Categories</h6>
                            <ul class="list-xxs">
                                @php($levelCategories = \App\Models\LevelCategory::all())
                                @foreach($levelCategories as $levelCategory)
                                    <li>
                                        <a class="link-light" href="{{ route('frontend.tournaments', $levelCategory->id) }}">{{ $levelCategory->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <h6 class="footer-corporate-title">Social</h6>
                            <ul class="list-xxs">
                                <li><a class="link-light" href="#">Facebook</a></li>
                                <li><a class="link-light" href="#">YouTube</a></li>
                                <li><a class="link-light" href="#">Instagram</a></li>
                                <li><a class="link-light" href="#">Twitter</a></li>
                                <li><a class="link-light" href="#">LinkedIn</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-corporate-aside">
        <div class="container">
            <p class="rights"><span>LPT</span><span>&nbsp;&copy;&nbsp;</span><span class="copyright-year"></span><span>.&nbsp;</span><a class="link-underline" href="privacy-policy.html">Privacy Policy</a></p>
            <p class="small ls-normal text-gray-500">The content provided on our tennis news site is for general informational purposes only. While we strive to ensure the accuracy and reliability of the information presented, we cannot guarantee that all information is up to date, complete, or accurate.</p>
        </div>
    </div>
</footer>
