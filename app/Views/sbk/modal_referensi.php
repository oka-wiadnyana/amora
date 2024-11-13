<div class="modal" id="modal_referensi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_referensi) ? "Ubah referensi" : "Tambah referensi"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('review/insert_referensi' . ($data_referensi ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="service_unit">Unit</label>
                        <select name="service_unit" id="" class="form-control">
                            <option value="" selected disabled>Pilih</option>
                            <option value="Pidana" <?= $data_referensi && $data_referensi['service_unit'] == "Pidana" ? "selected" : ""; ?>>Pidana</option>
                            <option value="Perdata" <?= $data_referensi && $data_referensi['service_unit'] == "Perdata" ? "selected" : ""; ?>>Perdata</option>
                            <option value="Hukum" <?= $data_referensi && $data_referensi['service_unit'] == "Hukum" ? "selected" : ""; ?>>Hukum</option>
                            <option value="Umum" <?= $data_referensi && $data_referensi['service_unit'] == "Umum" ? "selected" : ""; ?>>Umum</option>
                            <option value="Inzage" <?= $data_referensi && $data_referensi['service_unit'] == "Inzage" ? "selected" : ""; ?>>Inzage</option>
                            <option value="E-Court" <?= $data_referensi && $data_referensi['service_unit'] == "E-Court" ? "selected" : ""; ?>>E-Court</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="service_name">Nama layanan</label>
                        <input type="text" name="service_name" class="form-control" placeholder="Masukkan nama layanan" value="<?= ($data_referensi) ? $data_referensi['service_name'] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="">File</label>
                        <div class="input-group mb-3">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="id" value="<?= ($data_referensi) ? $data_referensi['id'] : ""; ?>">
                    <input type="hidden" name="old_file" value="<?= ($data_referensi) ? $data_referensi['file'] : ""; ?>">

                    <button type="submit" class="btn btn-primary submit-button">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    $('.custom-file-input').each(function() {
        $(this).change(function() {
            let nama = $(this).val()
            console.log(nama)
            $(this).siblings('.custom-file-label').text(nama)
        })
    });

    function save() {
        let data = new FormData($('#form-upload-file')[0]);
        // console.log(data);

        $.ajax({
                url: "<?= base_url('akreditasi/upload_doc'); ?>", //pointed url 
                type: 'POST',
                data: data,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function() {
                    $('.submit-button').attr('disable', 'disabled')
                    $('.submit-button').html('<i class="fa fa-spin fa-spinner"></i>')
                },
                complete: function() {
                    $('.submit-button').removeAttr('disable')
                    $('.submit-button').html('Submit')
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }

            })
            .done(function(data) {
                console.log(data);
                //here what you want to do after ajax call success
                if (data.status == 'invalid') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.msg,

                    })

                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil disimpan',

                    })
                }
                // console.log(data)
            })
            .fail(function() {
                console.log('error')
            })

    }


    // $('#form-upload-file').submit(function(e) {
    //     e.preventDefault()
    //     save()
    // })
</script>