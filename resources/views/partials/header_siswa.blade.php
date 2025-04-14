<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <!-- Logo Section -->
  <div class="d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="Logo">
      <span class="d-none d-lg-block">NiceAdmin</span>
    </a>
  </div>
  <!-- End Logo -->

  <!-- Logout Button -->
  <div class="ms-auto pe-3">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-outline-danger">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </div>
  <!-- End Logout -->

</header>

<!-- End Header -->
