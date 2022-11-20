<div class="modal" id="modal_link" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nomor APM : <?= ($data) ? $data[0]['nomor_apm'] : '-'; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php if ($data) : ?>
                    <?php foreach ($data as $d) : ?>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <a class="btn btn-success btn-download" href="<?= $d['link']; ?>" target="_blank">Lihat</a>
                            </div>
                            <input type="text" class="form-control" placeholder="<?= $d['nama_file']; ?>" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        </div>
                    <?php endforeach; ?>

                <?php else : ?>
                    <h1>Belum ada data</h1>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>