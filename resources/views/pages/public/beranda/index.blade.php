@extends('theme.layout')

@section('page', 'Beranda')
@section('breadcrumb', 'Beranda')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center text-primay py-5">
                            <div class="d-md-block d-none">
                                <img src="{{ asset('assets/img/logo_campus.png') }}" alt="">
                            </div>
                            <div class="d-md-none">
                                <img width="80%" src="{{ asset('assets/img/logo_campus.png') }}" alt="">
                            </div>
                            <h2 class="mt-3">
                                <strong>
                                    Selamat Datang Di Website LRPM Universitas Dian Nusantara
                                </strong>
                            </h2>
                        </div>
                        @if (auth()->user()->role == 5)
                            <div class="d-md-flex justify-content-center align-items-center mb-md-5 mb-3 text-center">
                                <a style="font-size: 16px" href="{{ route('dosen.usulan-baru.index', 'penelitian') }}" class="btn btn-primary rounded btn-lg fw-bold mb-2 me-md-2">Penelitian</a>
                                <a style="font-size: 16px" href="{{ route('dosen.usulan-baru.index', 'pengabdian-masyarakat') }}" class="btn btn-primary rounded btn-lg fw-bold mb-2 ms-md-2">Pengabdian Masyarakat</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom_script')
@if (auth()->user()->role !== 5)
    <script>
        document.getElementById('beranda-menu').classList.remove('collapsed')
    </script>
@endif
@endpush