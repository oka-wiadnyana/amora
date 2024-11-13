<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0">
          <div class="col p-0">
            <h4 class="my-auto card-title">Parent Folder</h4>
          </div>

        </div>
        <div class="row mb-2">
          <div class="col">

            <a href="" class="btn btn-info tambah-folder">Tambah</a>
          </div>
        </div>



        <table class="table table-bordered mt-2 pt-2" id="table-folder">
          <thead>
            <tr>
              <th style="border-top: 1px solid grey;"> Nomor </th>
              <th style="border-top: 1px solid grey;"> Folder </th>

              <th style="border-top: 1px solid grey;"> Folder ID </th>
              <th style="border-top: 1px solid grey;"> Link </th>

              <th style="border-top: 1px solid grey;"> Aksi </th>
            </tr>
          </thead>
          <tbody class="">
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $d['folder']; ?></td>

                <td><?= $d['folder_id']; ?></td>
                <td><?= $d['link_folder']; ?></td>

                <td><a href="" data-id="<?= $d['id']; ?>" class="btn btn-info btn-ubah">Ubah</a> <a href="" data-id="<?= $d['id']; ?>" class="btn btn-danger btn-hapus">Hapus</a></td>
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
      function table_data_ass_internal() {
        let table = $('#table-folder').DataTable({
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

      $('.tambah-folder').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('pengaturan/modal_folder'); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_folder').modal('show');
          }
        });
      })
      $('.btn-ubah').each(function(index, element) {
        $(this).click(function(e) {
          e.preventDefault();
          let id = $(this).data('id');
          console.log(id);
          $.ajax({
            type: "post",
            url: "<?= base_url('pengaturan/modal_folder'); ?>",
            data: {
              id
            },
            dataType: "json",
            success: function(response) {
              $('#modal').html(response);
              $('#modal_folder').modal('show');
            }
          });
        })
      })
      $('.btn-hapus').each(function(index, element) {
        $(this).click(function(e) {
          e.preventDefault();
          let id = $(this).data('id');
          console.log(id);
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
                url: "<?= base_url('pengaturan/hapus_parent'); ?>",
                data: {
                  id
                },
                dataType: "json",
                success: function(response) {

                  $(location).attr('href', `<?= base_url('pengaturan/parent_folder'); ?>`);
                }
              });
            }
          })

        })
      })

    });
  </script>

  <?= $this->endSection(); ?>