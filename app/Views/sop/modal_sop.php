<div class="modal" id="modal_sop" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_sop) ? "Ubah sop" : "Tambah sop"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('sop/upload_sop' . ($data_sop ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_sop">Nama sop</label>
                        <input type="text" name="nama_sop" class="form-control" placeholder="Masukkan nama sop" value="<?= ($data_sop) ? $data_sop['nama_sop'] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nomor_sop">Nomor sop</label>
                        <input type="text" name="nomor_sop" class="form-control" placeholder="Masukkan nomor sop" value="<?= ($data_sop) ? $data_sop['nomor_sop'] : ""; ?>">
                    </div>


                    <div class="form-group">
                        <label for="">File</label>
                        <div class="input-group mb-3">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file_sop">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                        <?php if ($data_sop && $data_sop['file_sop']) : ?>
                            <a href="<?= base_url('sop/download/' . $data_sop['file_sop']); ?>" class="btn btn-success" target="_blank">File lama</a>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="id" value="<?= ($data_sop) ? $data_sop['id'] : ""; ?>">
                    <input type="hidden" name="file_lama" value="<?= ($data_sop) ? $data_sop['file_sop'] : ""; ?>">
                    <input type="hidden" name="level" value="<?= $level; ?>">

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