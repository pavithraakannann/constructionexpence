<aside class="app-sidebar">
    <div class="app-sidebar-logo px-6 justify-content-center align-items-center">
        <a href="{{ route('dashboard') }}">
            <h4 class="text-primary fw-bold">CEMS</h4>
            <!-- <img height="35" class="app-sidebar-logo-default" alt="Logo" src="assets/images/light-logo.png">
            <img height="40" class="app-sidebar-logo-minimize" alt="Logo" src="assets/images/Favicon.png"> -->
        </a>
    </div>
    <nav class="app-sidebar-menu nav nav-pills flex-column fs-6" id="sidebarMenu" aria-label="Main navigation">
        <ul class="main-menu" id="all-menu-items" role="menu">
            <li class="menu-title" role="presentation" data-lang="hr-title-main">Main</li>
            <li class="slide">
                <a href="{{ route('dashboard') }}" class="side-menu__item {{ request()->routeIs('dashboard') ? 'active' : '' }}" role="menuitem">
                    <span class="side_menu_icon"><i class="ri-home-2-line"></i></span>
                    <span class="side-menu__label" data-lang="hr-dashboards">Dashboards</span>
                </a>
            </li>
              <li class="menu-title" role="presentation" data-lang="hr-title-applications">Project</li>
            @auth
                @if(auth()->user()->isAdmin())
                <li class="slide">
                    <a href="{{ route('projects.index') }}" class="side-menu__item {{ request()->routeIs('projects.*') ? 'active' : '' }}" role="menuitem">
                        <span class="side_menu_icon"><i class="ri-layout-line"></i></span>
                        <span class="side-menu__label" data-lang="hr-layout">Projects List</span>
                    </a>
                </li>
                @endif
            @endauth
            <li class="slide">
                <a href="{{ route('labours.index') }}" class="side-menu__item {{ request()->routeIs('labours.*') ? 'active' : '' }}" role="menuitem">
                    <span class="side_menu_icon"><i class="bi bi-person-add"></i></span>
                    <span class="side-menu__label" data-lang="hr-layout">labours List</span>
                </a>
            </li>
            <li class="slide">
                <a href="{{ route('materials.index') }}" class="side-menu__item {{ request()->routeIs('materials.*') ? 'active' : '' }}" role="menuitem">
                    <span class="side_menu_icon"><i class="ri-pantone-line"></i></span>
                    <span class="side-menu__label" data-lang="hr-layout">Materials List</span>
                </a>
            </li>
            <li class="slide">
                <a href="{{ route('advances.index') }}" class="side-menu__item {{ request()->routeIs('advances.*') ? 'active' : '' }}" role="menuitem">
                    <span class="side_menu_icon"><i class="ri-pantone-line"></i></span>
                    <span class="side-menu__label" data-lang="hr-layout">Advance List</span>
                </a>
            </li>
            <li class="menu-title" role="presentation" data-lang="hr-title-applications">Masters</li>
            <li class="slide">
                <a href="{{ route('materialtypes.index') }}" class="side-menu__item {{ request()->routeIs('materialtypes.*') ? 'active' : '' }}" role="menuitem">
                    <span class="side_menu_icon"><i class="ri-pantone-line"></i></span>
                    <span class="side-menu__label" data-lang="hr-layout">Material Types</span>
                </a>
            </li>
            <li class="slide">
                <a href="{{ route('labourtypes.index') }}" class="side-menu__item {{ request()->routeIs('labourtypes.*') ? 'active' : '' }}" role="menuitem">
                    <span class="side_menu_icon"><i class="ri-group-line"></i></span>
                    <span class="side-menu__label">Labour Types</span>
                </a>
            </li>
            @auth
                @if(auth()->user()->isAdmin())
                <li class="menu-title" role="presentation" data-lang="hr-title-applications">User Management</li>
                <li class="slide">
                    <a href="{{ route('users.index') }}" class="side-menu__item {{ request()->routeIs('users.*') ? 'active' : '' }}" role="menuitem">
                        <span class="side_menu_icon"><i class="ri-shield-user-line"></i></span>
                        <span class="side-menu__label">Manage Users</span>
                    </a>
                </li>
                @endif
            @endauth
        </ul>
    </nav>
</aside>


<div class="offcanvas offcanvas-md offcanvas-start small-screen-sidebar" data-bs-scroll="true" tabindex="-1"
    id="smallScreenSidebar" aria-labelledby="smallScreenSidebarLabel">
    <div class="offcanvas-header hstack border-bottom">
        <!-- START BRAND LOGO -->
        <div class="app-sidebar-logo">
            <a href="index.html">
                <img height="35" class="app-sidebar-logo-default h-25px" alt="Logo" src="assets/images/light-logo.png">
                <img height="40" class="app-sidebar-logo-minimize" alt="Logo" src="assets/images/Favicon.png">
            </a>
        </div>
        <button type="button" class="btn-close bg-transparent" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
    <div class="offcanvas-body p-0">
        <!-- START SIDEBAR -->
        <aside class="app-sidebar">
            <!-- END BRAND LOGO -->
            <nav class="app-sidebar-menu nav nav-pills flex-column fs-6" aria-label="Main navigation">
                <ul class="main-menu" id="all-menu-items" role="menu">
                    <li class="menu-title" role="presentation" data-lang="hr-title-main">Main</li>
                    <li class="slide">
                        <a href="{{ route('dashboard') }}" class="side-menu__item {{ request()->routeIs('dashboard') ? 'active' : '' }}" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-home-2-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-dashboards">Dashboards</span>
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                        <li class="menu-title" role="presentation" data-lang="hr-title-applications">Project</li>
                        <li class="slide">
                            <a href="{{ route('projects.index') }}" class="side-menu__item {{ request()->routeIs('projects.*') ? 'active' : '' }}" role="menuitem">
                                <span class="side_menu_icon"><i class="ri-layout-line"></i></span>
                                <span class="side-menu__label" data-lang="hr-layout">Projects List</span>
                            </a>
                        </li>
                        @endif
                    @endauth
                    <li class="slide">
                        <a href="{{ route('labours.index') }}" class="side-menu__item {{ request()->routeIs('labours.*') ? 'active' : '' }}" role="menuitem">
                            <span class="side_menu_icon"><i class="bi bi-person-add"></i></span>
                            <span class="side-menu__label" data-lang="hr-layout">labours List</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('materials.index') }}" class="side-menu__item {{ request()->routeIs('materials.*') ? 'active' : '' }}" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-pantone-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-layout">Materials List</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('labourtypes.index') }}" class="side-menu__item {{ request()->routeIs('labourtypes.*') ? 'active' : '' }}" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-group-line"></i></span>
                            <span class="side-menu__label">Labour Types</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('advances.index') }}" class="side-menu__item {{ request()->routeIs('advances.*') ? 'active' : '' }}" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-pantone-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-layout">Advance List</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('materialtypes.index') }}" class="side-menu__item {{ request()->routeIs('materialtypes.*') ? 'active' : '' }}" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-pantone-line"></i></span>
                            <span class="side-menu__label" data-lang="hr-layout">Material Types List</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('labourtypes.index') }}" class="side-menu__item {{ request()->routeIs('labourtypes.*') ? 'active' : '' }}" role="menuitem">
                            <span class="side_menu_icon"><i class="ri-group-line"></i></span>
                            <span class="side-menu__label">Labour Types</span>
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                        <li class="menu-title" role="presentation" data-lang="hr-title-applications">User Management</li>
                        <li class="slide">
                            <a href="{{ route('users.index') }}" class="side-menu__item {{ request()->routeIs('users.*') ? 'active' : '' }}" role="menuitem">
                                <span class="side_menu_icon"><i class="ri-shield-user-line"></i></span>
                                <span class="side-menu__label">Manage Users</span>
                            </a>
                        </li>
                        @endif
                    @endauth
                </ul>
            </nav>
        </aside>
    </div>
</div>