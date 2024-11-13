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
                <form id="form-upload-file" method="post" action="<?= base_url('bpk/insert_laporan' . ($data_laporan ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" id="" class="form-select">
                            <option value="" selected disabled>Pilih</option>
                            <?php foreach ($tahuns as $tahun) : ?>
                                <option value="<?= $tahun; ?>" <?= $data_laporan && $data_laporan['tahun'] == $tahun ? "selected" : ''; ?>><?= $tahun; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal_laporan" class="form-control" value="<?= $data_laporan ? $data_laporan['tanggal_laporan'] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name='file'>
                    </div>

                    <div class="form-group">
                        <label for="jenis_laporan">Jenis Dokumen</label>
                        <select name="jenis_laporan" id="" class="form-select">
                            <option value="" selected disabled>Pilih</option>
                            <option value="laporan" <?= $data_laporan && $data_laporan['jenis_laporan'] == 'laporan' ? "selected" : ''; ?>>Laporan</option>

                            <option value="tindak_lanjut" <?= $data_laporan && $data_laporan['jenis_laporan'] == 'tindak_lanjut' ? "selected" : ''; ?>>TL</option>

                        </select>
                    </div>

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