<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0">
          <div class="col p-0">
            <h4 class="my-auto card-title">Daftar standar pelayanan <?= $bagian; ?></h4>
          </div>

        </div>
        <div class="row mb-2">
          <div class="col">

            <a href="" class="btn btn-info tambah-standar_pelayanan">Tambah</a>

          </div>

        </div>



        <table class="table table-bordered mt-2 pt-2" id="table-sk">
          <thead>
            <tr>
              <th style="border-top: 1px solid grey;"> Nomor </th>
              <th style="border-top: 1px solid grey;"> Nama Standar Pelayanan </th>

              <th style="border-top: 1px solid grey;"> Aksi </th>
            </tr>
          </thead>
          <tbody class="">
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
              <tr>


                <td><?= $no++; ?></td>
                <td><?= $d['nama_standar_pelayanan']; ?></td>

                <td> <a href="" data-id="<?= $d['id_standar_pelayanan']; ?>" class="btn btn-info btn-ubah">Ubah</a> <a href="" data-id="<?= $d['id_standar_pelayanan']; ?>" class="btn btn-danger btn-hapus">Hapus</a> <?php if ($d['file_standar_pelayanan']) : ?><a href="<?= base_url('standar_pelayanan/download/' . $d['file_standar_pelayanan']); ?>" class="btn btn-success " target="_blank">Download</a><?php endif; ?>

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


      $('.tambah-standar_pelayanan').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('standar_pelayanan/modal_standar_pelayanan/' . $bagian); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_standar_pelayanan').modal('show');
          }
        });
      })

      $('#table-sk').on('click', '.btn-ubah', function(e) {

        e.preventDefault();
        let id = $(this).data('id');
        console.log(id);
        $.ajax({
          type: "post",
          url: "<?= base_url('standar_pelayanan/modal_standar_pelayanan/' . $bagian); ?>",
          data: {
            id
          },
          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_standar_pelayanan').modal('show');
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
              url: "<?= base_url('standar_pelayanan/hapus_standar_pelayanan'); ?>",
              data: {
                id
              },
              dataType: "json",
              success: function(response) {
                console.log(response);
                $(location).attr('href', `<?= base_url('standar_pelayanan/daftar_standar_pelayanan/' . $bagian); ?>`);
              }
            });
          }
        })

      })

      $('.import-standar_pelayanan').click((e) => {
        e.preventDefault();
        fetch('<?= base_url('standar_pelayanan/modal_import/' . $bagian) ?>').then((response) => {
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