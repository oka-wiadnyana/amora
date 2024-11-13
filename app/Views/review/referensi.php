<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0">
          <div class="col p-0">
            <h4 class="my-auto card-title">Referensi SP</h4>
          </div>

        </div>
        <div class="row mb-2">
          <div class="col">

            <a href="" class="btn btn-info tambah-referensi">Tambah</a>

          </div>
        </div>



        <table class="table table-bordered mt-2 pt-2" id="table">
          <thead>
            <tr>
              <th style="border-top: 1px solid grey;"> Nomor </th>
              <th style="border-top: 1px solid grey;"> Nama Unit </th>
              <th style="border-top: 1px solid grey;"> Nama Layanan </th>
              <th style="border-top: 1px solid grey;"> File </th>

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
      function table_referensi() {
        let table = $('#table').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "ajax": {
            "url": "<?= base_url('review/referensi_datatable'); ?>",
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
      table_referensi();

      $('.tambah-referensi').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('review/modal_referensi'); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_referensi').modal('show');
          }
        });
      })

      $('#table').on('click', '.edit-btn', function(e) {

        e.preventDefault();
        let id = $(this).data('id');
        console.log(id);
        $.ajax({
          type: "post",
          url: "<?= base_url('review/modal_referensi/ubah'); ?>",
          data: {
            id
          },
          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_referensi').modal('show');
          }
        });

      })

      $('#table').on('click', '.hapus-btn', function(e) {

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
              type: "delete",
              url: `<?= getenv('REVIEW_API_URL'); ?>/${id}`,

              dataType: "json",
              success: function(response) {
                console.log(response);
                $(location).attr('href', `<?= base_url('review/referensi'); ?>`);
              }
            });
          }
        })

      })





    });
  </script>

  <?= $this->endSection(); ?>