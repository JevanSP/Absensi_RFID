<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">


            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Profile"
                        class="rounded-circle object-fit-cover" style="width: 40px; height: 40px;">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ $user->nama }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ $user->nama }}</h6>
                        <span>{{ $siswa->kelas->nama }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0 m-0">
                            @csrf
                            <button type="submit"
                                class="d-flex align-items-center w-100 border-0 bg-transparent px-3 py-2">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>

                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
