<div class="modal" id="modal_bagian" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title"><?= ($data_bagian) ? "Ubah bagian" : "Tambah bagian"; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" action="<?= base_url('pengaturan/insert_bagian' . ($data_bagian ? '/ubah' : '')); ?>">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama_bagian">Nama Bagian</label>
                        <input type="text" name="nama_bagian" class="form-control" placeholder="Masukkan nama bagian" value="<?= ($data_bagian) ? $data_bagian['nama_bagian'] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="level">Level</label>
                        <select name="level" class="form-control">
                            <option selected disabled>Pilih level</option>
                            <option value="ketua" <?= ($data_bagian != null && $data_bagian['level'] == 'ketua') ? "selected" : ""; ?>>Ketua</option>
                            <option value="wakil" <?= $data_bagian != null && ($data_bagian['level'] == 'wakil') ? "selected" : ""; ?>>Wakil Ketua</option>
                            <option value="koordinator_area" <?= ($data_bagian != null && $data_bagian['level'] == 'koordinator_area') ? "selected" : ""; ?>>Koordinator Area</option>
                            <option value="hakim" <?= ($data_bagian != null && $data_bagian['level'] == 'hakim') ? "selected" : ""; ?>>Hakim</option>
                            <option value="pp" <?= ($data_bagian != null && $data_bagian['level'] == 'pp') ? "selected" : ""; ?>>Panitera Pengganti</option>
                            <option value="js" <?= ($data_bagian != null && $data_bagian['level'] == 'js') ? "selected" : ""; ?>>JS/JSP</option>
                            <option value="panitera" <?= ($data_bagian != null && $data_bagian['level'] == 'panitera') ? "selected" : ""; ?>>Panitera</option>
                            <option value="sekretaris" <?= ($data_bagian != null && $data_bagian['level'] == 'sekretaris') ? "selected" : ""; ?>>Sekretaris</option>
                            <option value="hukum" <?= ($data_bagian != null && $data_bagian['level'] == 'hukum') ? "selected" : ""; ?>>Kepaniteraan Hukum</option>
                            <option value="perdata" <?= ($data_bagian != null && $data_bagian['level'] == 'perdata') ? "selected" : ""; ?>>Kepaniteraan Perdata</option>
                            <option value="pidana" <?= ($data_bagian != null && $data_bagian['level'] == 'pidana') ? "selected" : ""; ?>>Kepaniteraan Pidana</option>
                            <option value="umum" <?= ($data_bagian != null && $data_bagian['level'] == 'umum') ? "selected" : ""; ?>>Umum dan Keuangan</option>
                            <option value="ortala" <?= ($data_bagian != null && $data_bagian['level'] == 'ortala') ? "selected" : ""; ?>>Ortala</option>
                            <option value="ptip" <?= ($data_bagian != null && $data_bagian['level'] == 'ptip') ? "selected" : ""; ?>>PTIP</option>
                            <option value="administrator" <?= ($data_bagian != null && $data_bagian['level'] == 'administrator') ? "selected" : ""; ?>>Admin</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="<?= ($data_bagian) ? $data_bagian['id'] : ""; ?>">

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