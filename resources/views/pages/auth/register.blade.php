<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Register</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="{{ asset('assets/img/logo_campus.png') }}" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('assets/img/logo_campus.png') }}" alt="">
                                    <span class="d-none d-lg-block">LRPM UNDIRA</span>
                                </a>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Registrasi data Akun Mu</h5>
                                    </div>
                                    @if(Session::has('error'))
                                        <div class="text-sm alert alert-danger">{{ Session::get('error') }}</div>
                                    @endif

                                    <form class="row g-3 needs-validation" method="POST" action="">
                                        @csrf
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input class="form-control" value="{{ old('name') }}" id="name" name="name" type="text">
                                            @error('name')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="nidn">NIDN <span class="text-danger">*</span></label>
                                            <input class="form-control" value="{{ old('nidn') }}" id="nidn" name="nidn" type="text">
                                            @error('nidn')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                            <select name="jabatan" id="jabatan" class="form-control">
                                                <option value="" disabled @if(!old('jabatan')) selected @endif>--Pilih Jabatan Fungsional--</option>
                                                @foreach(\App\Models\Position::where('role_jabatan', '5')->get() as $position)
                                                    <option @if(old('jabatan') == $position->id) selected @endif value="{{ $position->id }}">{{ $position->nama_jabatan }}</option>
                                                @endforeach
                                            </select>
                                            @error('jabatan')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="email">Email <span class="text-danger">*</span></label>
                                            <input class="form-control" value="{{ old('email') }}" id="email" name="email" type="text">
                                            @error('email')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="password">Password <span class="text-danger">*</span></label>
                                            <input class="form-control" value="{{ old('password') }}" id="password" name="password" type="password">
                                            @error('password')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="no_hp">Nomor Hp <span class="text-danger">*</span></label>
                                            <input class="form-control" value="{{ old('no_hp') }}" id="no_hp" name="no_hp" type="number">
                                            @error('no_hp')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="fakultas">Fakultas <span class="text-danger">*</span></label>
                                            <select name="fakultas" id="fakultas" class="form-control">
                                                <option value="" disabled selected>--Pilih Fakultas--</option>
                                                @foreach(\App\Models\Faculty::all() as $fak)
                                                    <option value="{{ $fak->id }}">{{ $fak->nama_fakultas }}</option>
                                                @endforeach
                                            </select>
                                            @error('fakultas')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="prodi">Program Studi <span class="text-danger">*</span></label>
                                            <select name="prodi" id="prodi" class="form-control">
                                                <option value="" disabled selected>--Pilih Program Studi--</option>
                                            </select>
                                            @error('prodi')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="id_sinta">ID Sinta <span class="text-danger">*</span></label>
                                            <input class="form-control" id="id_sinta" name="id_sinta" type="text" value="{{ old('id_sinta') }}">
                                            @error('id_sinta')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="id_google_scholar">ID Google Scholar <span class="text-danger">*</span></label>
                                            <input class="form-control" id="id_google_scholar" name="id_google_scholar" type="text" value="{{ old('id_google_scholar') }}" >
                                            @error('id_google_scholar')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="form-control-label" for="id_scopus">ID Scopus <span class="text-danger">*</span></label>
                                            <input class="form-control" id="id_scopus" name="id_scopus" type="text" value="{{ old('id_scopus') }}">
                                            @error('id_scopus')<small class="text-danger fst-italic">{{ $message }} </small>@enderror
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Register</button>
                                        </div>
                                    </form>
                                    <div class="mt-2 text-center">
                                        <small>Sudah punya akun ?<a href="/"> Login sekarang</a></small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <script>
        $('#fakultas').on('change', function(){
            let id = $(this).val();
            getProdi(id)
        })

        function getProdi(id){
        $.ajax({
            method: 'GET',
            url: "get-prodi/"+id,
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

</body>

</html>
