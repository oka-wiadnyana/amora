<div class="modal" id="modal_uri" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_single_uri) ? "Ubah Uri" : "Tambah Uri"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('pengaturan/insert_uri' . ($data_single_uri ? '/ubah' : '')); ?>">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="">Method</label>
                        <input type="text" name="method" id="" class="form-control" value="<?= ($data_single_uri != null) ? $data_single_uri['method'] : ""; ?>">

                    </div>
                    <div class="form-group">
                        <label for="">URI</label>
                        <input type="text" name="uri" id="" class="form-control" value="<?= ($data_single_uri != null) ? $data_single_uri['uri'] : ""; ?>">

                    </div>

                    <input type="hidden" name="id" value="<?= $data_single_uri ? $data_single_uri['id'] : ""; ?>">
                    <button type="submit" class="btn btn-primary submit-button">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

    });
</script>