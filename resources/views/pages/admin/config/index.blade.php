@extends('theme.layout')

@section('page', 'Konfigurasi')
@section('breadcrumb', 'Konfigurasi')

@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body py-3">
                    <h6 class="card-title">Set Up Konfigurasi</h6>
                    <hr>
                    <form action="" method="post">
                        @csrf
                        <div class="d-flex align-items-center">
                            <div class="col-8">
                                <h5 class="card-title">Izinkan dosen untuk membuat usulan baru :</h5>
                            </div>
                            <div class="col-4">
                                <label for="usulan_baru_ya"><input @if( $data['usulan_baru'] && $data['usulan_baru']->status == 1 ) checked @endif type="radio" value="1" name="usulan_baru" id="usulan_baru_ya"><span class="ms-2 me-4">Ya</span></label>
                                <label for="usulan_baru_tidak"><input @if( $data['usulan_baru'] && $data['usulan_baru']->status == 0 ) checked @endif type="radio" value="0" name="usulan_baru" id="usulan_baru_tidak"><span class="ms-2">Tidak</span></label>
                            </div>
                        </div>
                        @error('usulan_baru')
                            <small class="text-danger"><em>{{ $message }}</em></small>
                        @enderror
                        <hr>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('custom_script')
<script>
    $('#config-menu').removeClass('collapsed');
</script>

@endpush
