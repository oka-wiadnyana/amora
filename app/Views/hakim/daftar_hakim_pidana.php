<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <button class="nav-link active" id="nav-biasa-tab" data-toggle="tab" data-target="#nav-biasa" type="button" role="tab" aria-controls="nav-biasa" aria-selected="true">Biasa</button>
      <button class="nav-link" id="nav-cepat-tab" data-toggle="tab" data-target="#nav-cepat" type="button" role="tab" aria-controls="nav-cepat" aria-selected="false">Cepat</button>
      <button class="nav-link" id="nav-anak-tab" data-toggle="tab" data-target="#nav-anak" type="button" role="tab" aria-controls="nav-anak" aria-selected="false">Anak</button>
    </div>
  </nav>
  <div class="tab-content bg-white" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-biasa" role="tabpanel" aria-labelledby="nav-biasa-tab">
      <div class="row mb-2">

        <div class="table-responsive bg-white p-2 rounded-3 shadow">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center ">
                  Nama
                </th>
                <th class="text-center ">
                  Pidana Aktif
                </th>

                <th colspan="5" class="text-center">Nomor Perkara</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $key => $value) : ?>

                <tr>
                  <td>
                    <span style="color: black;"><?= $key; ?></span>
                  </td>

                  <td>
                    <?= $value['jml_perkara']; ?>
                  </td>
                  <?php foreach ($value['pidana'] as $v) : ?>

                    <td class="<?= ($v['jabatan_hakim_id'] == 1) ? 'bg-danger text-white' : ''; ?>">
                      <?= $v['nomor_perkara']; ?>
                    </td>

                  <?php endforeach; ?>
                </tr>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-cepat" role="tabpanel" aria-labelledby="nav-cepat-tab">
      <div class="row mb-2">

        <div class="table-responsive bg-white p-2 rounded-3 shadow">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center ">
                  Nama
                </th>
                <th class="text-center ">
                  Cepat Aktif
                </th>

                <th colspan="5" class="text-center">Nomor Perkara</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data_cepat as $key => $value) : ?>

                <tr>
                  <td>
                    <span style="color: black;"><?= $key; ?></span>
                  </td>

                  <td>
                    <?= $value['jml_cepat']; ?>
                  </td>
                  <?php foreach ($value['cepat'] as $v) : ?>

                    <td>
                      <?= $v['nomor_perkara']; ?>
                    </td>

                  <?php endforeach; ?>
                </tr>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <div class="tab-pane fade" id="nav-anak" role="tabpanel" aria-labelledby="nav-anak-tab">
      <div class="row mb-2">

        <div class="table-responsive bg-white p-2 rounded-3 shadow">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center ">
                  Nama
                </th>
                <th class="text-center ">
                  Anak Aktif
                </th>

                <th colspan="5" class="text-center">Nomor Perkara</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data_anak as $key => $value) : ?>

                <tr>
                  <td>
                    <span style="color: black;"><?= $key; ?></span>
                  </td>

                  <td>
                    <?= $value['jml_anak']; ?>
                  </td>
                  <?php foreach ($value['anak'] as $v) : ?>

                    <td>
                      <?= $v['nomor_perkara']; ?>
                    </td>

                  <?php endforeach; ?>
                </tr>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>

  </div>
  <div id="modal"></div>
  <script>
    $(document).ready(function() {
      function table_akun() {
        let table = $('#table-akun').DataTable({
          // "processing": true,
          // "serverSide": true,
          "order": [],
          // "ajax": {
          //   "url": "<?= base_url('eksekusi/data_eksekusi_belum_datatable'); ?>",
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
      table_akun();

      $('.tambah-akun').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('pengaturan/modal_akun'); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_akun').modal('show');
          }
        });
      })
      $('.btn-ubah').each(function(index, element) {
        $(this).click(function(e) {
          e.preventDefault();
          let id = $(this).data('id');
          console.log(id);
          $.ajax({
            type: "post",
            url: "<?= base_url('pengaturan/modal_akun'); ?>",
            data: {
              id
            },
            dataType: "json",
            success: function(response) {
              $('#modal').html(response);
              $('#modal_akun').modal('show');
            }
          });
        })
      })

      $('.btn-hapus').each(function(index, element) {
        $(this).click(function(e) {
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
                url: "<?= base_url('pengaturan/hapus_akun'); ?>",
                data: {
                  id
                },
                dataType: "json",
                success: function(response) {

                  $(location).attr('href', `<?= base_url('pengaturan/daftar_akun'); ?>`);
                }
              });
            }
          })

        })
      })


    });
  </script>

  <?= $this->endSection(); ?>