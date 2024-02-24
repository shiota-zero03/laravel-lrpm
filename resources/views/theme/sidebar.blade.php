@php
    (auth()->user()->role == 1 ? $role = 'admin' :
        (auth()->user()->role == 2 ? $role = 'reviewer' :
            (auth()->user()->role == 3 ? $role = 'prodi' :
                (auth()->user()->role == 4 ? $role = 'fakultas' :  $role = 'dosen')
            )
        )
    );
@endphp

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if(auth()->user()->role != 5)
            <li class="nav-item">
                <a class="nav-link collapsed" id="beranda-menu" href="{{ route($role.'.beranda.index') }}">
                    <i class="bi bi-house-check"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" id="dashboard-menu" href="{{ route($role.'.dashboard.index') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        @endif
        @if(auth()->user()->role == 1)
            <li class="nav-item">
                <a class="nav-link collapsed" id="config-menu" href="{{ route($role.'.config.index') }}">
                    <i class="bi bi-gear"></i>
                    <span>Konfigurasi</span>
                </a>
            </li>
        @endif
        @if(auth()->user()->role == 1)
            <li class="nav-item">
                <a class="nav-link collapsed" id="dropdown-menu" data-bs-target="#dropdown-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-list"></i><span>Dropdown</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dropdown-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.dropdown.jabatan.index') }}">
                            <i class="bi bi-circle"></i><span>Jabatan Fusional</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.fakultas.index') }}">
                            <i class="bi bi-circle"></i><span>Fakultas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.prodi.index') }}">
                            <i class="bi bi-circle"></i><span>Program Studi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.mitra_funding.index') }}">
                            <i class="bi bi-circle"></i><span>Pendanaan Mitra</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.template.index') }}">
                            <i class="bi bi-circle"></i><span>Dokumen Template</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.skema.index') }}">
                            <i class="bi bi-circle"></i><span>Skema</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.riset.index') }}">
                            <i class="bi bi-circle"></i><span>Riset Unggulan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.tema.index') }}">
                            <i class="bi bi-circle"></i><span>Tema</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.topik.index') }}">
                            <i class="bi bi-circle"></i><span>Topik</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.luaran.index') }}">
                            <i class="bi bi-circle"></i><span>Target Luaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.dropdown.rab.index') }}">
                            <i class="bi bi-circle"></i><span>Item RAB</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" id="user-menu" data-bs-target="#daftar-pengguna" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Daftar Pengguna</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="daftar-pengguna" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('admin.user.index', 'admin') }}">
                            <i class="bi bi-circle"></i><span>Admin</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.index', 'dosen') }}">
                            <i class="bi bi-circle"></i><span>Dosen</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.index', 'reviewer') }}">
                            <i class="bi bi-circle"></i><span>Reviewer</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.index', 'program-studi') }}">
                            <i class="bi bi-circle"></i><span>Program Studi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.index', 'fakultas') }}">
                            <i class="bi bi-circle"></i><span>Fakultas</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link collapsed"
                data-bs-target="#penelitian-nav" id="penelitian-menu" data-bs-toggle="collapse" href="#">
                <i class="bi bi-vector-pen"></i><span>Penelitian</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="penelitian-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                @if(auth()->user()->role != 2)
                    <li>
                        <a href="{{ route($role.'.usulan-baru.index', 'penelitian') }}">
                            <i class="bi bi-circle"></i><span>Usulan Baru</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route($role.'.proposal.index', 'penelitian') }}">
                        <i class="bi bi-circle"></i><span>Proposal</span>
                    </a>
                </li>
                @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                    <li>
                        <a href="{{ route($role.'.spk.index', 'penelitian') }}">
                            <i class="bi bi-circle"></i><span>SPK</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route($role.'.laporan-akhir.index', 'penelitian') }}">
                        <i class="bi bi-circle"></i><span>Laporan Akhir</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route($role.'.monev.index', 'penelitian') }}">
                        <i class="bi bi-circle"></i><span>Monev</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route($role.'.laporan-final.index', 'penelitian') }}">
                        <i class="bi bi-circle"></i><span>Laporan Final</span>
                    </a>
                </li>
                @if(auth()->user()->role != 2)
                    <li>
                        <a href="{{ route($role.'.publikasi.index', 'penelitian') }}">
                            <i class="bi bi-circle"></i><span>Publikasi</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed"
                data-bs-target="#pengabdian-masyarakat-nav" id="pengabdian-masyarakat-menu" data-bs-toggle="collapse" href="#">
                <i class="bi bi-vector-pen"></i><span>Pengabdian Masyarakat</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="pengabdian-masyarakat-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                @if(auth()->user()->role != 2)
                    <li>
                        <a href="{{ route($role.'.usulan-baru.index', 'pengabdian-masyarakat') }}">
                            <i class="bi bi-circle"></i><span>Usulan Baru</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route($role.'.proposal.index', 'pengabdian-masyarakat') }}">
                        <i class="bi bi-circle"></i><span>Proposal</span>
                    </a>
                </li>
                @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                    <li>
                        <a href="{{ route($role.'.spk.index', 'pengabdian-masyarakat') }}">
                            <i class="bi bi-circle"></i><span>SPK</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route($role.'.laporan-akhir.index', 'pengabdian-masyarakat') }}">
                        <i class="bi bi-circle"></i><span>Laporan Akhir</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route($role.'.monev.index', 'pengabdian-masyarakat') }}">
                        <i class="bi bi-circle"></i><span>Monev</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route($role.'.laporan-final.index', 'pengabdian-masyarakat') }}">
                        <i class="bi bi-circle"></i><span>Laporan Final</span>
                    </a>
                </li>
                @if(auth()->user()->role != 2)
                    <li>
                        <a href="{{ route($role.'.publikasi.index', 'pengabdian-masyarakat') }}">
                            <i class="bi bi-circle"></i><span>Publikasi</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        @if(auth()->user()->role == 1 || auth()->user()->role == 5)
            <li class="nav-item">
                <a class="nav-link collapsed" id="profile-menu" href="{{ route($role.'.profile.index') }}">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link collapsed text-danger" id="logout-menu" href="{{ route('auth.logout') }}">
                <i class="bi bi-box-arrow-left text-danger"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>
