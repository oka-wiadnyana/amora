<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <button class="nav-link active" id="nav-biasa-tab" data-toggle="tab" data-target="#nav-biasa" type="button" role="tab" aria-controls="nav-biasa" aria-selected="true">Biasa</button>
      <button class="nav-link" id="nav-cepat-tab" data-toggle="tab" data-target="#nav-cepat" type="button" role="tab" aria-controls="nav-cepat" aria-selected="false">Cepat</button>
    </div>
  </nav>
  <div class="tab-content bg-white" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-biasa" role="tabpanel" aria-labelledby="nav-biasa-tab">
      <div class="row mb-2">
        <div class="row mb-2 px-1 mx-auto">
          <div class="col d-flex flex-column bg-danger shadow text-white  rounded-3 py-1">
            <div class="col">
              Majelis I
            </div>
            <div class="col">
              <span>Ni Kadek Kusuma Wardani, S.H., M.H.</span>
              <span>Satriyo Murtitomo, SH</span>
              <span>Wajihatut Dzikriyah, S.H.</span>
            </div>
          </div>
        </div>
        <div class="table-responsive bg-white p-2 rounded-3 shadow">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center ">
                  Nama
                </th>
                <th class="text-center ">
                  Biasa Aktif
                </th>
                <th colspan="5" class="text-center">Nomor Perkara</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $key => $value) : ?>
                <?php if (($value['panitera_id'] == 21 || $value['panitera_id'] == 36 || $value['panitera_id'] == 33 || $value['panitera_id'] == 35)) : ?>
                  <tr>
                    <td>
                      <span style="color: black;"><?= $key; ?></span>
                    </td>

                    <td>
                      <?= $value['jml_pidana_mh1']; ?>
                    </td>
                    <?php foreach ($value['pidana'] as $v) : ?>
                      <?php if ($v['majelis_hakim_id'] == '33,27,30') : ?>
                        <td>
                          <?= $v['nomor_perkara']; ?>
                        </td>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </tr>
                <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row mb-2 mt-2">
        <div class="row mb-2 px-1 mx-auto">
          <div class="col d-flex flex-column bg-danger shadow text-white  rounded-3 py-1">
            <div class="col">
              Majelis II
            </div>
            <div class="col">
              <span>Ni Gusti Made Utami, S.H., M.H.</span>
              <span>Gde Putu Yoga Oka Bharata, SH</span>
              <span>Nanda Riwanto, S.H.</span>
            </div>
          </div>
        </div>
        <div class="table-responsive bg-white p-2 rounded-3 shadow">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center ">
                  Nama
                </th>
                <th class="text-center ">
                  Biasa Aktif
                </th>
                <th colspan="5" class="text-center">Nomor Perkara</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data as $key => $value) : ?>
                <?php if (($value['panitera_id'] == 31 || $value['panitera_id'] == 32 || $value['panitera_id'] == 34 || $value['panitera_id'] == 39 || $value['panitera_id'] == 37)) : ?>
                  <tr>
                    <td>
                      <span style="color: black;"><?= $key; ?></span>
                    </td>
                    <td>
                      <?= $value['jml_pidana_mh2']; ?>
                    </td>
                    <?php foreach ($value['pidana'] as $v) : ?>
                      <?php if ($v['majelis_hakim_id'] == '38,28,31') : ?>
                        <td>
                          <?= $v['nomor_perkara']; ?>
                        </td>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </tr>
                <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="row mb-2 mt-2">
        <div class="row mb-2 px-1 mx-auto">
          <div class="col d-flex flex-column bg-danger shadow text-white  rounded-3 py-1">
            <div class="col">
              Majelis III
            </div>
            <div class="col">
              <span>Gde Putu Yoga Oka Bharata, SH</span>
              <span>Satriyo Murtitomo, SH</span>
              <span>Wajihatut Dzikriyah, S.H.</span>
              <span>Nanda Riwanto, S.H.</span>
              <span>/Lainnya</span>
            </div>
          </div>
        </div>
        <div class="table-responsive bg-white p-2 rounded-3 shadow">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center ">
                  Nama
                </th>

                <th class="text-center ">
                  Biasa Aktif
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
                    <?= $value['jml_pidana_mh3']; ?>
                  </td>
                  <?php foreach ($value['pidana'] as $v) : ?>
                    <?php if ($v['majelis_hakim_id'] != '38,28,31' && $v['majelis_hakim_id'] != '33,27,30') : ?>
                      <td>
                        <?= $v['nomor_perkara']; ?>
                      </td>
                    <?php endif; ?>
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