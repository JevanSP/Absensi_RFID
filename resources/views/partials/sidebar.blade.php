<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="index.html">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('data_sekolah') }}" class="nav-link collapsed">
                <i class="bi bi-card-list"></i>
                <span>Sekolah</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/data_jurusan">
                        <i class="bi bi-circle"></i><span>Data Jurusan</span>
                    </a>
                </li>
                <li>
                    <a href="/data_siswa">
                        <i class="bi bi-circle"></i><span>Data Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="/data_budaya_positif">
                        <i class="bi bi-circle"></i><span>Data Budaya Positif</span>
                    </a>
                </li>
                <li>
                    <a href="/data_prestasi">
                        <i class="bi bi-circle"></i><span>Data Prestasi</span>
                    </a>
                </li>
                <li>
                    <a href="/data_pelanggaran">
                        <i class="bi bi-circle"></i><span>Data Pelanggaran</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>User Manajemen</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('user_admin') }}">
                        <i class="bi bi-circle"></i><span>User Admin</span>
                    </a>
                </li>
                <li>
                    <a href="tables-data.html">
                        <i class="bi bi-circle"></i><span>User Guru</span>
                    </a>
                </li>
                <li>
                    <a href="tables-data.html">
                        <i class="bi bi-circle"></i><span>User Siswa</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi-file-earmark-person-fill"></i>
                <span>Absensi Siswa</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi-person-plus"></i>
                <span>Budaya Positif</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi-person-plus-fill"></i>
                <span>Prestasi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi-person-dash-fill"></i>
                <span>Pelanggaran</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-coin"></i>
                <span>Poinku</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-gear-fill"></i>
                <span>Pengaturan</span>
            </a>
        </li>
        
    </ul>

</aside><!-- End Sidebar-->
