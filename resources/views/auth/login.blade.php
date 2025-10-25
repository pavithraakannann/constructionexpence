<!DOCTYPE html>
<html lang="en" class="h-100">


<!-- Mirrored from codebucks.in/herozi/html/auth-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 11 Oct 2025 04:36:35 GMT -->

<head>
    <meta charset="utf-8">
    <title>Sign In | Herozi - Bootstrap Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Herozi is the top-selling Bootstrap 5 admin dashboard template. With Dark Mode, multi-demo options, RTL support, and lifetime updates, it's perfect for web developers.">
    <meta name="keywords" content="Herozi bootstrap dashboard, bootstrap, bootstrap 5, html dashboard, web dashboard, admin themes, web design, figma, web development, fullcalendar, datatables, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dark mode, bootstrap button, frontend dashboard, responsive bootstrap theme">
    <meta content="SRBThemes" name="author">
    <link rel="shortcut icon" href="assets/images/Favicon.png">

    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="Herozi - Bootstrap Admin & Dashboard Template">
    <meta property="og:description" content="Herozi is the top-selling Bootstrap 5 admin dashboard template. With Dark Mode, multi-demo options, RTL support, and lifetime updates, it's perfect for web developers.">
    <meta property="og:url" content="https://themeforest.net/user/srbthemes/portfolio">
    <meta property="og:site_name" content="Herozi by SRBThemes">
    <script>
        const AUTH_LAYOUT = true;
    </script>
    <!-- Layout JS -->
    <script src="assets/js/layout/layout-auth.js"></script>

    <script src="assets/js/layout/layout.js"></script>

    <!-- Choice Css -->
    <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">
    <!-- Simplebar Css -->
    <link href="assets/libs/simplebar/simplebar.min.css" rel="stylesheet">
    <!--icons css-->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- Sweet Alert -->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">

    <link href="assets/css/custom.min.css" id="custom-style" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="account-pages">
        <div class="container">
            <div class="justify-content-center row gy-0">
                <div class="col-lg-6">
                    <div class="auth-box card card-body m-0 h-100 border-0 justify-content-center">
                        <div class="mb-5 text-center">
                            <h4 class="fw-normal">Welcome</h4>
                            <p class="text-muted mb-0">Please enter your information to access your account.</p>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="form-custom mt-10">
                            @csrf

                            <div class="mb-5">
                                <label class="form-label" for="email">Email<span class="text-danger ms-1">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       placeholder="Enter your email" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label class="form-label" for="password">Password<span class="text-danger ms-1">*</span></label>
                                <div class="input-group">
                                    <input type="password" id="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" placeholder="Enter your password" 
                                           data-visible="false" required>
                                    <a class="input-group-text bg-transparent toggle-password" href="javascript:;" data-target="password">
                                        <i class="ri-eye-off-line text-muted toggle-icon"></i>
                                    </a>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    <div class="form-check form-check-sm d-flex align-items-center gap-2 mb-0">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-end">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            <span class="fs-14 text-muted">
                                                Forgot your password?
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-2 w-100 btn-loader">
                                <span class="indicator-label">
                                    Sign In
                                </span>
                                <span class="indicator-progress flex gap-2 justify-content-center w-100">
                                    <span>Please Wait...</span>
                                    <i class="ri-loader-2-fill"></i>
                                </span>
                            </button>
                            <div class="center-hr my-10 text-nowrap text-muted">Or with email</div>

                            <p class="mb-0 mt-5 text-muted text-center">
                                Don't have an account ?
                                <a href="{{ route('register') }}" class="text-primary fw-medium text-decoraton-underline ms-1">
                                    Sign up
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/js/pages/scroll-top.init.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- App js -->
    <script type="module" src="assets/js/app.js"></script>

</body>


<!-- Mirrored from codebucks.in/herozi/html/auth-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 11 Oct 2025 04:36:35 GMT -->

</html>