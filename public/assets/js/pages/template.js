document.getElementById('dropdown-menu').classList.remove('collapsed')
document.getElementById('dropdown-nav').classList.add('show')

var table = $('#template-datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: "dokumen-template/json",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'nama_template', name: 'nama_template'},
        {data: 'dokumen', name: 'dokumen'},
        {data: 'action', name: 'action'},
    ]
})

function emptyInput(){
    $('form').find('input[name=id]').val('');
    $('form').find('input[name=nama]').val('');
    $('form').find('input[name=dokumen]').val('');
    $('form').find('input[name=nama_dokumen]').val('');
}
function emptyError(){
    $('#error_nama').html('')
    $('#error_dokumen').html('')
}

$('#dokumen').on('change', function(){
    var file = $(this)[0].files;
    if (file && file[0]) {   
        $('form').find('input[name=nama_dokumen]').val(file[0]['name']);
    } else {
        $('form').find('input[name=nama_dokumen]').val('');
    }
})

function openModal(id){
    emptyInput();
    emptyError();
    if(id !== 0) {
        $.ajax({
            method: 'GET',
            url: "dokumen-template/"+id,
            success: function(response){
                $('form').find('input[name=id]').val(response.data.id);
                $('form').find('input[name=nama]').val(response.data.nama_template);
                $('form').find('input[name=nama_dokumen]').val(response.data.dokumen_template);
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

    if(!$('form').find('input[name=id]').val() || $('form').find('input[name=id]').val() === ''){
        var formData = new FormData();

        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('nama', $('form').find('input[name=nama]').val());
        formData.append('dokumen', $('form').find('input[name=dokumen]').prop('files')[0]);
        $.ajax({
            method: 'POST',
            url: "dokumen-template/",
            data: formData,
            contentType: false,
            processData:false,
            success: function(response){
                console.log(response)
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
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama']) $('#error_nama').html(errorResponse['nama'][0])
                }
                $('#loading-submit').addClass('d-none')
            }
        })
    } else {
        let id = $('form').find('input[name=id]').val();
        var formData = new FormData();

        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('nama', $('form').find('input[name=nama]').val());
        formData.append('dokumen', $('form').find('input[name=dokumen]').prop('files')[0]);

        $.ajax({
            method: 'POST',
            url: "dokumen-template/"+id,
            data: formData,
            contentType: false,
            processData:false,
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
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama_template']) $('#error_nama').html(errorResponse['nama_template'][0])
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
                url: "dokumen-template/"+id,
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
                    Swal.fire({
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                }
            })
        }
    });
}