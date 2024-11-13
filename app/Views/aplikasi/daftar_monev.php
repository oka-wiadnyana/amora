<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <div class="row mb-2">
    <div class="col">
      <span class="h3">

        MONEV APLIKASI <?= ucwords($aplikasi['nama_aplikasi']); ?>
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <a href="" class="btn btn-primary tambah-btn">Tambah Dokumen</a>
      <a href="<?= base_url('aplikasi'); ?>" class="btn btn-warning">Kembali</a>
    </div>
  </div>

  <div class="row mb-2">

    <div class="table-responsive bg-white p-2 rounded-3 shadow">

      <table class="table table-bordered" id='table-aplikasi'>
        <thead>
          <tr>
            <th class="text-center ">
              No
            </th>
            <th class="text-center ">
              Bulan
            </th>
            <th class="text-center ">
              Tahun
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
<div id="modal"></div>
<script>
  $(document).ready(function() {
    let table;

    function table_aplikasi() {
      table = $('#table-aplikasi').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          "url": `<?= base_url('aplikasi/data_monev_aplikasi_datatable/' . $aplikasi['id']); ?>`,
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
    table_aplikasi();

    $('.button_jenis_aplikasi').click(function(e) {
      e.preventDefault();
      let jenis = $(this).data('jenis');
      table.destroy()
      table_aplikasi(jenis);

    })

    $('.tambah-btn').click(function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= base_url('aplikasi/modal_upload/' . $aplikasi['id']); ?>",

        dataType: "json",
        success: function(response) {
          $('#modal').html(response);
          $('#modal_upload').modal('show');
        }
      });
    })
    $('#table-aplikasi').on('click', '.edit-btn', function(e) {
      e.preventDefault();
      let id = $(this).data('id');
      $.ajax({
        type: "post",
        url: "<?= base_url('aplikasi/modal_upload/' . $aplikasi['id']); ?>",
        data: {
          id
        },
        dataType: "json",
        success: function(response) {
          console.log(response)
          $('#modal').html(response);
          $('#modal_upload').modal('show');
        }
      });
    })

    $('#table-aplikasi').on('click', '.hapus-btn', function(e) {

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
            url: "<?= base_url('aplikasi/hapus_laporan'); ?>",
            data: {
              id
            },
            dataType: "json",
            success: function(response) {

              location.reload();
            }
          });
        }
      })


    })


  });
</script>

<?= $this->endSection(); ?>