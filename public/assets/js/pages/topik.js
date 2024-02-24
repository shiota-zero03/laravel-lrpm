document.getElementById('dropdown-menu').classList.remove('collapsed')
document.getElementById('dropdown-nav').classList.add('show')

var table = $('#topik-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "topik/json",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'riset', name: 'riset'},
        {data: 'tema', name: 'tema'},
        {data: 'nama_topik', name: 'nama_topik'},
        {data: 'action', name: 'action'},
    ]
})

function emptyInput(){
    $('form').find('input[name=id]').val('');
    $('form').find('input[name=nama]').val('');
    $('form').find('select[name=id_riset]').val('');
    $('form').find('select[name=id_tema]').val('');
}
function emptyError(){
    $('#error_nama').html('')
    $('#error_id_riset').html('')
    $('#error_id_tema').html('')
}

function openModal(id){
    emptyInput();
    emptyError();
    $('#id_tema').empty()
    $('#id_tema').append('<option value="" disabled>-- Pilih tema --</option>');
    $('form').find('select[name=id_tema]').val('');
    if(id !== 0) {
        $.ajax({
            method: 'GET',
            url: "topik/"+id,
            success: function(response){
                $('form').find('input[name=id]').val(response.data.id);
                $('form').find('input[name=nama]').val(response.data.nama_topik);
                $('form').find('select[name=id_riset]').val(response.data.riset_id);
                getTema(response.data.riset_id, response.data.tema_id)

                $('#userModal').modal('show')
            },
            error: function(error){
                console.log(error)
            }
        })
    } else $('#userModal').modal('show')
}

$('#btn_save').on('click', function(){
    emptyError()
    $('#loading-submit').removeClass('d-none')
    const formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        nama_topik: $('form').find('input[name=nama]').val(),
        id_tema: $('form').find('select[name=id_tema]').val(),
        id_riset: $('form').find('select[name=id_riset]').val(),
    }

    if(!$('form').find('input[name=id]').val() || $('form').find('input[name=id]').val() === ''){
        $.ajax({
            method: 'POST',
            url: "topik/",
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
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama_topik']) $('#error_nama').html(errorResponse['nama_topik'][0])
                    if(errorResponse['id_riset']) $('#error_id_riset').html(errorResponse['id_riset'][0])
                    if(errorResponse['id_tema']) $('#error_id_tema').html(errorResponse['id_tema'][0])
                }
                $('#loading-submit').addClass('d-none')
            }
        })
    } else {
        let id = $('form').find('input[name=id]').val();
        $.ajax({
            method: 'PUT',
            url: "topik/"+id,
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
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama_topik']) $('#error_nama').html(errorResponse['nama_topik'][0])
                    if(errorResponse['id_riset']) $('#error_id_riset').html(errorResponse['id_riset'][0])
                    if(errorResponse['id_tema']) $('#error_id_tema').html(errorResponse['id_tema'][0])
                }
                $('#loading-submit').addClass('d-none')
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
                url: "topik/"+id,
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

$('#id_riset').on('change', function(){
    getTema($(this).val(), 0)
})

function getTema(id, tema){
    $.ajax({
        url: '/tema/riset/'+id,
        method: 'GET',
        success: function(response){
            $('#id_tema').empty()
            $('#id_tema').append('<option value="" disabled>-- Pilih tema --</option>');

            $.each(response.data, function (index, item) {
                $('#id_tema').append('<option value="' + item.id + '">' + item.nama_tema + '</option>');
            });
            if(tema === 0){
                $('form').find('select[name=id_tema]').val('');
            } else {
                $('form').find('select[name=id_tema]').val(tema);
            }
        },
        error: function(error){
            console.error(error)
        }
    })
}
