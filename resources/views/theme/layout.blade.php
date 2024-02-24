@php
    (auth()->user()->role == 1 ? $role = 'admin' : 
        (auth()->user()->role == 2 ? $role = 'reviewer' : 
            (auth()->user()->role == 3 ? $role = 'prodi' :
                (auth()->user()->role == 4 ? $role = 'fakultas' :  $role = 'dosen')
            )
        )
    );
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    @include('theme.head')
    @stack('custom_style')
</head>

<body>

    @include('theme.header')
    @if (auth()->user()->role != 5)
        @include('theme.sidebar')

        <div id="main" class="main" style="min-height: 82vh;">
            <div class="pagetitle">
                <h1>@yield('page')</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route($role.'.beranda.index') }}">Home</a></li>
                        <li class="breadcrumb-item">@yield('breadcrumb')</li>
                        @hasSection('breadcrumbs_sub_page')
                            <li class="breadcrumb-item">@yield('breadcrumbs_sub_page')</li>
                        @endif
                        @hasSection('breadcrumbs_sub_sub_page')
                            <li class="breadcrumb-item">@yield('breadcrumbs_sub_sub_page')</li>
                        @endif
                    </ol>
                </nav>
            </div>

            @yield('content')
        </div>
    @else
        <div class="container d-md-block d-none" style="padding-top: 70px; min-height: 82vh">
            <div class="pagetitle">
                <h1>@yield('page')</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route($role.'.beranda.index') }}">Home</a></li>
                        <li class="breadcrumb-item">@yield('breadcrumb')</li>
                        @hasSection('breadcrumbs_sub_page')
                            <li class="breadcrumb-item">@yield('breadcrumbs_sub_page')</li>
                        @endif
                    </ol>
                </nav>
            </div>

            @yield('content')
        </div>
        <div class="d-md-none">
                @include('theme.sidebar')

            <div id="main" class="main" style="min-height: 82vh;">
                <div class="pagetitle">
                    <h1>@yield('page')</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route($role.'.beranda.index') }}">Home</a></li>
                            <li class="breadcrumb-item">@yield('breadcrumb')</li>
                            @hasSection('breadcrumbs_sub_page')
                                <li class="breadcrumb-item">@yield('breadcrumbs_sub_page')</li>
                            @endif
                            @hasSection('breadcrumbs_sub_sub_page')
                                <li class="breadcrumb-item">@yield('breadcrumbs_sub_sub_page')</li>
                            @endif
                        </ol>
                    </nav>
                </div>

                @yield('content')
            </div>
        </div>
    @endif


    @include('theme.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    
    @include('theme.script')
    @stack('custom_script')
</body>

</html>
