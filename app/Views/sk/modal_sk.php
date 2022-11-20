<div class="modal" id="modal_sk" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_sk) ? "Ubah sk" : "Tambah sk"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('suratkeputusan/upload_sk' . ($data_sk ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nomor_sk">Nomor sk</label>
                        <input type="text" name="nomor_sk" class="form-control" placeholder="Masukkan nomor sk" value="<?= ($data_sk) ? $data_sk['nomor_sk'] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="perihal_sk">Tentang</label>
                        <input type="text" name="perihal_sk" class="form-control" placeholder="Masukkan perihal sk" value="<?= ($data_sk) ? $data_sk['perihal_sk'] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="penandatangan">Penandatangan</label>
                        <select name="penandatangan" id="" class="form-control">
                            <option value="" selected disabled>Pilih..</option>
                            <option value="Ketua" <?= ($data_sk && $data_sk['penandatangan'] == 'Ketua') ? 'selected' : ""; ?>>Ketua</option>
                            <option value="Wakil Ketua" <?= ($data_sk && $data_sk['penandatangan'] == 'Wakil Ketua') ? 'selected' : ""; ?>>Wakil Ketua</option>
                            <option value="Panitera" <?= ($data_sk && $data_sk['penandatangan'] == 'Panitera') ? 'selected' : ""; ?>>Panitera</option>
                            <option value="Sekretaris" <?= ($data_sk && $data_sk['penandatangan'] == 'Sekretaris') ? 'selected' : ""; ?>>Sekretaris</option>
                            <option value="Lainnya" <?= ($data_sk && $data_sk['penandatangan'] == 'Lainnya') ? 'selected' : ""; ?>>Lainnya</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">File</label>
                        <div class="input-group mb-3">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file_sk">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                        <?php if ($data_sk) : ?>
                            <a href="<?= base_url('suratkeputusan/download/' . $data_sk['file_sk']); ?>" class="btn btn-success" target="_blank">File lama</a>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="id" value="<?= ($data_sk) ? $data_sk['id'] : ""; ?>">
                    <input type="hidden" name="file_lama" value="<?= ($data_sk) ? $data_sk['file_sk'] : ""; ?>">

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