document.getElementById('dropdown-menu').classList.remove('collapsed')
document.getElementById('dropdown-nav').classList.add('show')

var table = $('#tema-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "tema/json",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'riset', name: 'riset'},
        {data: 'nama_tema', name: 'nama_tema'},
        {data: 'action', name: 'action'},
    ]
})

function emptyInput(){
    $('form').find('input[name=id]').val('');
    $('form').find('input[name=nama]').val('');
    $('form').find('select[name=id_riset]').val('');
}
function emptyError(){
    $('#error_nama').html('')
    $('#error_id_riset').html('')
}

function openModal(id){
    emptyInput();
    emptyError();
    if(id !== 0) {
        $.ajax({
            method: 'GET',
            url: "tema/"+id,
            success: function(response){
                $('form').find('input[name=id]').val(response.data.id);
                $('form').find('input[name=nama]').val(response.data.nama_tema);
                $('form').find('select[name=id_riset]').val(response.data.id_riset);
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
        nama_tema: $('form').find('input[name=nama]').val(),
        id_riset: $('form').find('select[name=id_riset]').val(),
    }

    if(!$('form').find('input[name=id]').val() || $('form').find('input[name=id]').val() === ''){
        $.ajax({
            method: 'POST',
            url: "tema/",
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
                    if(errorResponse['nama_tema']) $('#error_nama').html(errorResponse['nama_tema'][0])
                    if(errorResponse['id_riset']) $('#error_id_riset').html(errorResponse['id_riset'][0])
                }
                $('#loading-submit').addClass('d-none')
            }
        })
    } else {
        let id = $('form').find('input[name=id]').val();
        $.ajax({
            method: 'PUT',
            url: "tema/"+id,
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
                    if(errorResponse['nama_tema']) $('#error_nama').html(errorResponse['nama_tema'][0])
                    if(errorResponse['id_riset']) $('#error_id_riset').html(errorResponse['id_riset'][0])
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
                url: "tema/"+id,
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
