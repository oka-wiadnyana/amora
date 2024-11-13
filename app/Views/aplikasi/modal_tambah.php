<div class="modal" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($aplikasi) ? "Ubah aplikasi" : "Tambah aplikasi"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('aplikasi/insert_aplikasi' . ($aplikasi ? '/ubah' : '')); ?>" enctype="multipart/form-data">
                    <?= csrf_field(); ?>

                    <div class="form-group">
                        <label for="">Nama aplikasi</label>
                        <input type="text" name="nama_aplikasi" id="" class="form-control" value="<?= $aplikasi['nama_aplikasi'] ?? ""; ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Penjelasan</label>
                        <textarea name="penjelasan" id="" cols="30" rows="5" class="form-control"><?= $aplikasi['penjelasan'] ?? ""; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Latar belakang</label>
                        <textarea name="latar_belakang" id="" cols="30" rows="5" class="form-control"><?= $aplikasi['latar_belakang'] ?? ""; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Dampak langsung</label>
                        <textarea name="dampak_langsung" id="" cols="30" rows="5" class="form-control"><?= $aplikasi['dampak_langsung'] ?? ""; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Link</label>
                        <input type="text" name="link" id="" class="form-control" value="<?= $aplikasi['link'] ?? ""; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Manual book</label>
                        <input class="form-control" type="file" id="file" name='file'>
                    </div>



                    <input type="hidden" name="id_aplikasi" value="<?= $aplikasi ? $aplikasi['id'] : ""; ?>">

                    <input type="hidden" name="file_lama" value="<?= $aplikasi ? $aplikasi['file'] : ""; ?>">
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