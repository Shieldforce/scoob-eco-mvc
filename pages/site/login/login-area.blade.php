<!-- Start Login
============================================= -->
<div class="login-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="login-box">
                    <div class="login">
                        <div class="content">
                            <a
                                href="{{ asset('dostart/index.html') }}"
                            >
                                <img
                                    src="{{ asset('dostart/assets/img/logo.png') }}"
                                    alt="Logo"
                                >
                            </a>
                            <form
                                action="{{ route("pages.site.loginRun") }}"
                                method="POST"
                                id="formIdSubmitGlobal"
                            >
                                {{ scoob_input_token() }}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Email*" type="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Password*" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit">
                                            Login
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="social-login">
                                <h4>Social Login</h4>
                                <ul>
                                    <li class="facebook">
                                        <a href="{{ asset('dostart') }}/#"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li class="twitter">
                                        <a href="{{ asset('dostart') }}/#"><i class="fab fa-twitter"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="sign-up">
                                <p>
                                    Don't have an account? <a href="{{ asset('dostart') }}/register.html">Sign up
                                        now</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Login Form -->