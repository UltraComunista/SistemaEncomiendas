<div class="preloader">
  <img src="vistas/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
</div>
<div class="preloader">
  <img src="vistas/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
</div>

<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="./index.html" class="text-nowrap logo-img">
        <img src="vistas/img/rx-logo.png" class="dark-logo ms-5" width="130" alt="" />
        <img src="vistas/dist/images/logos/light-logo.svg" class="light-logo" width="180" alt="" />
      </a>
      <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8 text-muted"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        <!-- ============================= -->
        <!-- Home -->
        <!-- ============================= -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Inicio</span>
        </li>
        <!-- =================== -->
        <!-- Dashboard -->
        <!-- =================== -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="inicio" aria-expanded="false">
            <span>
              <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Inicio</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="listaenvios" class="sidebar-link">
            <i class="ti ti-truck-delivery"></i>

            <span class="hide-menu">Envios</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="cliente" aria-expanded="false">
            <span>
              <i class="ti ti-package-export"></i>
            </span>
            <span class="hide-menu">Clientes</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="pagos" aria-expanded="false">
            <span>
              <i class="ti ti-credit-card"></i>
            </span>
            <span class="hide-menu">Pagos</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="categoria" aria-expanded="false">
            <span>
              <i class="ti ti-tags"></i>
            </span>
            <span class="hide-menu">Categorías</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="sucursal" aria-expanded="false">
            <span>
              <i class="ti ti-building-store"></i>
            </span>
            <span class="hide-menu">Sucursal</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="usuarios" aria-expanded="false">
            <span>
              <i class="ti ti-user"></i>
            </span>
            <span class="hide-menu">Usuarios</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="reportesx" aria-expanded="false">
            <span>
              <i class="ti ti-archive"></i>
            </span>
            <span class="hide-menu">Reportes</span>
          </a>
        </li>
        <!-- ============================= -->
        <!-- Apps -->
        <!-- ============================= -->

    </nav>
    <div class="fixed-profile p-3 bg-light-secondary rounded sidebar-ad mt-3">
      <div class="hstack gap-3">
        <div class="john-img">
          <img src="../../dist/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40" alt="">
        </div>
        <div class="john-title">
          <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
          <span class="fs-2 text-dark">Designer</span>
        </div>
        <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
          <i class="ti ti-power fs-6"></i>
        </button>
      </div>
    </div>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!--  Customizer -->
<button class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
  <i class="ti ti-settings fs-7" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Settings"></i>
</button>
<div class="offcanvas offcanvas-end customizer" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" data-simplebar="">
  <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
    <h4 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">Settings</h4>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-4">
    <div class="theme-option pb-4">
      <h6 class="fw-semibold fs-4 mb-1">Theme Option</h6>
      <div class="d-flex align-items-center gap-3 my-3">
        <a href="javascript:void(0)" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 light-theme text-dark" id="lightTheme">
          <i class="ti ti-brightness-up fs-7 text-primary"></i>
          <span class="text-dark">Light</span>
        </a>
        <a href="javascript:void(0)" class="rounded-2 p-9 customizer-box hover-img d-flex align-items-center gap-2 dark-theme text-dark" id="darkTheme">
          <i class="ti ti-moon fs-7"></i>
          <span class="text-dark">Dark</span>
        </a>
      </div>
    </div>
  </div>

</div>