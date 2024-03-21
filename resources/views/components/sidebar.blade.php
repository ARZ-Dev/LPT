<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

	<div class="app-brand demo">
		<a href="{{url('dashboard')}}" class="app-brand-link">
			<span class="app-brand-logo demo">
                @include('logo')
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

        <li class="menu-item {{ request()->is('dashboard') ? "active" : "" }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        @canany(['role-list', 'permission-list', 'user-list'])
        <li class="menu-item {{ request()->is('roles') || request()->is('permissions') || request()->is('users*') ? "active open" : "" }}">

			<a href="javascript:void(0);" class="menu-link menu-toggle">
			    <i class="menu-icon tf-icons ti ti-settings"></i>
			    <div data-i18n="Settings">Settings</div>
			</a>

			<ul class="menu-sub">

                @can('role-list')
                <li class="menu-item {{ request()->is('roles') ? "active" : "" }}">
                    <a href="{{ route('roles') }}" class="menu-link">
                    <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
                @endcan

                @can('permission-list')
                <li class="menu-item {{ request()->is('permissions') ? "active" : "" }}">
                    <a href="{{ route('permissions') }}" class="menu-link">
                    <div data-i18n="Permissions">Permissions</div>
                    </a>
                </li>
                @endcan

                @can('user-list')
				<li class="menu-item {{ request()->is('users*') ? "active" : "" }}">
					<a href="{{ route('users') }}" class="menu-link">
						<div data-i18n="Users">Users</div>
					</a>
				</li>
                @endcan
			</ul>
		</li>
        @endcanany

        @canany(['category-list', 'currency-list', 'till-list', 'payment-list', 'receipt-list', 'transfer-list', 'exchange-list', 'monthlyEntry-list'])
        <li class="menu-item {{ request()->is('category*', 'currency*', 'till*', 'payment*', 'receipt*', 'transfer*', 'exchange*', 'petty-cash-summary', 'monthly-openings-closings*') ? 'active open' : '' }}">

			<a href="javascript:void(0);" class="menu-link menu-toggle">
				<i class="menu-icon tf-icons ti ti-premium-rights"></i>
				<div data-i18n="Petty Cash">Petty Cash</div>
			</a>

			<ul class="menu-sub">

                @can('exchange-list')
			    <li class="menu-item {{ request()->is('category*') ? 'active' : '' }}">
                    <a href="{{ route('category') }}" class="menu-link">
						<div data-i18n="Category">Category</div>
					</a>
				</li>
                @endcan

                @can('currency-list')
				<li class="menu-item {{ request()->is('currency*') ? "active" : "" }}">
					<a href="{{ route('currency') }}" class="menu-link">
						<div data-i18n="Currency">Currency</div>
					</a>
				</li>
                @endcan

                @can('till-list')
				<li class="menu-item {{ request()->is('till*') ? "active" : "" }}">
					<a href="{{ route('till') }}" class="menu-link">
						<div data-i18n="Till">Till</div>
					</a>
				</li>
                @endcan

                @can('monthlyEntry-list')
				<li class="menu-item {{ request()->is('monthly-openings-closings*') ? "active" : "" }}">
					<a href="{{ route('monthly-openings-closings') }}" class="menu-link">
						<div data-i18n="Monthly Opening/Closing">Monthly Opening/Closing</div>
					</a>
				</li>
                @endcan

                @can('payment-list')
				<li class="menu-item {{ request()->is('payment*') ? "active" : "" }}">
					<a href="{{ route('payment') }}" class="menu-link">
						<div data-i18n="Payment">Payment</div>
					</a>
				</li>
                @endcan

                @can('receipt-list')
				<li class="menu-item {{ request()->is('receipt*') ? "active" : "" }}">
					<a href="{{ route('receipt') }}" class="menu-link">
						<div data-i18n="Receipt">Receipt</div>
					</a>
				</li>
                @endcan

                @can('transfer-list')
				<li class="menu-item {{ request()->is('transfer*') ? "active" : "" }}">
					<a href="{{ route('transfer') }}" class="menu-link">
						<div data-i18n="Transfer">Transfer</div>
					</a>
				</li>
                @endcan

                @can('exchange-list')
				<li class="menu-item {{ request()->is('exchange*') ? "active" : "" }}">
					<a href="{{ route('exchange') }}" class="menu-link">
						<div data-i18n="Exchange">Exchange</div>
					</a>
				</li>
                @endcan

                @can('pettyCashSummary-view')
				<li class="menu-item {{ request()->is('petty-cash-summary') ? "active" : "" }}">
					<a href="{{ route('petty-cash-summary') }}" class="menu-link">
						<div data-i18n="Summary">Summary</div>
					</a>
				</li>
                @endcan

			</ul>

		</li>
        @endcanany

        @can('team-list')
        <li class="menu-item {{ request()->is('teams*') ? "active" : "" }}">
            <a href="{{ route('teams') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Teams">Teams</div>
            </a>
        </li>
        @endcan

        @can('player-list')
        <li class="menu-item {{ request()->is('players*') ? "active" : "" }}">
            <a href="{{ route('players') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-user"></i>
                <div data-i18n="Players">Players</div>
            </a>
        </li>
        @endcan

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



