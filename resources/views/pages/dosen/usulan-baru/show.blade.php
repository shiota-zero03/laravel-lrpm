@extends('theme.layout')

@section('page', 'Usulan Baru')
@section('breadcrumb', $data->submission_code)

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/timeline-tracking.css') }}">

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pt-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dosen.usulan-baru.index', ['type' => $type]) }}" class="btn btn-info text-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        <a href="{{ route('dosen.usulan-baru.detail', ['type' => $type, 'id' => $data->id]) }}" class="btn btn-primary">Lihat detail usulan</a>
                    </div>
                    @if($data->status_usulan !== 'Draft')
                        <div class="timeline">
                            @foreach($timeline as $time)
                                <div class="timeline-row">
                                    <div class="timeline-time text-dark">
                                        {{ date('H:i', strtotime($time->created_at)) }}<small>{{ date('Y, d F', strtotime($time->created_at)) }}</small>
                                    </div>
                                    <div class="timeline-content border rounded
                                        @if($time->status_progress == 'rejected') border-danger
                                        @elseif($time->status_progress == 'revised') border-warning
                                        @else border-success
                                        @endif
                                        d-flex align-items-center px-2">
                                        <i class="icon-attachment"></i>
                                        <div class="me-2">
                                            @if($time->status_progress == 'rejected') <i style="font-size: 4rem" class="text-danger bi bi-x-circle-fill"></i>
                                            @elseif($time->status_progress == 'revised') <i style="font-size: 4rem" class="text-warning bi bi-info-circle-fill"></i>
                                            @else <i style="font-size: 4rem" class="text-success bi bi-check-circle-fill"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h5 class="my-0">{{ $time->judul_progress }}</h5>
                                            <small class="my-0">{{ $time->text_progress }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="my-5">
                            <h2 class="fst-italic text-center fw-bold text-uppercase">Belum ada traking pada usulan ini</h2>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('custom_script')

@endpush
