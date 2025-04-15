<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a href="{{ route('dashboard.admin_guru') }}"
                class="nav-link {{ request()->routeIs('dashboard.admin_guru') ? 'active' : 'collapsed' }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('data_sekolah') }}"
                class="nav-link {{ request()->routeIs('data_sekolah') ? 'active' : 'collapsed' }}">
                <i class="bi bi-card-list"></i>
                <span>Sekolah</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->is('data_kelas', 'data_siswa', 'poin_kategori/*') ? 'active' : 'collapsed' }}"
                data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav"
                class="nav-content collapse {{ request()->is('data_kelas', 'data_siswa', 'poin_kategori/*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/data_kelas" class="{{ request()->is('data_kelas') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Kelas</span>
                    </a>
                </li>
                <li>
                    <a href="/data_siswa" class="{{ request()->is('data_siswa') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('poin_kategori.indexByCategory', 'budaya_positif') }}"
                        class="{{ request()->route('category') == 'budaya_positif' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Budaya Positif</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('poin_kategori.indexByCategory', 'prestasi') }}"
                        class="{{ request()->route('category') == 'prestasi' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Prestasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('poin_kategori.indexByCategory', 'pelanggaran') }}"
                        class="{{ request()->route('category') == 'pelanggaran' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Data Pelanggaran</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : 'collapsed' }}"
                data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>User Manajemen</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse {{ request()->routeIs('user.index') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('user.index', 'admin') }}"
                        class="{{ request()->route('role') == 'admin' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>User Admin</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index', 'guru') }}"
                        class="{{ request()->route('role') == 'guru' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>User Guru</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.index', 'siswa') }}"
                        class="{{ request()->route('role') == 'siswa' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>User Siswa</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-heading">ABSENSI</li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('absensi.masuk', 'absensi.pulang') ? 'active' : 'collapsed' }}"
                href="{{ now()->hour < 12 ? route('absensi.masuk') : route('absensi.pulang') }}">
                <i class="bi-file-earmark-person-fill"></i>
                <span>Tampilan Absensi Siswa</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('absen.list') ? 'active' : 'collapsed' }}"
                href="{{ route('absen.list') }}">
                <i class="bi-file-earmark-person-fill"></i>
                <span>Absensi Siswa</span>
            </a>
        </li>

        <li class="nav-heading">POIN</li>

        <li class="nav-item">
            <a href="{{ route('poin_siswa.index', 'budaya_positif') }}"
                class="nav-link {{ request()->route('kategori') == 'budaya_positif' ? 'active' : 'collapsed' }}">
                <i class="bi bi-person-plus"></i><span>Budaya Positif</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('poin_siswa.index', 'prestasi') }}"
                class="nav-link {{ request()->route('kategori') == 'prestasi' ? 'active' : 'collapsed' }}">
                <i class="bi bi-person-plus-fill"></i><span>Prestasi</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('poin_siswa.index', 'pelanggaran') }}"
                class="nav-link {{ request()->route('kategori') == 'pelanggaran' ? 'active' : 'collapsed' }}">
                <i class="bi bi-person-dash-fill"></i><span>Pelanggaran</span>
            </a>
        </li>

        <li class="nav-heading">PENGATURAN</li>

        <li class="nav-item">
            <a href="{{ route('berita.list') }}"
                class="nav-link {{ request()->routeIs('berita.list') ? 'active' : 'collapsed' }}">
                <i class="bi bi-card-list"></i>
                <span>Pengaturan Berita/Informasi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('pengaturan.list') ? 'active' : 'collapsed' }}"
                href="{{ route('pengaturan.index') }}">
                <i class="bi bi-gear-fill"></i>
                <span>Pengaturan</span>
            </a>
        </li>

    </ul>

</aside><!-- End Sidebar-->
