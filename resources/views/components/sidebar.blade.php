<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

	<div class="app-brand demo">
		<a href="{{url('dashboard')}}" class="app-brand-link">
			<span class="app-brand-logo demo">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">LPT</span>
		</a>

		<a id="toggleButton" href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
			<i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
			<i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
		</a>
	</div>


	<div class="menu-inner-shadow"></div>

	<ul class="menu-inner py-1">

        <li class="menu-item {{ request()->is('admin/dashboard') ? "active" : "" }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        @canany(['role-list', 'permission-list', 'user-list'])
        <li class="menu-item {{ request()->is('admin/roles') || request()->is('admin/permissions') || request()->is('admin/users*') || request()->is('admin/tournament-types*') ? "active open" : "" }}">

			<a href="javascript:void(0);" class="menu-link menu-toggle">
			    <i class="menu-icon tf-icons ti ti-settings"></i>
			    <div data-i18n="Settings">Settings</div>
			</a>

			<ul class="menu-sub">

                @can('role-list')
                <li class="menu-item {{ request()->is('admin/roles') ? "active" : "" }}">
                    <a href="{{ route('roles') }}" class="menu-link">
                    <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
                @endcan

                @can('permission-list')
                <li class="menu-item {{ request()->is('admin/permissions') ? "active" : "" }}">
                    <a href="{{ route('permissions') }}" class="menu-link">
                    <div data-i18n="Permissions">Permissions</div>
                    </a>
                </li>
                @endcan

                @can('user-list')
				<li class="menu-item {{ request()->is('admin/users*') ? "active" : "" }}">
					<a href="{{ route('users') }}" class="menu-link">
						<div data-i18n="Users">Users</div>
					</a>
				</li>
                @endcan

                @can('tournamentType-list')
                    <li class="menu-item {{ request()->is('admin/tournament-types*') ? "active" : "" }}">
                        <a href="{{ route('types') }}" class="menu-link">
                            <div data-i18n="Tournament Types">Tournament Types</div>
                        </a>
                    </li>
                @endcan
			</ul>
		</li>
        @endcanany

        @canany(['category-list', 'currency-list'])
        <li class="menu-item {{ request()->is('admin/category*', 'admin/currency*') ? 'active open' : '' }}">

			<a href="javascript:void(0);" class="menu-link menu-toggle">
				<i class="menu-icon tf-icons ti ti-file-settings"></i>
				<div data-i18n="Petty Cash Settings">Petty Cash Settings</div>
			</a>

            <ul class="menu-sub">
                @can('category-list')
                    <li class="menu-item {{ request()->is('admin/category*') ? 'active' : '' }}">
                        <a href="{{ route('category') }}" class="menu-link">
                            <div data-i18n="Category">Category</div>
                        </a>
                    </li>
                @endcan

                @can('currency-list')
                    <li class="menu-item {{ request()->is('admin/currency*') ? "active" : "" }}">
                        <a href="{{ route('currency') }}" class="menu-link">
                            <div data-i18n="Currency">Currency</div>
                        </a>
                    </li>
                @endcan
            </ul>
		</li>
        @endcanany

        @can('pettyCashSummary-view')
        <li class="menu-item {{ request()->is('admin/petty-cash-summary*', 'admin/till*', 'admin/monthly-openings-closings*', 'admin/payment*', 'admin/receipt*', 'admin/transfer*', 'admin/exchange*') ? "active" : "" }}">
            <a href="{{ route('petty-cash-summary') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-premium-rights"></i>
                <div data-i18n="Petty Cash">Petty Cash</div>
            </a>
        </li>
        @endcan

        @can('team-list')
            <li class="menu-item {{ request()->is('admin/teams*') ? "active" : "" }}">
                <a href="{{ route('teams') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Teams">Teams</div>
                </a>
            </li>
        @endcan

        @can('player-list')
        <li class="menu-item {{ request()->is('admin/players*') ? "active" : "" }}">
            <a href="{{ route('players') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Players">Players</div>
            </a>
        </li>
        @endcan

        @can('court-list')
        <li class="menu-item {{ request()->is('admin/courts*') ? "active" : "" }}">
            <a href="{{ route('courts') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-globe"></i>
                <div data-i18n="Courts">Courts</div>
            </a>
        </li>
        @endcan

        @can('tournament-list')
        <li class="menu-item {{ request()->is('admin/tournaments*') ? "active" : "" }}">
            <a href="{{ route('tournaments') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-tournament"></i>
                <div data-i18n="Tournaments">Tournaments</div>
            </a>
        </li>
        @endcan

        @can('matches-list')
            <li class="menu-item {{ request()->is('admin/my-matches*') ? "active" : "" }}">
                <a href="{{ route('matches') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-device-gamepad-2"></i>
                    <div data-i18n="My Matches">My Matches</div>
                </a>
            </li>
        @endcan

        <li class="menu-item {{ request()->is('admin/hero-section*', 'admin/blogs*') ? 'active open' : '' }}">

            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-webhook"></i>
                <div data-i18n="Frontend">Frontend</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('admin/hero-sections*') ? 'active' : '' }}">
                    <a href="{{ route('hero-sections') }}" class="menu-link">
                        <div data-i18n="Hero Sections">Hero Sections</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->is('admin/blogs*') ? "active" : "" }}">
                    <a href="{{ route('blogs') }}" class="menu-link">
                        <div data-i18n="Blogs">Blogs</div>
                    </a>
                </li>
            </ul>
        </li>

	</ul>

	<script>
		const toggleButton = document.getElementById("toggleButton");
		const logoImage = document.getElementById("logoImage");
		let isImageVisible = true;

		toggleButton.addEventListener("click", function() {
			if (isImageVisible) {
			logoImage.style.display = "none";
			} else {
			logoImage.style.display = "block";
			}
			isImageVisible = !isImageVisible;
		});
		</script>

</aside>
<!-- / Menu -->



