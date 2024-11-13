<div class="modal" id="modal_laporan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_laporan) ? "Ubah laporan" : "Tambah laporan"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('absen_ptsp/insert_laporan' . ($data_laporan ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>


                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $data_laporan ? $data_laporan['tanggal'] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name='file'>
                    </div>

                    <div class="form-group">
                        <label for="jenis_laporan">Jenis Dokumen</label>
                        <select name="jenis_laporan" id="" class="form-select">
                            <option value="" selected disabled>Pilih</option>

                            <option value="pagi" <?= $data_laporan && $data_laporan['jenis_laporan'] == 'pagi' ? "selected" : ''; ?>>Pagi</option>
                            <option value="sore" <?= $data_laporan && $data_laporan['jenis_laporan'] == 'sore' ? "selected" : ''; ?>>Sore</option>

                        </select>
                    </div>
                    <input type="hidden" name="level" value="<?= $level; ?>">
                    <input type="hidden" name="id" value="<?= $data_laporan ? $data_laporan['id'] : ""; ?>">
                    <input type="hidden" name="file_lama" value="<?= $data_laporan ? $data_laporan['file'] : ""; ?>">
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