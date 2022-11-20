<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0">
          <div class="col p-0">
            <h4 class="my-auto card-title">Daftar SK</h4>
          </div>

        </div>
        <div class="row mb-2">
          <div class="col">
            <?php if (session()->get('level') == "administrator" || session()->get('level') == "ketua" || session()->get('level') == "wakil" || session()->get('level') == "sekretaris" || session()->get('level') == "ortala") : ?>
              <a href="" class="btn btn-info tambah-sk">Tambah</a>
            <?php endif; ?>
          </div>
        </div>



        <table class="table table-bordered mt-2 pt-2" id="table-sk">
          <thead>
            <tr>
              <th style="border-top: 1px solid grey;"> Nomor </th>
              <th style="border-top: 1px solid grey;"> Nomor SK </th>
              <th style="border-top: 1px solid grey;"> Tentang </th>
              <th style="border-top: 1px solid grey;"> Penandatangan </th>
              <th style="border-top: 1px solid grey;"> Aksi </th>
            </tr>
          </thead>
          <tbody class="">

          </tbody>
        </table>

      </div>
    </div>
  </div>
  <div id="modal"></div>
  <script>
    $(document).ready(function() {
      function table_data_ass_internal() {
        let table = $('#table-sk').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "ajax": {
            "url": "<?= base_url('suratkeputusan/data_sk_datatable'); ?>",
            "type": "POST"
          },
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

      $('.tambah-sk').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('suratkeputusan/modal_sk'); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_sk').modal('show');
          }
        });
      })

      $('#table-sk').on('click', '.btn-ubah', function(e) {

        e.preventDefault();
        let id = $(this).data('id');
        console.log(id);
        $.ajax({
          type: "post",
          url: "<?= base_url('suratkeputusan/modal_sk'); ?>",
          data: {
            id
          },
          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_sk').modal('show');
          }
        });

      })

      $('#table-sk').on('click', '.btn-hapus', function(e) {

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
              url: "<?= base_url('suratkeputusan/hapus_sk'); ?>",
              data: {
                id
              },
              dataType: "json",
              success: function(response) {
                console.log(response);
                $(location).attr('href', `<?= base_url('suratkeputusan/daftar_surat_keputusan'); ?>`);
              }
            });
          }
        })

      })





    });
  </script>

  <?= $this->endSection(); ?>