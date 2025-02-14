<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->is('index') ? 'active' : 'collapsed' }}" href="index.html">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('data_sekolah') }}" class="nav-link {{ request()->routeIs('data_sekolah') ? 'active' : 'collapsed' }}">
                <i class="bi bi-card-list"></i>
                <span>Sekolah</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('data_jurusan', 'data_siswa', 'data_budaya_positif', 'data_prestasi', 'data_pelanggaran') ? 'active' : 'collapsed' }}" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse {{ request()->is('data_jurusan', 'data_siswa', 'data_budaya_positif', 'data_prestasi', 'data_pelanggaran') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/data_jurusan" class="{{ request()->is('data_jurusan') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Jurusan</span>
                    </a>
                </li>
                <li>
                    <a href="/data_siswa" class="{{ request()->is('data_siswa') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="/data_budaya_positif" class="{{ request()->is('data_budaya_positif') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Budaya Positif</span>
                    </a>
                </li>
                <li>
                    <a href="/data_prestasi" class="{{ request()->is('data_prestasi') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Prestasi</span>
                    </a>
                </li>
                <li>
                    <a href="/data_pelanggaran" class="{{ request()->is('data_pelanggaran') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Pelanggaran</span>
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : 'collapsed' }}" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>User Manajemen</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse {{ request()->routeIs('user.index') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('user.index', 'admin') }}" class="{{ request()->route('role') == 'admin' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>User Admin</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index', 'guru') }}" class="{{ request()->route('role') == 'guru' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>User Guru</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index', 'siswa') }}" class="{{ request()->route('role') == 'siswa' ? 'active' : '' }}">
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
