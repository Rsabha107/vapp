<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>VAPP</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/img/favicons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/img/favicons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/favicons/favicon-16x16.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicons/favicon.ico')}}">
    <link rel="manifest" href="{{asset('assets/img/favicons/manifest.json')}}">
    <meta name="msapplication-TileImage" content="{{asset('assets/img/favicons/mstile-150x150.png')}}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{asset('assets/vendors/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('fnx/assets/vendors/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="{{asset('fnx/assets/vendors/simplebar/simplebar.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link href="{{asset('fnx/assets/css/theme-rtl.min.css')}}" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="{{asset('fnx/assets/css/theme.min.css')}}" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{asset('fnx/assets/css/user-rtl.min.css')}}" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="{{asset('fnx/assets/css/user.min.css')}}" type="text/css" rel="stylesheet" id="user-style-default">
    <script>
        var phoenixIsRTL = window.config.config.phoenixIsRTL;
        if (phoenixIsRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container">
            <form method="POST" action="{{ route('login') }}" class="forms-sample">
                @csrf
                <div class="row flex-center min-vh-100 py-5">

                    <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a class="d-flex flex-center text-decoration-none mb-4" href="../../../index.html">
                            {{-- <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img src="../../../assets/img/icons/logo.png" alt="phoenix" width="58" />
                            </div> --}}
                        </a>

                        <div class="card shadow-sm">
                            <div class="card-body p-4 p-sm-5">
                                <div class="text-center mb-4">
                                    <img src="{{asset('assets/img/icons/logo-placeholder.jpg')}}" alt="phoenix" width="58" />
                                </div>
                                <div class="text-center mb-7">
                                    <h3 class="text-body-highlight">VAPP</h3>
                                    <p class="text-body-tertiary">Please sign in to your account.</p>
                                </div>
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <!-- <button class="btn btn-phoenix-secondary w-100 mb-3"><span class="fab fa-google text-danger me-2 fs-9"></span>Sign in with google</button>
                            <button class="btn btn-phoenix-secondary w-100"><span class="fab fa-facebook text-primary me-2 fs-9"></span>Sign in with facebook</button>
                            <div class="position-relative">
                            <hr class="bg-body-secondary mt-5 mb-4" />
                            <div class="divider-content-center">or use email</div>
                            </div> -->
                                <div class="mb-3 text-start">
                                    <label class="form-label" for="email">Email</label>
                                    <div class="form-icon-container">
                                        <input class="form-control form-icon-input" id="email" name="login" id="login" type="login" placeholder="name@example.com" /><span class="fas fa-user text-body fs-9 form-icon"></span>
                                    </div>
                                </div>
                                <div class="mb-3 text-start">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="form-icon-container" data-password="data-password">
                                        <input class="form-control form-icon-input pe-6" name="password" id="password" type="password" placeholder="Password" data-password-input="data-password-input" /><span class="fas fa-key text-body fs-9 form-icon"></span>
                                        <div class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary mt-1" data-password-toggle="data-password-toggle"><span class="uil uil-eye show"></span><span class="uil uil-eye-slash hide"></span></div>
                                    </div>
                                </div>
                                <div class="row flex-between-center mb-5">
                                    <div class="col-auto">

                                    </div>
                                    <div class="col-auto"><a class="fs-9 fw-semibold" href="{{route('vapp.auth.forgot')}}">Forgot Password?</a></div>
                                </div>
                                <button class="btn btn-primary w-100 mb-3">Sign In</button>
                                <!-- <div class="text-center"><a class="fs-9 fw-bold" href="{{ route('vapp.auth.signup') }}">Create an account</a></div> -->
                            </div>
                        </div>
                    </div>
            </form>
        </div>
        <script>
            var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
            var navbarTop = document.querySelector('.navbar-top');
            if (navbarTopStyle === 'darker') {
                navbarTop.setAttribute('data-navbar-appearance', 'darker');
            }

            var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
            var navbarVertical = document.querySelector('.navbar-vertical');
            if (navbarVertical && navbarVerticalStyle === 'darker') {
                navbarVertical.setAttribute('data-navbar-appearance', 'darker');
            }
        </script>
    </main>

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->





    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

    <script src="{{ asset ('assets/jquery/dist/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset ('assets/vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset ('assets/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset ('assets/vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset ('assets/vendors/is/is.min.js') }}"></script>
    <script src="{{ asset ('assets/vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset ('assets/vendors/lodash/lodash.min.js') }}"></script>
    
    <script src="{{ asset ('assets/vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset ('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset ('assets/vendors/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset ('fnx/assets/js/phoenix.js') }}"></script>
    <!-- <script src="{{ asset ('assets/vendors/select2/select2.min.js') }}"></script> -->


</body>

</html>