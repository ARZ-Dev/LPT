<x-layouts.base>

    @guest
        {{ $slot }}
    @endguest

    <!-- Layout wrapper -->


    
    <div class="layout-wrapper layout-content-navbar">

        @auth

        <div class="layout-container">
           {{-- @php
                $currentRoute = request()->route()->getName();
            @endphp
            @if(!in_array($currentRoute, [
                'monthly-openings-closings',
                'monthly-openings-closings.create',
                'monthly-openings-closings.edit',
                'monthly-openings-closings.view',
                'payment',
                'payment.create',
                'payment.edit',
                'payment.view',
                'receipt',
                'receipt.create',
                'receipt.edit',
                'receipt.view',
                'transfer',
                'transfer.create',
                'transfer.edit',
                'transfer.view',
                'transfer.confirm',
                'exchange',
                'exchange.create',
                'exchange.edit',
                'exchange.view',
            ])) --}}
                @include('components.sidebar')

                <!-- Layout container -->
                <div class="layout-page">

                    <!-- Navbar -->
                    @include('components.navbar')
                    <!-- / Navbar -->
           {{-- @endif --}}

                    <!-- Content wrapper -->
                    <div class="content-wrapper">

                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            {{ $slot }}
                        </div>

                        <!-- Footer -->
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl">
                                <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                    <div>
                                        lpt © <?php echo date('Y'); ?>. All Rights Reserved.
                                    </div>
                                    <div>
                                        Designed & Developed by <a href="https://lpt.com" target="_blank" class="fw-semibold">lpt</a>
                                    </div>
                                </div>
                            </div>
                        </footer>

                        <div class="content-backdrop fade"></div>

                    </div>

                </div>

            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>

        @endauth
    </div>
    <!-- / Layout wrapper -->
</x-layouts.base>
