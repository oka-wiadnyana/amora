<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <div class="row mb-2">
    <div class="col">
      <span class="h3">

        Absen <?= ucwords($level); ?>
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <a href="" class="btn btn-primary tambah-btn">Tambah Dokumen</a>
    </div>
  </div>
  <nav class="mt-2">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">

      <button class="nav-link active button_jenis_absen_ptsp" id="nav-pagi-tab" data-toggle="tab" data-target="#nav-pagi" type="button" role="tab" aria-controls="nav-pagi" aria-selected="false" data-jenis='pagi'>Pagi</button>
      <button class="nav-link button_jenis_absen_ptsp" id="nav-sore-tab" data-toggle="tab" data-target="#nav-sore" type="button" role="tab" aria-controls="nav-sore" aria-selected="false" data-jenis='sore'>Sore</button>

    </div>
  </nav>
  <div class="tab-content bg-white" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-pagi" role="tabpanel" aria-labelledby="nav-pagi-tab">
      <div class="row mb-2">

        <div class="table-responsive bg-white p-2 rounded-3 shadow">

          <table class="table table-bordered" id='table-absen_ptsp'>
            <thead>
              <tr>
                <th class="text-center ">
                  No
                </th>

                <th class="text-center ">
                  Tanggal laporan
                </th>
                <th class="text-center ">
                  File
                </th>
                <th class="text-center ">
                  Aksi
                </th>
              </tr>

            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>

</div>
<div id="modal"></div>
<script>
  $(document).ready(function() {
    let table;

    function table_absen_ptsp(jenis_laporan) {
      table = $('#table-absen_ptsp').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          "url": `<?= base_url('absen_ptsp/data_absen_ptsp_datatable/' . $level); ?>/${jenis_laporan}`,
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
    table_absen_ptsp('pagi');

    $('.button_jenis_absen_ptsp').click(function(e) {
      e.preventDefault();
      let jenis = $(this).data('jenis');
      table.destroy()
      table_absen_ptsp(jenis);

    })

    $('.tambah-btn').click(function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= base_url('absen_ptsp/modal_laporan/' . $level); ?>",

        dataType: "json",
        success: function(response) {
          $('#modal').html(response);
          $('#modal_laporan').modal('show');
        }
      });
    })
    $('#table-absen_ptsp').on('click', '.edit-btn', function(e) {
      e.preventDefault();
      let id = $(this).data('id');
      $.ajax({
        type: "post",
        url: "<?= base_url('absen_ptsp/modal_laporan/' . $level); ?>",
        data: {
          id
        },
        dataType: "json",
        success: function(response) {
          console.log(response)
          $('#modal').html(response);
          $('#modal_laporan').modal('show');
        }
      });
    })

    $('#table-absen_ptsp').on('click', '.hapus-btn', function(e) {

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
            url: "<?= base_url('absen_ptsp/hapus_laporan'); ?>",
            data: {
              id
            },
            dataType: "json",
            success: function(response) {

              $(location).attr('href', `<?= base_url('absen_ptsp/data_laporan/' . $level); ?>`);
            }
          });
        }
      })


    })


  });
</script>

<?= $this->endSection(); ?>