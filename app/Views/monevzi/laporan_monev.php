<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <div class="row mb-2">
    <div class="col">
      <span class="h3">

        Monev <?= $data_area['kode_area'] . ' : ' . ucwords($data_area['nama_area']); ?>
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

      <button class="nav-link active button_jenis_monevzi" id="nav-monev-tab" data-toggle="tab" data-target="#nav-monev" type="button" role="tab" aria-controls="nav-monev" aria-selected="false" data-jenis='monev'>Monev</button>
      <button class="nav-link button_jenis_monevzi" id="nav-tindak_lanjut-tab" data-toggle="tab" data-target="#nav-tindak_lanjut" type="button" role="tab" aria-controls="nav-tindak_lanjut" aria-selected="false" data-jenis='tindak_lanjut'>TL</button>

    </div>
  </nav>
  <div class="tab-content bg-white" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-laporan" role="tabpanel" aria-labelledby="nav-laporan-tab">
      <div class="row mb-2">

        <div class="table-responsive bg-white p-2 rounded-3 shadow">

          <table class="table table-bordered" id='table-area'>
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
                  Tanggal dokumen
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

    function table_area(jenis_dokumen) {
      table = $('#table-area').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          "url": `<?= base_url('monevzi/data_monevzi_datatable/' . $data_area['kode_area']); ?>/${jenis_dokumen}`,
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
    table_area('monev');

    $('.button_jenis_monevzi').click(function(e) {
      e.preventDefault();
      let jenis = $(this).data('jenis');
      table.destroy()
      table_area(jenis);

    })

    $('.tambah-btn').click(function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= base_url('monevzi/modal_laporan/' . $data_area['kode_area']); ?>",

        dataType: "json",
        success: function(response) {
          $('#modal').html(response);
          $('#modal_laporan').modal('show');
        }
      });
    })
    $('#table-area').on('click', '.edit-btn', function(e) {
      e.preventDefault();
      let id = $(this).data('id');
      $.ajax({
        type: "post",
        url: "<?= base_url('monevzi/modal_laporan/' . $data_area['kode_area']); ?>",
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

    $('#table-area').on('click', '.hapus-btn', function(e) {

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
            url: "<?= base_url('monevzi/hapus_laporan'); ?>",
            data: {
              id
            },
            dataType: "json",
            success: function(response) {

              $(location).attr('href', `<?= base_url('monevzi/data_monev/' . $data_area['kode_area']); ?>`);
            }
          });
        }
      })


    })


  });
</script>

<?= $this->endSection(); ?>