<div>

    <style>
        body{
        background-image: url("/assets/images/login/pexels-todd-trapani-2339377.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        }
    </style>

    <div class="container-xxl" >

        <div class="authentication-wrapper authentication-basic container-p-y">

            <div class="authentication-inner py-4" >
                <!-- Login -->
                <div class="card" >
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ route('home') }}" class="app-brand-link gap-2">
                                <button type="button" class="btn rounded-pill btn-icon btn-primary waves-effect waves-light">
                                    <span class="ti ti-home"></span>
                                </button>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">Welcome to LPT! 👋</h4>
                        <p class="mb-4">Please sign-in to your account</p>

                        <div id="formAuthentication" class="mb-3">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input
                                    wire:model.defer="username"
                                    wire:keydown.enter="login"
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    name="username"
                                    placeholder="Enter your username"
                                    autofocus
                                    required
                                />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input
                                        wire:model.defer="password"
                                        wire:keydown.enter="login"
                                        type="password"
                                        id="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password"
                                        required
                                    />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input wire:model="rememberMe" class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div>
                            @error('username')
                            <div class="d-flex justify-content-center align-content-center mb-2">
                                <i class="ti ti-alert-triangle text-danger" style="color: red;"></i>
                                <div class="text-danger">Invalid Credentials</div>
                            </div>
                            @enderror
                            <div class="mb-3">
                                <button wire:click="login" class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
