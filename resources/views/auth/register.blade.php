<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <title>Sign Up | Herozi - Bootstrap Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Herozi is the top-selling Bootstrap 5 admin dashboard template. With Dark Mode, multi-demo options, RTL support, and lifetime updates, it's perfect for web developers.">
    <meta name="keywords"
        content="Herozi bootstrap dashboard, bootstrap, bootstrap 5, html dashboard, web dashboard, admin themes, web design, figma, web development, fullcalendar, datatables, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dark mode, bootstrap button, frontend dashboard, responsive bootstrap theme">
    <meta content="SRBThemes" name="author">
    <link rel="shortcut icon" href="assets/images/Favicon.png">

    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="Herozi - Bootstrap Admin & Dashboard Template">
    <meta property="og:description"
        content="Herozi is the top-selling Bootstrap 5 admin dashboard template. With Dark Mode, multi-demo options, RTL support, and lifetime updates, it's perfect for web developers.">
    <meta property="og:url" content="https://themeforest.net/user/srbthemes/portfolio">
    <meta property="og:site_name" content="Herozi by SRBThemes">
    <script>
        const AUTH_LAYOUT = true;
    </script>
    <script src="{{ asset('assets/js/layout/layout-auth.js') }}"></script>
    <script src="{{ asset('assets/js/layout/layout.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <link href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/custom.min.css') }}" id="custom-style" rel="stylesheet" type="text/css">
</head>

<body>

    <div class="account-pages">
        <img src="assets/images/auth/auth_bg.jpg" alt="auth_bg" class="auth-bg light">
        <img src="assets/images/auth/auth_bg_dark.jpg" alt="auth_bg_dark" class="auth-bg dark">
        <div class="container">
            <div class="justify-content-center row gy-0">
                <div class="col-lg-6">
                    <div class="auth-box card card-body m-0 h-100 border-0 justify-content-center">
                        <div class="mb-5 text-center">
                            <h4 class="fw-normal">Welcome to <span class="fw-bold text-primary">Herozi</span></h4>
                            <p class="text-muted mb-0">Please enter your information to access your account.</p>
                        </div>
                        <form method="POST" action="{{ route('register') }}" class="form-custom mt-10">
                            @csrf
                            
                            <!-- Name -->
                            <div class="mb-5">
                                <label class="form-label" for="name">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" 
                                    placeholder="Enter your full name" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-5">
                                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" 
                                    placeholder="Enter your email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-5">
                                <label class="form-label" for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" id="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        name="password" placeholder="Enter your password" required 
                                        autocomplete="new-password">
                                    <a class="input-group-text bg-transparent toggle-password" href="javascript:;" 
                                        data-target="password">
                                        <i class="ri-eye-off-line text-muted toggle-icon"></i>
                                    </a>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-5">
                                <label class="form-label" for="password-confirm">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" id="password-confirm" 
                                        class="form-control" name="password_confirmation" 
                                        placeholder="Confirm your password" required 
                                        autocomplete="new-password">
                                    <a class="input-group-text bg-transparent toggle-password" href="javascript:;" 
                                        data-target="password-confirm">
                                        <i class="ri-eye-off-line text-muted toggle-icon"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <p class="mb-0 fs-xs text-muted fst-italic">
                                    By registering you agree to the 
                                    <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">
                                        Terms of Use
                                    </a>
                                </p>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-2 w-100">
                                <span class="indicator-label">
                                    Sign Up
                                </span>
                            </button>

                            <p class="mb-0 mt-5 text-muted text-center">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-primary fw-medium text-decoration-underline ms-1">
                                    Sign In
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/scroll-top.init.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>