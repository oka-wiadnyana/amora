<div class="modal" id="modal_response" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_keluhan) ? "Ubah response" : "Tambah response"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('shanti_care/insert_response' . ($data_keluhan ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group">
                        <label for="service_name">Response</label>
                        <textarea name="response" id="" cols="30" rows="5" class="form-control"><?= ($data_keluhan) ? $data_keluhan['response'] : ""; ?></textarea>

                    </div>


                    <input type="hidden" name="id" value="<?= ($data_keluhan) ? $data_keluhan['id'] : ""; ?>">
                    <input type="hidden" name="input_id" value="<?= $input_id; ?>">

                    <button type="submit" class="btn btn-primary submit-button">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>

        </div>
    </div>
</div>
<script>

</script>