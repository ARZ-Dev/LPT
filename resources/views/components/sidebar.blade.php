<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	

<div class=" text-center">
		<img id="logoImage" src="{{ asset('assets/images/login/Racket-and-ball-Tennis-Logo-by-yahyaanasatokillah.png') }}" style="height:100%;width:230px;">
</div>

	<div class="app-brand  demo">
		<a href="{{url('dashboard')}}" class="app-brand-link">
			<span class="app-brand-logo demo"></span>
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

        <li class="menu-item {{ request()->is('roles') || request()->is('permissions') ? "active open" : "" }}">

			<a href="javascript:void(0);" class="menu-link menu-toggle">
			    <i class="menu-icon tf-icons ti ti-settings"></i>
			    <div data-i18n="Settings">Settings</div>
			</a>

			<ul class="menu-sub">

               
                <li class="menu-item {{ request()->is('roles') ? "active" : "" }}">
                    <a href="{{ route('roles') }}" class="menu-link">
                    <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
            

               
                <li class="menu-item {{ request()->is('permissions') ? "active" : "" }}">
                    <a href="{{ route('permissions') }}" class="menu-link">
                    <div data-i18n="Permissions">Permissions</div>
                    </a>
                </li>
              
                
              
                    <li class="menu-item">
                        <a href="{{ route('users') }}" class="menu-link">
                            <div data-i18n="Users">Users</div>
                        </a>
                    </li>
            

			</ul>

		</li>



		

	

				








	

	


	

	
			

	
					
			







	

		
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



