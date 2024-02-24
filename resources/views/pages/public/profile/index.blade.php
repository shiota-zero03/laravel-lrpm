@extends('theme.layout')

@section('page', 'Profile')
@section('breadcrumb', auth()->user()->name)

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body py-3">
                    <form id="form" method="post" action="">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input value="{{ auth()->user()->name }}" class="form-control" id="name" name="name" type="text">
                            @error('name')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                        </div>
                        @if(auth()->user()->role == 5 || auth()->user()->role == 2)
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="nidn">NIDN <span class="text-danger">*</span></label>
                                <input value="{{ auth()->user()->nidn }}" class="form-control" id="nidn" name="nidn" type="text">
                                @error('nidn')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                            </div>
                        @endif
                        @if(auth()->user()->role == 1)
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="unit">Unit/Departemen <span class="text-danger">*</span></label>
                                <input value="{{ auth()->user()->unit }}" class="form-control" id="unit" name="unit" type="text">
                                @error('unit')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                            </div>
                        @endif
                        @if(auth()->user()->role == 2)
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="unit">Institusi <span class="text-danger">*</span></label>
                                <input value="{{ auth()->user()->unit }}" class="form-control" id="unit" name="unit" type="text">
                                @error('unit')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                            </div>
                        @endif
                        @if(auth()->user()->role == 1 || auth()->user()->role == 5)
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                <select name="jabatan" id="jabatan" class="form-control">
                                    <option value="" disabled>--Pilih Jabatan Fungsional--</option>
                                    @foreach($jabatan as $position)
                                        <option @if(auth()->user()->jabatan == $position->id) selected @endif value="{{ $position->id }}">{{ $position->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                                @error('jabatan')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                            </div>
                        @endif
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="email">Email <span class="text-danger">*</span></label>
                            <input value="{{ auth()->user()->email }}" class="form-control" id="email" name="email" type="text">
                            @error('email')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="password">Password <span id="default">(Default: 12345678) </span><span class="text-danger">*</span></label>
                            <input class="form-control" value="{{ auth()->user()->password }}" id="password" name="password" type="password">
                            @error('password')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="no_hp">Nomor Hp <span class="text-danger">*</span></label>
                            <input value="{{ auth()->user()->no_hp }}" class="form-control" id="no_hp" name="no_hp" type="number">
                            @error('nidn')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                        </div>
                        @if(auth()->user()->role == 5 || auth()->user()->role == 3 || auth()->user()->role == 4)
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="fakultas">Fakultas <span class="text-danger">*</span></label>
                                <select name="fakultas" id="fakultas" class="form-control">
                                    <option value="" disabled>--Pilih Fakultas--</option>
                                    @foreach($fakultas as $fak)
                                        <option @if(auth()->user()->fakultas == $fak->id) selected @endif value="{{ $fak->id }}">{{ $fak->nama_fakultas }}</option>
                                    @endforeach
                                </select>
                                @error('fakultas')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                            </div>
                            @if(auth()->user()->role == 5 || auth()->user()->role == 3)
                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="prodi">Program Studi <span class="text-danger">*</span></label>
                                    <select name="prodi" id="prodi" class="form-control">
                                        <option value="" disabled>--Pilih Program Studi--</option>
                                        @foreach($prodi as $prod)
                                            <option @if(auth()->user()->prodi == $prod->id) selected @endif value="{{ $prod->id }}">{{ $prod->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                    @error('prodi')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                                </div>
                            @endif
                        @endif
                        @if( auth()->user()->role == 5)
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="id_sinta">ID Sinta <span class="text-danger">*</span></label>
                                <input value="{{ auth()->user()->id_sinta }}" class="form-control" id="id_sinta" name="id_sinta" type="text">
                                @error('id_sinta')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="id_google_scholar">ID Google Scholar <span class="text-danger">*</span></label>
                                <input value="{{ auth()->user()->id_google_scholar }}" class="form-control" id="id_google_scholar" name="id_google_scholar" type="text">
                                @error('id_google_scholar')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                            </div>
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="id_scopus">ID Scopus <span class="text-danger">*</span></label>
                                <input value="{{ auth()->user()->id_scopus }}" class="form-control" id="id_scopus" name="id_scopus" type="text">
                                @error('id_scopus')<small class="text-danger fst-italic" id="error_name">{{ $message }}</small>@enderror
                            </div>
                        @endif
                        <button class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('custom_script')

<script>
    $('#profile-menu').removeClass('collapsed')
    $('#fakultas').on('change', function(){
        let id = $(this).val();
        getProdi(id)
    })
    function getProdi(id){
        $.ajax({
            method: 'GET',
            url: "profile/get-prodi/"+id,
            success: function(response){
                $('#prodi').empty();
                $('#prodi').append('<option value="" disabled>--Pilih Program Studi--</option>');
                $('form').find('select[name=prodi]').val('');

                $.each(response.data, function (index, item) {
                    $('#prodi').append('<option value="' + item.id + '">' + item.nama_prodi + '</option>');
                });
            },
            error: function(error){
                console.error(error)
            }
        })
    }
</script>

@endpush