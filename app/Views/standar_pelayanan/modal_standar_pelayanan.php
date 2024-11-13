<div class="modal" id="modal_standar_pelayanan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_standar_pelayanan) ? "Ubah standar pelayanan" : "Tambah standar pelayanan"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('standar_pelayanan/upload_standar_pelayanan' . ($data_standar_pelayanan ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_standar_pelayanan">Nama standar pelayanan</label>
                        <input type="text" name="nama_standar_pelayanan" class="form-control" placeholder="Masukkan nama standar pelayanan" value="<?= ($data_standar_pelayanan) ? $data_standar_pelayanan['nama_standar_pelayanan'] : ""; ?>">
                    </div>



                    <div class="form-group">
                        <label for="">File</label>
                        <div class="input-group mb-3">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file_standar_pelayanan">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                        <?php if ($data_standar_pelayanan && $data_standar_pelayanan['file_standar_pelayanan']) : ?>
                            <a href="<?= base_url('standar_pelayanan/download/' . $data_standar_pelayanan['file_standar_pelayanan']); ?>" class="btn btn-success" target="_blank">File lama</a>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="id" value="<?= ($data_standar_pelayanan) ? $data_standar_pelayanan['id'] : ""; ?>">
                    <input type="hidden" name="file_lama" value="<?= ($data_standar_pelayanan) ? $data_standar_pelayanan['file_standar_pelayanan'] : ""; ?>">
                    <input type="hidden" name="bagian" value="<?= $bagian; ?>">

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
</script>