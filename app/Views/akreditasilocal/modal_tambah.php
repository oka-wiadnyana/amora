<div class="modal" id="modal_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $id ? 'Ubah' : 'Tambah'; ?> Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-upload-file" method="post" enctype="multipart/form-data" action="<?= base_url('akreditasilocal/tambah_dok_apm'); ?>">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nomor_sub_apm">Sub Checklist</label>
                        <select name="nomor_sub_apm" id="" class="form-control">
                            <option selected disabled>Pilih sub apm</option>
                            <?php for ($i = 1; $i <= $jml_sub; $i++) : ?>
                                <option value="<?= $i; ?>" <?= isset($data_apm['nomor_sub_apm']) && $data_apm['nomor_sub_apm'] == $i ? 'selected' : ''; ?>><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="" class="form-control">

                            <option selected disabled>Pilih bulan</option>
                            <?php foreach ($bulan as $key => $val) : ?>
                                <option value="<?= $key; ?>" <?= isset($data_apm['bulan']) && $data_apm['bulan'] == $key ? 'selected' : ''; ?>><?= $val; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>

                        <select name="tahun" id="" class="form-control">
                            <option selected disabled>Pilih tahun</option>
                            <?php
                            $tahun = date('Y');
                            for ($i = 0; $i < 5; $i++) : ?>
                                <option value="<?= $tahun - $i; ?>" <?= isset($data_apm['tahun']) && $data_apm['tahun'] == $tahun - $i ? 'selected' : ''; ?>><?= $tahun - $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Nama dokumen</label>

                        <input type="text" name="nama_dokumen" id="" class="form-control" value="<?= isset($data_apm['nama_dokumen']) ? $data_apm['nama_dokumen'] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nomor_sub_apm">File</label>
                        <div class="input-group mb-3">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="nomor_apm" value="<?= $data_apm['nomor']; ?>">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <?php if (isset($data_apm['file'])) : ?>
                        <input type="hidden" name="file_lama" value="<?= $data_apm['file']; ?>">
                    <?php endif; ?>

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