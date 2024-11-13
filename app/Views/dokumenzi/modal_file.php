<style>
    .dataTable>thead>tr>th[class*="sort"]:before,
    .dataTable>thead>tr>th[class*="sort"]:after {
        content: "" !important;
    }
</style>
<div class="modal" id="modal_file" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <table class="table-bordered" id="table-reform" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Nama file</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $no = 1; ?>
                        <?php foreach ($data_file as $file) : ?>
                            <tr>

                                <td><?= $no++; ?></td>
                                <td><?= $file['tahun']; ?></td>
                                <td><?= $file['nama_file']; ?></td>
                                <td><a href="<?= base_url('file_dokumen_zi/' . $file['file']); ?>" class="btn btn-success" target="_blank"><span class="mdi mdi-arrow-down-bold"></span> <a href="" data-id="<?= $file['id']; ?>" class="ms-2 btn btn-danger delete-btn"><span class="mdi mdi-trash-can"></span></a></td>

                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<script>
    function table_area() {

        table = $('#table-reform').DataTable({
            // "processing": true,
            // "serverSide": true,
            "order": [],
            // "ajax": {
            //     "url": url,
            //     "type": "POST"
            // },
            "columnDefs": [{
                    "target": 0,
                    "orderable": false,
                },
                {
                    responsivePriority: 1,
                    targets: 0,

                },
                {
                    responsivePriority: 1,
                    targets: 1,

                },
                {
                    responsivePriority: 1,
                    targets: 2,

                },
                {
                    responsivePriority: 1,
                    targets: -1,

                },


            ],
            rowReorder: {
                selector: 'td:nth-child(1)'
            },
            responsive: true

        })

    }
    table_area();
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
    $('.delete-btn').click(function(e) {

        e.preventDefault();
        let id = $(this).data('id');

        Swal.fire({
            title: 'Anda yakin?',
            text: "Anda tidak akan dapat mengulanginya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('dokumenzi/delete_file'); ?>",
                    data: {
                        id
                    },
                    dataType: "json",
                    success: function(response) {

                        $(location).attr('href', '<?= base_url('dokumenzi/data_area/' . current_url(true)->getSegment(6)); ?>');
                    }
                });
            }
        })


    })

    // $('#form-upload-file').submit(function(e) {
    //     e.preventDefault()
    //     save()
    // })
</script>