<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <div class="row mb-2">
    <div class="col">
      <span class="h3">

        DAFTAR PERKARA PIDANA
      </span>
    </div>
  </div>



  <div class="table-responsive bg-white p-2 rounded-3 shadow">

    <table class="table table-bordered" id='table-dokumen'>
      <thead>
        <tr>
          <th class="text-center ">
            No
          </th>
          <th class="text-center ">
            Nomor perkara
          </th>
          <th class="text-center ">
            Tanggal putusan
          </th>
          <th class="text-center ">
            Dokumen
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
<div id="modal"></div>
<script>
  $(document).ready(function() {
    let table;

    function table_dokumen() {
      table = $('#table-dokumen').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          "url": `<?= base_url('putusanpidana/data_dokumen_datatable'); ?>`,
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
    table_dokumen();


    $('#table-dokumen').on('click', '.upload-btn', function(e) {
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

    $('#table-dokumen').on('click', '.delete-btn', function(e) {

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
            url: "<?= base_url('putusanpidana/hapus_putusan'); ?>",
            data: {
              id
            },
            dataType: "json",
            success: function(response) {

              $(location).attr('href', `<?= base_url('putusanpidana/daftar_dokumen'); ?>`);
            }
          });
        }
      })


    })


  });
</script>

<?= $this->endSection(); ?>