<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <div class="row mb-2">
    <div class="col">
      <span class="h3">

        DAFTAR APLIKASI
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <a href="" class="btn btn-primary tambah-btn">Tambah Dokumen</a>

    </div>
  </div>


  <div class="table-responsive bg-white p-2 rounded-3 shadow" style="overflow: auto;">
    <table class="table table-bordered" id="table-aplikasi" style="table-layout: auto; width: 100%;">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Aplikasi</th>
                <th class="text-center">File Manual</th>
                <th class="text-center text-wrap" >Penjelasan</th>
                <th class="text-center text-wrap" >Latar Belakang</th>
                <th class="text-center">Dampak Langsung</th>
                <th class="text-center">Link</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Isi tabel -->
        </tbody>
    </table>
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
        "autoWidth": false,
        
        "ajax": {
          "url": `<?= base_url('aplikasi/data_aplikasi_datatable'); ?>`,
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
          {
            targets: [3, 4,5], // Index kolom untuk Penjelasan & Latar Belakang
            render: function (data, type, row) {
                return `<div style="white-space: normal;">${data}</div>`;
            },
        },


        ],
        rowReorder: {
          selector: 'td:nth-child(1)'
        },
        responsive: true

      })

    }
    table_aplikasi();

    $('.tambah-btn').click(function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= base_url('aplikasi/modal_tambah_aplikasi'); ?>",

        dataType: "json",
        success: function(response) {
          console.log(response)
          $('#modal').html(response);
          $('#modal_tambah').modal('show');
        }
      });

    });

    $('#table-aplikasi').on('click', '.upload-btn', function(e) {
      e.preventDefault();
      let id_perkara = $(this).data('id');
      $.ajax({
        type: "post",
        url: "<?= base_url('putusanpidana/modal_upload'); ?>",
        data: {
          id_perkara
        },
        dataType: "json",
        success: function(response) {
          console.log(response)
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
        url: "<?= base_url('aplikasi/modal_tambah_aplikasi'); ?>",
        data: {
          id
        },
        dataType: "json",
        success: function(response) {
          console.log(response)
          $('#modal').html(response);
          $('#modal_tambah').modal('show');
        }
      });
    });

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
            url: "<?= base_url('aplikasi/hapus_aplikasi'); ?>",
            data: {
              id
            },
            dataType: "json",
            success: function(response) {

              $(location).attr('href', `<?= base_url('aplikasi'); ?>`);
            }
          });
        }
      })


    })


  });
</script>

<?= $this->endSection(); ?>