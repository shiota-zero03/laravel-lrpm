const submission_code = $('#submission_code').val();
function openRABModal(){
    $('#loading-submit-rab').addClass('d-none')
    $('#nama_item_lainnya').addClass('d-none')

    $('#nama_item').val('')
    $('#harga_satuan').val('');
    $('#volume').val('1');
    $('#total').val('');

    $('#error_nama_item').html('');
    $('#error_harga_satuan').html('');
    $('#error_volume').html('');
    $('#error_total').html('');

    $('#rabModal').modal('show')
}
$('#nama_item').on('change', function(){
    if($(this).val() == 0) $('#nama_item_lainnya').removeClass('d-none')
    else $('#nama_item_lainnya').addClass('d-none')
})
$('#volume').on('input', function(){
    $('#total').val( ($(this).val() * $('#harga_satuan').val()) )
})
$('#harga_satuan').on('input', function(){
    $('#total').val( ($(this).val() * $('#volume').val()) )
})

function getRAB(){
    $.ajax({
        url: submission_code+"/tambah-rab",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var tableBody = $('tbody#body-rab-tabel');
            tableBody.empty();
            $('#banyak_rab').val(data.data.length);
            if(data.data.length > 0){
                $.each(data.data, function(index, row) {
                    var tr = $('<tr>').append(
                        $('<td>').text(row.nama_item),
                        $('<td>').text(row.harga),
                        $('<td>').text(row.volume),
                        $('<td>').text(row.total),
                        $('<td>').html(
                            '<a href="#" onclick="deleteData('+row.id+')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>'
                        ),
                    );
                    tableBody.append(tr);
                });
            } else {
                var tr = $('<tr>').append(
                    $('<td colspan="5" class="text-center">').html('<small><em>Tidak ada data rab</em></small>'),
                );
                tableBody.append(tr);
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}
getRAB();
$('#simpan_template').on('click', function(){
    $('#loading-submit-rab').removeClass('d-none')
    $('#error_nama_item').html('');
    $('#error_harga_satuan').html('');
    $('#error_volume').html('');
    $('#error_total').html('');

    var nama_item;
    if($('#nama_item').val() === "0") nama_item = $('#nama_item_lainnya').val();
    else nama_item = $('#nama_item').val();

    const formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        nama_item: nama_item,
        harga: $('#harga_satuan').val(),
        volume: $('#volume').val(),
        total: $('#total').val()
    }
    $.ajax({
        method: 'POST',
        url: submission_code+"/tambah-rab",
        data: formData,
        success: function(response){
            console.log(response)
            Swal.fire({
                text: response.message,
                icon: 'success',
            }).then((res) => {
                getRAB()
                $('#rabModal').modal('hide')
            })
            $('#loading-submit-rab').addClass('d-none')
        },
        error: function(error){
            if(error.status === 422) {
                const errorResponse = error.responseJSON.errors
                if(errorResponse['nama_item']) $('#error_nama_item').html(errorResponse['nama_item'][0]);
                if(errorResponse['harga']) $('#error_harga_satuan').html(errorResponse['harga'][0]);
                if(errorResponse['volume']) $('#error_volume').html(errorResponse['volume'][0]);
            }
            $('#loading-submit-rab').addClass('d-none')
        }
    })
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
                url: submission_code+"/delete-rab/"+id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response){
                    Swal.fire({
                        text: response.message,
                        icon: 'success',
                    }).then((res) => {
                        getRAB()
                    })
                },
                error: function(error){
                    console.error(error);
                }
            })
        }
    });
}
