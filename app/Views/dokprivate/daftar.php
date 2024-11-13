<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <div class="row mb-2">
    <div class="col">
      <span class="h3">

        Dokumen <?= $user->nama; ?>
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <a href="" class="btn btn-primary tambah-btn">Tambah Dokumen</a>
    </div>
  </div>


  <div class="table-responsive bg-white p-2 rounded-3 shadow mt-2">

    <table class="table table-bordered" id='table-data'>
      <thead>
        <tr>
          <th class="text-center ">
            No
          </th>

          <th class="text-center ">
            Nama File
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
<div id="modal"></div>
<script>
  $(document).ready(function() {
    let table;

    function table_datatable() {
      table = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          "url": `<?= base_url('dokprivate/data_datatable/' . $user->username); ?>`,
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
    table_datatable();


    $('.tambah-btn').click(function(e) {
      e.preventDefault();
      $.ajax({
        type: "get",
        url: "<?= base_url('dokprivate/modal_tambah/' . $user->username); ?>",

        dataType: "json",
        success: function(response) {
          $('#modal').html(response);
          $('#modal_tambah').modal('show');
        }
      });
    })
    $('#table-data').on('click', '.edit-btn', function(e) {
      e.preventDefault();
      let id = $(this).data('id');
      $.ajax({
        type: "post",
        url: "<?= base_url('dokprivate/modal_tambah/' . $user->username); ?>",
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
    })

    $('#table-data').on('click', '.hapus-btn', function(e) {

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
            url: "<?= base_url('dokprivate/hapus'); ?>",
            data: {
              id
            },
            dataType: "json",
            success: function(response) {

              $(location).attr('href', `<?= base_url('dokprivate/daftar/' . $user->username); ?>`);
            }
          });
        }
      })


    })


  });
</script>

<?= $this->endSection(); ?>