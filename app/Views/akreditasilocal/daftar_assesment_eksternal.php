<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex col-md-6 align-items-center mb-3 p-0">
          <div class="col align-items-center p-0">
            <h4 class="my-auto card-title">Asesment Eksternal</h4>
          </div>

        </div>

        <div class="row mb-2">
          <div class="col">

            <a href="" class="btn btn-info tambah-ass">Tambah/Update</a>
          </div>
        </div>

        <table class="table table-bordered mt-2 pt-2" id="table-ass-eksternal">
          <thead>
            <tr>
              <th style="border-top: 1px solid grey;"> Nomor </th>
              <th style="border-top: 1px solid grey;"> Semester </th>
              <th style="border-top: 1px solid grey;"> Tahun </th>
              <th style="border-top: 1px solid grey;"> Aksi </th>
              <!-- <th style="border-top: 1px solid grey;"> Aksi </th> -->
            </tr>
          </thead>
          <tbody class="">
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $d['semester']; ?></td>
                <td><?= $d['tahun']; ?></td>
                <td><a href="<?= base_url('ass_eksternal_local_file/' . $d['nama_file']); ?>" class="btn btn-secondary <?= !$d['nama_file'] ? 'disabled' : ''; ?>" target="_blank">File</a> <a class="btn btn-danger btn-hapus <?= !$d['nama_file'] ? 'disabled' : ''; ?>" data-id="<?= $d['id']; ?>">Hapus</a></td>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
  <div id="modal"></div>
  <script>
    $(document).ready(function() {
      function table_data_ass_eksternal() {
        let table = $('#table-ass-eksternal').DataTable({
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
      table_data_ass_eksternal();

      $('.tambah-ass').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('akreditasilocal/modal_upload_eksternal'); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_upload_eksternal').modal('show');
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
                url: "<?= base_url('akreditasilocal/hapus_eksternal'); ?>",
                data: {
                  id
                },
                dataType: "json",
                success: function(response) {

                  $(location).attr('href', `<?= base_url('akreditasilocal/daftar_assesment_eksternal'); ?>`);
                }
              });
            }
          })
        })
      })

    });
  </script>

  <?= $this->endSection(); ?>