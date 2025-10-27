<!DOCTYPE html>
<html lang="en" class="h-100" data-theme-mode-panel-active="true" data-theme="light" data-theme-mode="light" data-theme-layout="vertical" data-nav-style="menu-click" data-theme-style="modern" data-menu-styles="light" data-header-styles="light">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Construction Expense Management')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Construction Expense Management System">
    <meta name="keywords" content="construction, expense, management, laravel, bootstrap">
    <meta name="author" content="Your Company">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/Favicon.png') }}">

    <!-- CSS Files -->
    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <!-- Simplebar -->
    <link href="{{ asset('assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.0/css/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.3.0/css/dataTables.checkboxes.min.css">
    <!-- App CSS -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet">

    <!-- <style>
        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            z-index: 1000;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .app-wrapper {
            margin-left: 250px;
            min-height: 100vh;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                left: -250px;
            }

            .app-sidebar.show {
                left: 0;
            }

            .app-wrapper {
                margin-left: 0;
            }
        }
    </style> -->

    <!-- @stack('styles') -->
</head>

<body>
    @include('layouts.header')
    @include('layouts.sidebar')

    <main class="app-wrapper">
        <div class="app-container">
            @yield('content')
        </div>
    </main>

    @include('layouts.footer')

    <!-- JavaScript Libraries -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Simplebar -->
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <!-- Waves Effect -->
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <!-- Feather Icons -->
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.6.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-datatables-checkboxes@1.3.0/js/dataTables.checkboxes.min.js"></script>
    <!-- Custom Scripts -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/layout/layout.js') }}"></script>
    <script src="{{ asset('assets/js/layout/layout-default.js') }}"></script>

    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Sidebar toggle functionality
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const mobileToggle = document.querySelector('.small-screen-horizontal-toggle');
            const sidebar = document.querySelector('.app-sidebar');
            const wrapper = document.querySelector('.app-wrapper');

            // Desktop toggle
            if (sidebarToggle && sidebar && wrapper) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('collapsed');
                    wrapper.classList.toggle('collapsed');
                });
            }

            // Mobile toggle
            if (mobileToggle && sidebar) {
                mobileToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 991.98 &&
                    sidebar &&
                    !sidebar.contains(e.target) &&
                    !e.target.closest('.sidebar-toggle') &&
                    !e.target.closest('.small-screen-horizontal-toggle')) {
                    sidebar.classList.remove('show');
                }
            });

            // Initialize Feather Icons
            if (typeof feather !== 'undefined') {
                feather.replace({
                    width: 20,
                    height: 20
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>