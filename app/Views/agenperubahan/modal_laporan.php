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
                <form id="form-upload-file" method="post" action="<?= base_url('agenperubahan/insert_laporan' . ($data_laporan ? '/ubah' : '')); ?>" enctype="multipart/form-data">
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
                            <option value="rencana_perubahan" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'rencana_perubahan' ? "selected" : ''; ?>>Rencana Perubahan</option>
                            <option value="monev_internal" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'monev_internal' ? "selected" : ''; ?>>Monev internal</option>
                            <option value="monev_eksternal" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'monev_eksternal' ? "selected" : ''; ?>>Monev eksternal</option>
                            <option value="eviden" <?= $data_laporan && $data_laporan['jenis_dokumen'] == 'eviden' ? "selected" : ''; ?>>Eviden</option>

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

    <?php if ($data_laporan && $data_laporan['jenis_dokumen'] == 'eviden') :  ?>
        $('.div-nama-dokumen').show();
    <?php else : ?>
        $('.div-nama-dokumen').hide();
    <?php endif; ?>


    $('[name="jenis_dokumen"]').change(function() {
        let jenis = $(this).val();
        if (jenis == 'eviden') {
            $('.div-nama-dokumen').show();
        } else {
            $('.div-nama-dokumen').hide();
        }
    })



    // $('#form-upload-file').submit(function(e) {
    //     e.preventDefault()
    //     save()
    // })
</script>