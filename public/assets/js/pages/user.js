document.getElementById('user-menu').classList.remove('collapsed')
document.getElementById('daftar-pengguna').classList.add('show')

const role = $('#role').val();

var columns = [
    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
    {data: 'name', name: 'name'},
    {data: 'email', name: 'email'},
    {data: 'status', name: 'status'},
    {data: 'action', name: 'action'},
];
if ( role === 'dosen' || role === 'admin' || role === 'reviewer') {
    columns.splice(1, 0, {data: 'nidn', name: 'nidn'})
}
if ( role === 'dosen' ) {
    columns.splice(4, 0, {data: 'jur', name: 'jur'});
}
if ( role === 'program-studi' ) {
    columns.splice(3, 0, {data: 'fak', name: 'fak'});
    columns.splice(4, 0, {data: 'jur', name: 'jur'});
}
if( role === 'fakultas' ) {
    columns.splice(3, 0, {data: 'fak', name: 'fak'});
}
if( role === 'reviewer' ) {
    columns.splice(4, 0, {data: 'jabatan', name: 'jabatan'});
}

var table = $('#user-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: ""+role+"/json",
    columns: columns
})

function emptyInput(){
    $('#prodi').empty();
    $('form').find('input[name=id]').val('');
    $('form').find('input[name=name]').val('');
    $('form').find('input[name=nidn]').val('');
    $('form').find('input[name=unit]').val('');
    $('form').find('select[name=jabatan]').val('');
    $('form').find('input[name=email]').val('');
    $('form').find('input[name=no_hp]').val('');
    $('form').find('input[name=id_sinta]').val('');
    $('form').find('input[name=id_google_scholar]').val('');
    $('form').find('input[name=id_scopus]').val('');
    $('form').find('select[name=fakultas]').val('');
    $('#prodi').append('<option value="" disabled>--Pilih Program Studi--</option>');
    $('form').find('select[name=prodi]').val('');
}
function emptyError(){
    $('#error_name').html('')
    $('#error_nidn').html('')
    $('#error_unit').html('')
    $('#error_jabatan').html('')
    $('#error_email').html('')
    $('#error_no_hp').html('')
    $('#error_id_sinta').html('')
    $('#error_id_google_scholar').html('')
    $('#error_id_scopus').html('')
    $('#error_fakultas').html('')
    $('#error_prodi').html('')
}

function openModal(id){
    emptyInput();
    emptyError();
    if(id === 0) {
        $('#userModal').modal('show')
        $('form').find('input[name=password]').val('12345678');
        $('form').find('input[name=password]').attr('disabled', true);
        $('#default').removeClass('d-none')
    } else {
        $.ajax({
            method: 'GET',
            url: ""+role+"/"+id,
            success: function(response){
                $('form').find('input[name=id]').val(response.data.id);
                $('form').find('input[name=password]').val(response.data.password);
                $('form').find('input[name=password]').removeAttr('disabled');
                $('#default').addClass('d-none')
                $('form').find('input[name=name]').val(response.data.name);
                $('form').find('input[name=nidn]').val(response.data.nidn);
                $('form').find('input[name=unit]').val(response.data.unit);
                $('form').find('select[name=jabatan]').val(response.data.jabatan);
                $('form').find('input[name=email]').val(response.data.email);
                $('form').find('input[name=no_hp]').val(response.data.no_hp);
                $('form').find('input[name=id_sinta]').val(response.data.id_sinta);
                $('form').find('input[name=id_google_scholar]').val(response.data.id_google_scholar);
                $('form').find('input[name=id_scopus]').val(response.data.id_scopus);
                $('form').find('select[name=fakultas]').val(response.data.fakultas);

                getProdi(response.data.fakultas, response.data.prodi)
                // $('form').find('select[name=prodi]').val(response.data.prodi);
                $('#userModal').modal('show')
            },
            error: function(error){
                console.log(error)
            }
        })
    }
}

$('#btn_save').on('click', function(){
    emptyError();
    $('#loading-submit').removeClass('d-none');
    const formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        name: $('form').find('input[name=name]').val(),
        nidn: $('form').find('input[name=nidn]').val(),
        jabatan: $('form').find('select[name=jabatan]').val(),
        unit: $('form').find('input[name=unit]').val(),
        email: $('form').find('input[name=email]').val(),
        password: $('form').find('input[name=password]').val(),
        no_hp: $('form').find('input[name=no_hp]').val(),
        role: $('form').find('input[name=role]').val(),
        institusi: $('form').find('input[name=institusi]').val(),
        id_sinta: $('form').find('input[name=id_sinta]').val(),
        id_google_scholar: $('form').find('input[name=id_google_scholar]').val(),
        id_scopus: $('form').find('input[name=id_scopus]').val(),
        fakultas: $('form').find('select[name=fakultas]').val(),
        prodi: $('form').find('select[name=prodi]').val(),
    }
    if(!$('form').find('input[name=id]').val() || $('form').find('input[name=id]').val() === ''){
        $.ajax({
            method: 'POST',
            url: ""+role+"/",
            data: formData,
            success: function(response){
                Swal.fire({
                    text: response.message,
                    icon: 'success',
                }).then((res) => {
                    table.ajax.reload()
                    $('#userModal').modal('hide')
                    $('#loading-submit').addClass('d-none')
                })
                $('#loading-submit').addClass('d-none')
            },
            error: function(error){
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['name']) $('#error_name').html(errorResponse['name'][0])
                    if(errorResponse['nidn']) $('#error_nidn').html(errorResponse['nidn'][0])
                    if(errorResponse['unit']) $('#error_unit').html(errorResponse['unit'][0])
                    if(errorResponse['jabatan']) $('#error_jabatan').html(errorResponse['jabatan'][0])
                    if(errorResponse['email']) $('#error_email').html(errorResponse['email'][0])
                    if(errorResponse['no_hp']) $('#error_no_hp').html(errorResponse['no_hp'][0])

                    if(errorResponse['id_sinta']) $('#error_id_sinta').html(errorResponse['id_sinta'][0])
                    if(errorResponse['id_google_scholar']) $('#error_id_google_scholar').html(errorResponse['id_google_scholar'][0])
                    if(errorResponse['id_scopus']) $('#error_id_scopus').html(errorResponse['id_scopus'][0])
                    if(errorResponse['fakultas']) $('#error_fakultas').html(errorResponse['fakultas'][0])
                    if(errorResponse['prodi']) $('#error_prodi').html(errorResponse['prodi'][0])
                }
                $('#loading-submit').addClass('d-none')
            }
        })
    } else {
        var id = $('form').find('input[name=id]').val();
        $.ajax({
            method: 'PUT',
            url: ""+role+"/"+id,
            data: formData,
            success: function(response){
                Swal.fire({
                    text: response.message,
                    icon: 'success',
                }).then((res) => {
                    table.ajax.reload()
                    $('#userModal').modal('hide')
                    $('#loading-submit').addClass('d-none')
                })
                $('#loading-submit').addClass('d-none')
            },
            error: function(error){
                console.log(error)
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['name']) $('#error_name').html(errorResponse['name'][0])
                    if(errorResponse['nidn']) $('#error_nidn').html(errorResponse['nidn'][0])
                    if(errorResponse['unit']) $('#error_unit').html(errorResponse['unit'][0])
                    if(errorResponse['jabatan']) $('#error_jabatan').html(errorResponse['jabatan'][0])
                    if(errorResponse['email']) $('#error_email').html(errorResponse['email'][0])
                    if(errorResponse['no_hp']) $('#error_no_hp').html(errorResponse['no_hp'][0])

                    if(errorResponse['id_sinta']) $('#error_id_sinta').html(errorResponse['id_sinta'][0])
                    if(errorResponse['id_google_scholar']) $('#error_id_google_scholar').html(errorResponse['id_google_scholar'][0])
                    if(errorResponse['id_scopus']) $('#error_id_scopus').html(errorResponse['id_scopus'][0])
                    if(errorResponse['fakultas']) $('#error_fakultas').html(errorResponse['fakultas'][0])
                    if(errorResponse['prodi']) $('#error_prodi').html(errorResponse['prodi'][0])
                }
                $('#loading-submit').addClass('d-none')
            }
        })
    }
})

if(role === 'program-studi' || role === 'dosen'){
    $('#fakultas').on('change', function(){
        let id = $(this).val();
        getProdi(id, 0)
    })
}
function getProdi(id, fak){
    $.ajax({
        method: 'GET',
        url: ""+role+"/get-prodi/"+id,
        success: function(response){
            $('#prodi').empty();
            $('#prodi').append('<option value="" disabled>--Pilih Program Studi--</option>');

            $.each(response.data, function (index, item) {
                $('#prodi').append('<option value="' + item.id + '">' + item.nama_prodi + '</option>');
            });

            if(fak === 0){
                $('form').find('select[name=prodi]').val('');
            } else {
                $('form').find('select[name=prodi]').val(fak);
            }
        },
        error: function(error){
            console.error(error)
        }
    })
}
function verifikasi(id){
    Swal.fire({
        text: 'Anda yakin ingin mengaktifkan akun ini ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: "tidak"
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = {
                _token: $('meta[name="csrf-token"]').attr('content'),
            }
            $.ajax({
                method: 'PUT',
                url: ""+role+"/verifikasi/"+id,
                data: formData,
                success: function(response){
                    Swal.fire({
                        text: response.message,
                        icon: 'success',
                    }).then((res) => {
                        table.ajax.reload()
                        $('#userModal').modal('hide')
                        $('#loading-submit').addClass('d-none')
                    })
                },
                error: function(error){
                    console.log(error)
                }
            })
        }
    })
}
function deleteData(id){
    Swal.fire({
        text: 'Anda yakin ingin menghapus data ini ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: "tidak"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: 'DELETE',
                url: +role+"/"+id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response){
                    Swal.fire({
                        text: response.message,
                        icon: 'success',
                    }).then((res) => {
                        table.ajax.reload()
                    })
                },
                error: function(error){
                    console.error(error);
                }
            })
        }
    });
}
