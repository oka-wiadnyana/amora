<div class="modal" id="modal_laporan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_laporan) ? "Ubah dokumen" : "Tambah dokumen"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('dokumenrapat/insert_laporan' . ($data_laporan ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="" class="form-select">
                            <option value="" selected disabled>Pilih</option>
                            <?php foreach ($bulans as $key => $value) : ?>
                                <option value="<?= $key; ?>" <?= $data_laporan && $data_laporan['bulan'] == $key ? "selected" : ''; ?>><?= $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
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
                        <label for="tanggal_dokumen">Tanggal Dokumen</label>
                        <input type="date" name="tanggal_dokumen" class="form-control" value="<?= $data_laporan ? $data_laporan['tanggal_dokumen'] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="jenis_dokumen">Jenis Dokumen</label>
                        <select name="jenis_dokumen" id="" class="form-select">
                            <option value="" selected disabled>Pilih</option>
                            <option value="rapat_bulanan" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'rapat_bulanan' ? "selected" : ''; ?>>Rapat bulanan</option>
                            <option value="monev_kinerja" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'monev_tl' ? "selected" : ''; ?>>Rapat Monev Kinerja</option>
                            <option value="pimpinan" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'pimpinan' ? "selected" : ''; ?>>Rapat Hakim</option>
                            <option value="hakim" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'hakim' ? "selected" : ''; ?>>Rapat Pimpinan</option>

                            <option value="panitera" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'panitera' ? "selected" : ''; ?>>Panitera</option>
                            <option value="sekretaris" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'sekretaris' ? "selected" : ''; ?>>Sekretaris</option>

                            <option value="lainnya" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'lainnya' ? "selected" : ''; ?>>Lainnya</option>

                        </select>
                    </div>
                    <div class="form-group div-nama-dokumen">
                        <label for="nama_dokumen">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" class="form-control" value="<?= $data_laporan ? $data_laporan['nama_dokumen'] : ""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">File</label>
                        <input class="form-control" type="file" id="file" name='file'>

                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Lampiran</label>
                        <input class="form-control" type="file" id="file" name='lampiran'>
                        <span class="text-muted"><i>
                                (Surat Undangan, Tanda Terima, Absen, Foto)
                            </i></span>
                    </div>

                    <input type="hidden" name="id" value="<?= $data_laporan ? $data_laporan['id'] : ""; ?>">
                    <input type="hidden" name="file_lama" value="<?= $data_laporan ? $data_laporan['file'] : ""; ?>">
                    <input type="hidden" name="lampiran_lama" value="<?= $data_laporan ? $data_laporan['lampiran'] : ""; ?>">
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

    <?php if ($data_laporan && ($data_laporan['jenis_dokumen'] == 'lainnya' || $data_laporan['jenis_dokumen'] == 'panitera' || $data_laporan['jenis_dokumen'] == 'sekretaris')) :  ?>
        $('.div-nama-dokumen').show();
    <?php else : ?>
        $('.div-nama-dokumen').hide();
    <?php endif; ?>


    $('[name="jenis_dokumen"]').change(function() {
        let jenis = $(this).val();
        if (jenis == 'lainnya' || jenis == 'panitera' || jenis == 'sekretaris') {
            $('.div-nama-dokumen').show();
        } else {
            $('.div-nama-dokumen').hide();
        }
    })

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