<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex col-md-6 align-items-center mb-3 p-0">
          <div class="col-md-4 align-items-center p-0">
            <h4 class="my-auto card-title">Import Checklist</h4>
          </div>

        </div>
        <div class="row ">
          <div class="col-md-6">
            <form action="<?= base_url('akreditasi/import_checklist_db'); ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field(); ?>
              <div class="form-group">


                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="file_checklist">
                  <label class="custom-file-label" for="inputGroupFile01">Pilih file</label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mr-2">Submit</button>
              <a href="<?= base_url('akreditasi/download_format_checklist'); ?>" target="_blank" class="btn btn-success">Format</a>
          </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<div id="modal"></div>
<script>
  $(document).ready(function() {
    $('.custom-file-input').each(function() {
      $(this).change(function() {
        let nama = $(this).val()
        console.log(nama)
        $(this).siblings('.custom-file-label').text(nama)
      })
    });

    function table_data_ass_internal() {
      let table = $('#table-ass-internal').DataTable({
        // "processing": true,
        // "serverSide": true,
        "order": [],
        // "ajax": {
        //   "url": "<?= base_url('eksekusi/data_eksekusi_belum_datatable'); ?>",
        //   "type": "POST"
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
    table_data_ass_internal();

    $('.tambah-ass').click(function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= base_url('akreditasi/modal_upload_internal'); ?>",

        dataType: "json",
        success: function(response) {
          $('#modal').html(response);
          $('#modal_upload_internal').modal('show');
        }
      });
    })


    $('.btn-hapus').each(function(index, elem) {
      $(this).click(function(e) {
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
              url: "<?= base_url('akreditasi/hapus_internal'); ?>",
              data: {
                id
              },
              dataType: "json",
              success: function(response) {

                $(location).attr('href', `<?= base_url('pengaturan/bagian'); ?>`);
              }
            });
          }
        })
      })
    })

  });
</script>

<?= $this->endSection(); ?>