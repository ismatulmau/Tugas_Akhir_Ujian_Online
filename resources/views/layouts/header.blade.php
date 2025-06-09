<div class="main-header">
<div class="main-header-logo">
    <div class="logo-header" data-background-color="dark">
        <a href="#" class="logo">
            <img src="{{ asset('assets/img/logo_telematika.png') }}" alt="navbar brand" class="navbar-brand" height="20" />
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
            <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
        </div>
        <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
    </div>
</div>

    <!-- Navbar -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <!-- <div class="avatar-sm">
                            <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
                        </div> -->
                        <i class='fas fa-chalkboard-teacher'></i>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span> <span class="fw-bold">Admin</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="dropdown-item">
        <i class="fas fa-sign-out-alt me-2"></i>Logout
    </button>
</form>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>