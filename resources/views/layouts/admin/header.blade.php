<header id="header" class="header sticky-top">

  <div class="topbar d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
        <i class="bi bi-phone d-flex align-items-center ms-4"><span>+62 812 3456 7890</span></i>
      </div>
      <div class="social-links d-none d-md-flex align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
      </div>
    </div>
  </div><!-- End Top Bar -->

  <div class="branding d-flex align-items-center">

    <div class="container position-relative d-flex align-items-center justify-content-between">
      <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center">
        <h1 class="sitename">SIMONSA</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li>
            <a href="{{ route('admin.dashboard') }}"
              class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
          </li>

          <li>
            <a href="{{ route('admin.pengguna.index') }}"
              class="{{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">Pengguna</a>
          </li>

          <li class="dropdown">
            <a href="#"><span>Data Master</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Kebun</a></li>
              <li><a href="#">Blok Kebun</a></li>
            </ul>
          </li>

          <li><a href="#">Monitoring Panen</a></li>

          <li class="dropdown">
            <a href="#"><span>{{ Auth::user()->nama ?? 'Akun' }}</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Profil Akun</a></li>
              <li>
                <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
                  @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                  Logout
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>

  </div>

</header>