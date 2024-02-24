const submission_code = $('#submission_code').val();
function emptyDosen(){
    $('#dosenModal').find('#id_dosen').val('');
    $('#dosenModal').find('#nama_dosen').val('');
    $('#dosenModal').find('#pendidikan_dosen').val('');
    $('#dosenModal').find('#nidn_dosen').val('');
    $('#dosenModal').find('#instansi_dosen').val('');
    $('#dosenModal').find('#jabatan_dosen').val('');
    $('#dosenModal').find('#fakultas_dosen').val('');
    $('#dosenModal').find('#program_studi_dosen').val('');
    $('#dosenModal').find('#id_sinta').val('');
    $('#dosenModal').find('#tugas_dosen').val('');
}
function emptyErrorDosen(){
    $('#dosenModal').find('#error_nama_dosen').html('');
    $('#dosenModal').find('#error_pendidikan_dosen').html('');
    $('#dosenModal').find('#error_nidn_dosen').html('');
    $('#dosenModal').find('#error_instansi_dosen').html('');
    $('#dosenModal').find('#error_jabatan_dosen').html('');
    $('#dosenModal').find('#error_fakultas_dosen').html('');
    $('#dosenModal').find('#error_program_studi_dosen').html('');
    $('#dosenModal').find('#error_id_sinta').html('');
    $('#dosenModal').find('#error_tugas_dosen').html('');
}
function openDosenModal(id){
    $('#loading-submit-dosen').addClass('d-none')
    emptyDosen()
    emptyErrorDosen()
    if(id === 0){
        $.ajax({
            url: submission_code+"/check-participant/dosen",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#dosenModal').modal('show')
            },
            error: function(error) {
                if(error.status === 403) {
                    Swal.fire({
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then((res) => {
                        $('#dosenModal').modal('hide')
                        $('#loading-submit-dosen').addClass('d-none')
                    })
                }
            }
        })
    } else {
        $.ajax({
            url: submission_code+"/tambah-participant/dosen/"+id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#dosenModal').find('#id_dosen').val(data.data.id);
                $('#dosenModal').find('#nama_dosen').val(data.data.nama);
                $('#dosenModal').find('#pendidikan_dosen').val(data.data.pendidikan);
                $('#dosenModal').find('#nidn_dosen').val(data.data.nidn);
                $('#dosenModal').find('#instansi_dosen').val(data.data.instansi);
                $('#dosenModal').find('#jabatan_dosen').val(data.data.jabatan);
                $('#dosenModal').find('#fakultas_dosen').val(data.data.fakultas);
                $('#dosenModal').find('#program_studi_dosen').val(data.data.program_studi);
                $('#dosenModal').find('#id_sinta').val(data.data.id_sinta);
                $('#dosenModal').find('#tugas_dosen').val(data.data.tugas);
                $('#dosenModal').modal('show')
            },
            error: function(error) {
                console.error(error)
            }
        })
    }
}
function getDosen(){
    $.ajax({
        url: submission_code+"/tambah-participant/dosen",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var tableBody = $('tbody#body-dosen-tabel');
            tableBody.empty();
            if(data.data.length > 0){
                $.each(data.data, function(index, row) {
                    var tr = $('<tr>').append(
                        $('<td>').text(row.nidn),
                        $('<td>').text(row.nama),
                        $('<td>').text(row.tugas),
                        $('<td>').html(
                            '<a href="#" onclick="openDosenModal('+row.id+')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>'+
                            '<a href="#" onclick="deleteData('+row.id+')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>'
                        ),
                    );
                    tableBody.append(tr);
                });
            } else {
                var tr = $('<tr>').append(
                    $('<td colspan="4" class="text-center">').html('<small><em>Tidak ada data dosen</em></small>'),
                );
                tableBody.append(tr);
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}
getDosen();
$('#simpan_dosen').on('click', function(){
    emptyErrorDosen()
    $('#loading-submit-dosen').removeClass('d-none')
    var id = $('#dosenModal').find('#id_dosen').val();
    const formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        submission_code: submission_code,
        id_dosen: id,
        nama_dosen: $('#dosenModal').find('#nama_dosen').val(),
        pendidikan_dosen: $('#dosenModal').find('#pendidikan_dosen').val(),
        nidn_dosen: $('#dosenModal').find('#nidn_dosen').val(),
        instansi_dosen: $('#dosenModal').find('#instansi_dosen').val(),
        jabatan_dosen: $('#dosenModal').find('#jabatan_dosen').val(),
        fakultas_dosen: $('#dosenModal').find('#fakultas_dosen').val(),
        program_studi_dosen: $('#dosenModal').find('#program_studi_dosen').val(),
        id_sinta: $('#dosenModal').find('#id_sinta').val(),
        tugas_dosen: $('#dosenModal').find('#tugas_dosen').val(),
    };
    if(!$('#dosenModal').find('input[name=id_dosen]').val() || $('#dosenModal').find('input[name=id_dosen]').val() === ''){
        $.ajax({
            method: 'POST',
            url: submission_code+"/tambah-participant/dosen",
            data: formData,
            success: function(response){
                Swal.fire({
                    text: response.message,
                    icon: 'success',
                }).then((res) => {
                    getDosen()
                    $('#dosenModal').modal('hide')
                    $('#loading-submit-dosen').addClass('d-none')
                })
            },
            error: function(error){
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama_dosen']) $('#dosenModal').find('#error_nama_dosen').html(errorResponse['nama_dosen'][0]);
                    if(errorResponse['pendidikan_dosen']) $('#dosenModal').find('#error_pendidikan_dosen').html(errorResponse['pendidikan_dosen'][0]);
                    if(errorResponse['nidn_dosen']) $('#dosenModal').find('#error_nidn_dosen').html(errorResponse['nidn_dosen'][0]);
                    if(errorResponse['instansi_dosen']) $('#dosenModal').find('#error_instansi_dosen').html(errorResponse['instansi_dosen'][0]);
                    if(errorResponse['jabatan_dosen']) $('#dosenModal').find('#error_jabatan_dosen').html(errorResponse['jabatan_dosen'][0]);
                    if(errorResponse['fakultas_dosen']) $('#dosenModal').find('#error_fakultas_dosen').html(errorResponse['fakultas_dosen'][0]);
                    if(errorResponse['program_studi_dosen']) $('#dosenModal').find('#error_program_studi_dosen').html(errorResponse['program_studi_dosen'][0]);
                    if(errorResponse['id_sinta']) $('#dosenModal').find('#error_id_sinta').html(errorResponse['id_sinta'][0]);
                    if(errorResponse['tugas_dosen']) $('#dosenModal').find('#error_tugas_dosen').html(errorResponse['tugas_dosen'][0]);
                } else if(error.status === 403) {
                    Swal.fire({
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then((res) => {
                        $('#dosenModal').modal('hide')
                        $('#loading-submit-dosen').addClass('d-none')
                    })
                }
                $('#loading-submit-dosen').addClass('d-none')
            }
        })
    } else {
        $.ajax({
            method: 'PUT',
            url: submission_code+"/tambah-participant/dosen/"+id,
            data: formData,
            success: function(response){
                Swal.fire({
                    text: response.message,
                    icon: 'success',
                }).then((res) => {
                    getDosen()
                    $('#dosenModal').modal('hide')
                    $('#loading-submit-dosen').addClass('d-none')
                })
            },
            error: function(error){
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama_dosen']) $('#dosenModal').find('#error_nama_dosen').html(errorResponse['nama_dosen'][0]);
                    if(errorResponse['pendidikan_dosen']) $('#dosenModal').find('#error_pendidikan_dosen').html(errorResponse['pendidikan_dosen'][0]);
                    if(errorResponse['nidn_dosen']) $('#dosenModal').find('#error_nidn_dosen').html(errorResponse['nidn_dosen'][0]);
                    if(errorResponse['instansi_dosen']) $('#dosenModal').find('#error_instansi_dosen').html(errorResponse['instansi_dosen'][0]);
                    if(errorResponse['jabatan_dosen']) $('#dosenModal').find('#error_jabatan_dosen').html(errorResponse['jabatan_dosen'][0]);
                    if(errorResponse['fakultas_dosen']) $('#dosenModal').find('#error_fakultas_dosen').html(errorResponse['fakultas_dosen'][0]);
                    if(errorResponse['program_studi_dosen']) $('#dosenModal').find('#error_program_studi_dosen').html(errorResponse['program_studi_dosen'][0]);
                    if(errorResponse['id_sinta']) $('#dosenModal').find('#error_id_sinta').html(errorResponse['id_sinta'][0]);
                    if(errorResponse['tugas_dosen']) $('#dosenModal').find('#error_tugas_dosen').html(errorResponse['tugas_dosen'][0]);
                }
                $('#loading-submit-dosen').addClass('d-none')
            }
        })
    }
})

function emptyMahasiswa(){
    $('#mahasiswaModal').find('#id_mahasiswa').val('');
    $('#mahasiswaModal').find('#nama_mahasiswa').val('');
    $('#mahasiswaModal').find('#nidn_mahasiswa').val('');
    $('#mahasiswaModal').find('#fakultas_mahasiswa').val('');
    $('#mahasiswaModal').find('#program_studi_mahasiswa').val('');
    $('#mahasiswaModal').find('#tugas_mahasiswa').val('');
}
function emptyErrorMahasiswa(){
    $('#mahasiswaModal').find('#error_nama_mahasiswa').html('');
    $('#mahasiswaModal').find('#error_nidn_mahasiswa').html('');
    $('#mahasiswaModal').find('#error_fakultas_mahasiswa').html('');
    $('#mahasiswaModal').find('#error_program_studi_mahasiswa').html('');
    $('#mahasiswaModal').find('#error_tugas_mahasiswa').html('');
}
function openMahasiswaModal(id){
    $('#loading-submit-mahasiswa').addClass('d-none')
    emptyMahasiswa()
    emptyErrorMahasiswa()
    if(id === 0){
        $.ajax({
            url: submission_code+"/check-participant/mahasiswa",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#mahasiswaModal').modal('show')
            },
            error: function(error) {
                if(error.status === 403) {
                    Swal.fire({
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then((res) => {
                        $('#mahasiswaModal').modal('hide')
                        $('#loading-submit-mahasiswa').addClass('d-none')
                    })
                }
            }
        })
    } else {
        $.ajax({
            url: submission_code+"/tambah-participant/mahasiswa/"+id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#mahasiswaModal').find('#id_mahasiswa').val(data.data.id);
                $('#mahasiswaModal').find('#nama_mahasiswa').val(data.data.nama);
                $('#mahasiswaModal').find('#nidn_mahasiswa').val(data.data.nidn);
                $('#mahasiswaModal').find('#fakultas_mahasiswa').val(data.data.fakultas);
                $('#mahasiswaModal').find('#program_studi_mahasiswa').val(data.data.program_studi);
                $('#mahasiswaModal').find('#tugas_mahasiswa').val(data.data.tugas);
                $('#mahasiswaModal').modal('show')
            },
            error: function(error) {
                console.error(error)
            }
        })
    }
}
function getMahasiswa(){
    $.ajax({
        url: submission_code+"/tambah-participant/mahasiswa",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var tableBody = $('tbody#body-mahasiswa-tabel');
            tableBody.empty();
            if(data.data.length > 0){
                $.each(data.data, function(index, row) {
                    var tr = $('<tr>').append(
                        $('<td>').text(row.nidn),
                        $('<td>').text(row.nama),
                        $('<td>').text(row.tugas),
                        $('<td>').html(
                            '<a href="#" onclick="openMahasiswaModal('+row.id+')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>'+
                            '<a href="#" onclick="deleteData('+row.id+')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>'
                        ),
                    );
                    tableBody.append(tr);
                });
            } else {
                var tr = $('<tr>').append(
                    $('<td colspan="4" class="text-center">').html('<small><em>Tidak ada data mahasiswa</em></small>'),
                );
                tableBody.append(tr);
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}
getMahasiswa();
$('#simpan_mahasiswa').on('click', function(){
    emptyErrorMahasiswa()
    $('#loading-submit-mahasiswa').removeClass('d-none')
    var id = $('#mahasiswaModal').find('#id_mahasiswa').val();
    const formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        submission_code: submission_code,
        id_mahasiswa: id,
        nama_mahasiswa: $('#mahasiswaModal').find('#nama_mahasiswa').val(),
        nidn_mahasiswa: $('#mahasiswaModal').find('#nidn_mahasiswa').val(),
        fakultas_mahasiswa: $('#mahasiswaModal').find('#fakultas_mahasiswa').val(),
        program_studi_mahasiswa: $('#mahasiswaModal').find('#program_studi_mahasiswa').val(),
        tugas_mahasiswa: $('#mahasiswaModal').find('#tugas_mahasiswa').val(),
    };
    if(!$('#mahasiswaModal').find('input[name=id_mahasiswa]').val() || $('#mahasiswaModal').find('input[name=id_mahasiswa]').val() === ''){
        $.ajax({
            method: 'POST',
            url: submission_code+"/tambah-participant/mahasiswa",
            data: formData,
            success: function(response){
                Swal.fire({
                    text: response.message,
                    icon: 'success',
                }).then((res) => {
                    getMahasiswa()
                    $('#mahasiswaModal').modal('hide')
                    $('#loading-submit-mahasiswa').addClass('d-none')
                })
            },
            error: function(error){
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama_mahasiswa']) $('#mahasiswaModal').find('#error_nama_mahasiswa').html(errorResponse['nama_mahasiswa'][0]);
                    if(errorResponse['nidn_mahasiswa']) $('#mahasiswaModal').find('#error_nidn_mahasiswa').html(errorResponse['nidn_mahasiswa'][0]);
                    if(errorResponse['fakultas_mahasiswa']) $('#mahasiswaModal').find('#error_fakultas_mahasiswa').html(errorResponse['fakultas_mahasiswa'][0]);
                    if(errorResponse['program_studi_mahasiswa']) $('#mahasiswaModal').find('#error_program_studi_mahasiswa').html(errorResponse['program_studi_mahasiswa'][0]);
                    if(errorResponse['tugas_mahasiswa']) $('#mahasiswaModal').find('#error_tugas_mahasiswa').html(errorResponse['tugas_mahasiswa'][0]);
                } else if(error.status === 403) {
                    Swal.fire({
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then((res) => {
                        $('#mahasiswaModal').modal('hide')
                        $('#loading-submit-mahasiswa').addClass('d-none')
                    })
                }
                $('#loading-submit-mahasiswa').addClass('d-none')
            }
        })
    } else {
        $.ajax({
            method: 'PUT',
            url: submission_code+"/tambah-participant/mahasiswa/"+id,
            data: formData,
            success: function(response){
                Swal.fire({
                    text: response.message,
                    icon: 'success',
                }).then((res) => {
                    getMahasiswa()
                    $('#mahasiswaModal').modal('hide')
                    $('#loading-submit-mahasiswa').addClass('d-none')
                })
            },
            error: function(error){
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama_mahasiswa']) $('#mahasiswaModal').find('#error_nama_mahasiswa').html(errorResponse['nama_mahasiswa'][0]);
                    if(errorResponse['nidn_mahasiswa']) $('#mahasiswaModal').find('#error_nidn_mahasiswa').html(errorResponse['nidn_mahasiswa'][0]);
                    if(errorResponse['fakultas_mahasiswa']) $('#mahasiswaModal').find('#error_fakultas_mahasiswa').html(errorResponse['fakultas_mahasiswa'][0]);
                    if(errorResponse['program_studi_mahasiswa']) $('#mahasiswaModal').find('#error_program_studi_mahasiswa').html(errorResponse['program_studi_mahasiswa'][0]);
                    if(errorResponse['tugas_mahasiswa']) $('#mahasiswaModal').find('#error_tugas_mahasiswa').html(errorResponse['tugas_mahasiswa'][0]);
                }
                $('#loading-submit-mahasiswa').addClass('d-none')
            }
        })
    }
})

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
                url: submission_code+"/delete-participant/"+id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response){
                    Swal.fire({
                        text: response.message,
                        icon: 'success',
                    }).then((res) => {
                        getDosen()
                        getMahasiswa()
                    })
                },
                error: function(error){
                    console.error(error);
                }
            })
        }
    });
}
