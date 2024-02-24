@php
    (auth()->user()->role == 1 ? $role = 'admin' :
        (auth()->user()->role == 2 ? $role = 'reviewer' :
            (auth()->user()->role == 3 ? $role = 'prodi' :
                (auth()->user()->role == 4 ? $role = 'fakultas' :  $role = 'dosen')
            )
        )
    );
@endphp
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route($role.'.beranda.index') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo_campus.png') }}" alt="">
            <span class="d-none d-lg-block">UNDIRA</span>
        </a>
        @if (auth()->user()->role != 5)
            <i class="bi bi-list toggle-sidebar-btn me-5"></i>
        @endif
        @if ( auth()->user()->role == 5 )
            <i class="bi bi-list toggle-sidebar-btn me-5 d-md-none"></i>
        @endif
    </div>
    @if ( auth()->user()->role == 5 )
        <nav class="header-nav me-auto d-md-block d-none">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="dropdown-toggle ps-2">Penelitian</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow profile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.usulan-baru.index', 'penelitian') }}">
                                <i class="bi bi-file-earmark-plus"></i>
                                <span>Usulan Baru</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.proposal.index', 'penelitian') }}">
                                <i class="bi bi-filetype-pdf"></i>
                                <span>Proposal</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.spk.index', 'penelitian') }}">
                                <i class="bi bi-filetype-doc"></i>
                                <span>SPK</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.laporan-akhir.index', 'penelitian') }}">
                                <i class="bi bi-journal-text"></i>
                                <span>Laporan Akhir</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.monev.index', 'penelitian') }}">
                                <i class="bi bi-filetype-pdf"></i>
                                <span>Monev</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.laporan-final.index', 'penelitian') }}">
                                <i class="bi bi-journal-text"></i>
                                <span>Laporan Final</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.publikasi.index', 'penelitian') }}">
                                <i class="bi bi-journal-check"></i>
                                <span>Publikasi</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <span class="dropdown-toggle ps-2">Pengabdian Masyarakat</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow profile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.usulan-baru.index', 'pengabdian-masyarakat') }}">
                                <i class="bi bi-file-earmark-plus"></i>
                                <span>Usulan Baru</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.proposal.index', 'pengabdian-masyarakat') }}">
                                <i class="bi bi-filetype-pdf"></i>
                                <span>Proposal</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.spk.index', 'pengabdian-masyarakat') }}">
                                <i class="bi bi-filetype-doc"></i>
                                <span>SPK</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.laporan-akhir.index', 'pengabdian-masyarakat') }}">
                                <i class="bi bi-journal-text"></i>
                                <span>Laporan Akhir</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.monev.index', 'pengabdian-masyarakat') }}">
                                <i class="bi bi-filetype-pdf"></i>
                                <span>Monev</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.laporan-final.index', 'pengabdian-masyarakat') }}">
                                <i class="bi bi-journal-text"></i>
                                <span>Laporan Final</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route($role.'.publikasi.index', 'pengabdian-masyarakat') }}">
                                <i class="bi bi-journal-check"></i>
                                <span>Publikasi</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    @endif
    @php
        if ( auth()->user()->role == 1 ) {
            $notification = \App\Models\Notification::where('to_role', 1)
                                                ->where('read_status', 'unread')
                                                ->orderByDesc('created_at')
                                                ->get();
        } elseif ( auth()->user()->role == 2 ) {
            $notification = \App\Models\Notification::where('to_role', 2)
                                                ->where('read_status', 'unread')
                                                ->where('to_id', auth()->user()->id)
                                                ->orderByDesc('created_at')
                                                ->get();
        } elseif ( auth()->user()->role == 3 ) {
            $notification = \App\Models\Notification::where('to_role', 3)
                                                ->where('read_status', 'unread')
                                                ->where('to_id', auth()->user()->prodi)
                                                ->orderByDesc('created_at')
                                                ->get();
        } elseif ( auth()->user()->role == 5 ) {
            $notification = \App\Models\Notification::where('to_role', 5)
                                                ->where('read_status', 'unread')
                                                ->where('to_id', auth()->user()->id)
                                                ->orderByDesc('created_at')
                                                ->get();
        }
    @endphp
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown">

                <a onclick="clickNotification()" class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number">{{ isset($notification) && $notification->count() > 0 ? $notification->count() : '' }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        {{ isset($notification) && $notification->count() > 0 ? 'Terdapat ' . $notification->count() . ' Pemberitahuan Baru' : 'Tidak ada pemberitahuan' }}
                    </li>
                    @if(isset($notification))
                        @foreach ($notification as $item)
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <a href="{{ route($role.'.notification.read', $item->id) }}">
                                <li class="notification-item">
                                    <i class="bi bi-exclamation-circle text-warning"></i>
                                    <div>
                                        <h4>{{ $item->judul_notifikasi }}</h4>
                                        <p>{{ $item->text_notifikasi }}</p>
                                    </div>
                                </li>
                            </a>
                        @endforeach
                    @endif

                </ul>
            </li>

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a
                            class="dropdown-item d-flex align-items-center"
                            href="
                                @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                                    {{ route($role.'.profile.index') }}
                                @else
                                    #
                                @endif
                            ">
                            <i class="bi bi-person"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('auth.logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
<script>
    function clickNotification(){
        $.ajax({
            url: '/{{ $role }}/notification/read/all',
            method: 'GET',
            success: function(res){
                console.log(res)
            },
            error: function (err){
                console.log(err)
            }
        });
    }
</script>
