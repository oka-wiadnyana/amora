<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0">
          <div class="col p-0">
            <h4 class="my-auto card-title">Daftar Review</h4>
          </div>

        </div>
        <div class="row mb-2">
          <div class="col">

            <a href="" class="btn btn-info laporan-btn">Cetak Laporan</a>

          </div>
        </div>



        <table class="table table-bordered mt-2 pt-2" id="table">
          <thead>
            <tr>
              <th style="border-top: 1px solid grey;"> Nomor </th>
              <th style="border-top: 1px solid grey;"> Tanggal </th>
              <th style="border-top: 1px solid grey;"> Nama </th>
              <th style="border-top: 1px solid grey;"> No WA </th>
              <th style="border-top: 1px solid grey;"> Layanan </th>
              <th style="border-top: 1px solid grey;"> Kesesuaian Waktu </th>
              <th style="border-top: 1px solid grey;"> Evaluasi Waktu </th>
              <th style="border-top: 1px solid grey;"> Kesesuaian Syarat </th>
              <th style="border-top: 1px solid grey;"> Evaluasi Syarat </th>
              <th style="border-top: 1px solid grey;"> Kesesuaian Biaya </th>
              <th style="border-top: 1px solid grey;"> Evaluasi Biaya </th>
              <th style="border-top: 1px solid grey;"> Kesesuaian Pengaduan </th>
              <th style="border-top: 1px solid grey;"> Evaluasi Pengaduan </th>
              <th style="border-top: 1px solid grey;"> Kesesuaian Jam Kerja </th>
              <th style="border-top: 1px solid grey;"> Evaluasi Jam Kerja </th>

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
      function table_keluhan() {
        let table = $('#table').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "ajax": {
            "url": "<?= base_url('review/review_datatable'); ?>",
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
      table_keluhan();

      $('.laporan-btn').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('review/modal_laporan'); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_laporan').modal('show');
          }
        });
      })

      $('#table').on('click', '.response-btn', function(e) {

        e.preventDefault();
        let id = $(this).data('id');
        console.log(id);
        $.ajax({
          type: "post",
          url: "<?= base_url('shanti_care/modal_response'); ?>",
          data: {
            id
          },
          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_response').modal('show');
          }
        });

      })

      $('#table').on('click', '.btn-hapus', function(e) {

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