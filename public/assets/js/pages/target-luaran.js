document.getElementById('dropdown-menu').classList.remove('collapsed')
document.getElementById('dropdown-nav').classList.add('show')

var table = $('#luaran-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "target-luaran/json",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'nama_luaran', name: 'nama_luaran'},
        {data: 'action', name: 'action'},
    ]
})

function emptyInput(){
    $('form').find('input[name=id]').val('');
    $('form').find('input[name=nama]').val('');
}
function emptyError(){
    $('#error_nama').html('')
}

function openModal(id){
    emptyInput();
    emptyError();
    if(id !== 0) {
        $.ajax({
            method: 'GET',
            url: "target-luaran/"+id,
            success: function(response){
                $('form').find('input[name=id]').val(response.data.id);
                $('form').find('input[name=nama]').val(response.data.nama_luaran);
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
        nama_luaran: $('form').find('input[name=nama]').val(),
    }

    if(!$('form').find('input[name=id]').val() || $('form').find('input[name=id]').val() === ''){
        $.ajax({
            method: 'POST',
            url: "target-luaran/",
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
                    if(errorResponse['nama_luaran']) $('#error_nama').html(errorResponse['nama_luaran'][0])
                }
                $('#loading-submit').addClass('d-none')
            }
        })
    } else {
        let id = $('form').find('input[name=id]').val();
        $.ajax({
            method: 'PUT',
            url: "target-luaran/"+id,
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
                    if(errorResponse['nama_luaran']) $('#error_nama').html(errorResponse['nama_luaran'][0])
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
                url: "target-luaran/"+id,
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
