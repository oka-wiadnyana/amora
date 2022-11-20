<div class="modal" id="modal_folder" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_single_folder) ? "Ubah Folder" : "Tambah folder"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('pengaturan/insert_folder' . ($data_single_folder ? '/ubah' : '')); ?>">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="">Folder</label>
                        <select name="folder" class="form-control select-folder">
                            <option selected disabled>Pilih Folder</option>
                            <option value="checklist" <?= ($data_single_folder != null && $data_single_folder['folder'] == 'checklist') ? "selected" : ""; ?>>Checklist</option>
                            <option value="ass_internal" <?= $data_single_folder != null && ($data_single_folder['folder'] == 'ass_internal') ? "selected" : ""; ?>>Ass Internal</option>
                            <option value="ass_eksternal" <?= $data_single_folder != null && ($data_single_folder['folder'] == 'ass_eksternal') ? "selected" : ""; ?>>Ass Eksternal</option>

                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="">Folder ID</label>
                        <input type="text" name="folder_id" id="" class="form-control" value="<?= $data_single_folder ? $data_single_folder['folder_id'] : ""; ?>">
                    </div>
                    <div class="form-group ">
                        <label for="">Link</label>
                        <input type="text" name="link_folder" id="" class="form-control" value="<?= $data_single_folder ? $data_single_folder['link_folder'] : ""; ?>">
                    </div>
                    <input type="hidden" name="id" value="<?= $data_single_folder ? $data_single_folder['id'] : ""; ?>">
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