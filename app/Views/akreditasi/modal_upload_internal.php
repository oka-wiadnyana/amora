<div class="modal" id="modal_upload_internal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Dok Ass Internal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" enctype="multipart/form-data" action="<?= base_url('akreditasi/upload_ass_internal'); ?>">
                    <?= csrf_field(); ?>

                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select name="semester" id="" class="form-control">

                            <option selected disabled>Pilih semester</option>
                            <option value="I">I</option>
                            <option value="II">II</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>

                        <select name="tahun" id="" class="form-control">
                            <option selected disabled>Pilih tahun</option>
                            <?php
                            $tahun = date('Y');
                            for ($i = 0; $i < 5; $i++) : ?>
                                <option value="<?= $tahun - $i; ?>"><?= $tahun - $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_sub_apm">File</label>
                        <div class="input-group mb-3">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file_internal">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?= ($data) ? $data['id'] : ""; ?>">


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

    // function save() {
    //     let data = new FormData($('#form-upload-file')[0]);
    //     // console.log(data);

    //     $.ajax({
    //             url: "<?= base_url('akreditasi/upload_doc'); ?>", //pointed url 
    //             type: 'POST',
    //             data: data,
    //             dataType: 'json',
    //             cache: false,
    //             contentType: false,
    //             processData: false,

    //             beforeSend: function() {
    //                 $('.submit-button').attr('disable', 'disabled')
    //                 $('.submit-button').html('<i class="fa fa-spin fa-spinner"></i>')
    //             },
    //             complete: function() {
    //                 $('.submit-button').removeAttr('disable')
    //                 $('.submit-button').html('Submit')
    //             },
    //             error: function(xhr, ajaxOptions, thrownError) {
    //                 alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
    //             }

    //         })
    //         .done(function(data) {
    //             console.log(data);
    //             //here what you want to do after ajax call success
    //             if (data.status == 'invalid') {

    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Oops...',
    //                     text: data.msg,

    //                 })

    //             } else {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Berhasil',
    //                     text: 'Data berhasil disimpan',

    //                 })
    //             }
    //             // console.log(data)
    //         })
    //         .fail(function() {
    //             console.log('error')
    //         })

    // }


    // $('#form-upload-file').submit(function(e) {
    //     e.preventDefault()
    //     save()
    // })
</script>