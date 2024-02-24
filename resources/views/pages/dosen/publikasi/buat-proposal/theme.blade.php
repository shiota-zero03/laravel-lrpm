@extends('theme.layout')

@section('page', 'Publikasi')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')
@section('breadcrumbs_sub_page', 'Publikasi')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/timeline-pengajuan.css') }}">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between">
                            <h5 class="card-title">Pengajuan Publikasi</h5>
                            <h5 class="card-title">Kode Pengajuan : <br class="d-md-none" /><b>{{ $check_code->submission_code }}</b></h5>
                            <input type="hidden" value="{{ $check_code->submission_code }}" id="submission_code">
                        </div>
                        <hr class="my-2">
                        <div class="row">
                            <div class="col">
                                <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                                            <div id="inner-1" class="inner-circle bg-secondary"></div>
                                            <p class="h6 mt-3 mb-1 fw-bold">Review Laporan Final</p>
                                        </div>
                                    </div>
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                                            <div id="inner-2" class="inner-circle bg-secondary"></div>
                                            <p class="h6 mt-3 mb-1 fw-bold">Form Publikasi</p>
                                        </div>
                                    </div>
                                    <div class="timeline-step">
                                        <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010">
                                            <div id="inner-3" class="inner-circle bg-secondary"></div>
                                            <p class="h6 mt-3 mb-1 fw-bold">Review Publikasi</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-1">
                        <div>
                            @yield('fase')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_script')

@endpush
