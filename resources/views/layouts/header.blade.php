

<header class="app-header">
    <div class="container-fluid">
        <div class="nav-header">
            <div class="header-left hstack gap-3">
                         <div class="app-sidebar-logo app-horizontal-logo justify-content-center align-items-center">
            <a href="index.html">
              <img height="35" class="app-sidebar-logo-default" alt="Logo" loading="lazy"
                src="assets/images/light-logo.png">
              <img height="40" class="app-sidebar-logo-minimize" alt="Logo" loading="lazy"
                src="assets/images/Favicon.png">
            </a>
          </div>

          <!-- Sidebar Toggle Btn -->
          <button type="button" class="btn btn-light-light icon-btn sidebar-toggle d-none d-md-block"
            aria-expanded="false" aria-controls="main-menu">
            <span class="visually-hidden">Toggle sidebar</span>
            <i class="ri-menu-2-fill"></i>
          </button>

          <!-- Sidebar Toggle for Mobile -->
          <button class="btn btn-light-light icon-btn d-md-none small-screen-toggle" id="smallScreenSidebarLabel"
            type="button" data-bs-toggle="offcanvas" data-bs-target="#smallScreenSidebar"
            aria-controls="smallScreenSidebar">
            <span class="visually-hidden">Sidebar toggle for mobile</span>
            <i class="ri-arrow-right-fill"></i>
          </button>

          <!-- Sidebar Toggle for Horizontal Menu -->
          <button class="btn btn-light-light icon-btn d-lg-none small-screen-horizontal-toggle" type="button"
            ria-expanded="false" aria-controls="main-menu" id="smallScreenHorizontalToggle">
            <span class="visually-hidden">Sidebar toggle for horizontal</span>
            <i class="ri-arrow-right-fill"></i>
          </button>
            </div>

            <div class="header-right hstack gap-3">
                <div class="dropdown profile-dropdown features-dropdown">
                    <button type="button" id="accountNavbarDropdown"
                        class="btn profile-btn shadow-none px-0 hstack gap-0 gap-sm-3" data-bs-toggle="dropdown"
                        aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                        <span class="position-relative">
                            <span class="avatar-item avatar overflow-hidden">
                                <img class="img-fluid" src="assets/images/avatar/avatar-1.jpg" alt="avatar image">
                            </span>
                            <span
                                class="position-absolute border-2 border border-white h-12px w-12px rounded-circle bg-success end-0 bottom-0"></span>
                        </span>
                        <span>
                            <span class="h6 d-none d-xl-inline-block text-start fw-semibold mb-0">{{ Auth::user()->name }}</span>
                        </span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end header-language-scrollable"
                        aria-labelledby="accountNavbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile.view') }}">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Sign out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>