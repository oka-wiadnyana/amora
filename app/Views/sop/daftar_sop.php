<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0">
          <div class="col p-0">
            <h4 class="my-auto card-title">Daftar SOP <?= $bagian['nama_bagian']; ?></h4>
          </div>

        </div>
        <div class="row mb-2">
          <div class="col">

            <a href="" class="btn btn-info tambah-sop">Tambah</a>
            <a href="" class="btn btn-success import-sop">Import dari excel</a>
          </div>

        </div>



        <table class="table table-bordered mt-2 pt-2" id="table-sk">
          <thead>
            <tr>
              <th style="border-top: 1px solid grey;"> Nomor </th>
              <th style="border-top: 1px solid grey;"> Nama SOP </th>
              <th style="border-top: 1px solid grey;"> Nomor SOP </th>
              <th style="border-top: 1px solid grey;"> Aksi </th>
            </tr>
          </thead>
          <tbody class="">
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
              <tr>


                <td><?= $no++; ?></td>
                <td><?= $d['nama_sop']; ?></td>
                <td><?= $d['nomor_sop']; ?></td>
                <td> <a href="" data-id="<?= $d['id_sop']; ?>" class="btn btn-info btn-ubah">Ubah</a> <a href="" data-id="<?= $d['id_sop']; ?>" class="btn btn-danger btn-hapus">Hapus</a> <?php if ($d['file_sop']) : ?><a href="<?= base_url('sop/download/' . $d['file_sop']); ?>" class="btn btn-success " target="_blank">Download</a><?php endif; ?>

                </td>
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
        let table = $('#table-sk').DataTable({
          // "processing": true,
          // "serverSide": true,
          "order": [],
          // "ajax": {
          //   "url": "<?= base_url('suratkeputusan/data_sk_datatable'); ?>",
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

      $('.tambah-sop').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('sop/modal_sop/' . $bagian['level']); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_sop').modal('show');
          }
        });
      })

      $('#table-sk').on('click', '.btn-ubah', function(e) {

        e.preventDefault();
        let id = $(this).data('id');
        console.log(id);
        $.ajax({
          type: "post",
          url: "<?= base_url('sop/modal_sop/' . $bagian['level']); ?>",
          data: {
            id
          },
          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_sop').modal('show');
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
              url: "<?= base_url('sop/hapus_sop'); ?>",
              data: {
                id
              },
              dataType: "json",
              success: function(response) {
                console.log(response);
                $(location).attr('href', `<?= base_url('sop/daftar_sop/' . $bagian['level']); ?>`);
              }
            });
          }
        })

      })

      $('.import-sop').click((e) => {
        e.preventDefault();
        fetch('<?= base_url('sop/modal_import/' . $bagian['level']) ?>').then((response) => {
          // console.log(response)

          return response.json();
        }).then((data) => {
          // console.log(data);
          $('#modal').html(data);
          $('#modal_import').modal('show');
        })
      })



    });
  </script>

  <?= $this->endSection(); ?>