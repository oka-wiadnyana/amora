<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<style>
  /* table {
    table-layout: fixed;
  } */

  /* table td :not(#nomor) {
      word-wrap: break-word;
      max-width: 400px;
    }

    table td#nomor {
      max-width: 20px;
    } */

  #table-dokumen td {
    white-space: inherit;
  }
</style>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col">
            <a href="" class="btn btn-success btn-tambah">Tambah</a>
            <a href="<?= base_url('akreditasilocal/index'); ?>" class="btn btn-info">Kembali</a>
          </div>

        </div>

        <table class="table table-borderless">
          <tr>
            <td class="" style="width:5rem">Penilaian</td>
            <td style="width:1rem;">:</td>
            <td style="max-width:500px;  white-space:inherit"><?= $data_apm['penilaian']; ?></td>

          </tr>

        </table>

        <div class="row">

          <div class="col-4">

            <select name="tahun" id="cari-tahun" class="form-control">
              <option selected disabled>Pilih tahun</option>
              <?php
              $tahun = date('Y');
              for ($i = 0; $i < 5; $i++) : ?>
                <option value="<?= $tahun - $i; ?>"><?= $tahun - $i; ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>



        <ul class="nav nav-tabs mt-2">
          <?php for ($i = 1; $i <= $jumlah_sub; $i++) : ?>
            <li class="nav-item">
              <a class="nav-link sub-btn <?= $i; ?>" href="#" data-sub="<?= $i; ?>"><?= $i; ?></a>
            </li>
          <?php endfor; ?>

        </ul>



        <div class="pt-2">
          <table class="table table-bordered mt-2 pt-2" id="table-dokumen">
            <thead>
              <tr>

                <th style="border-top: 1px solid grey;"> No </th>
                <th style="border-top: 1px solid grey;"> Bulan </th>
                <th style="border-top: 1px solid grey;"> Tahun </th>
                <th style="border-top: 1px solid grey;"> Judul Dokumen </th>
                <th style="border-top: 1px solid grey;"> File </th>

                <th style="border-top: 1px solid grey;"> Aksi </th>
              </tr>
            </thead>
            <tbody>


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div id="modal"></div>
  <script>
    $(document).ready(function() {
      localStorage.clear();
      $('.sub-btn.1').addClass('active');
      let table;

      function table_dokumen(nomor, nomor_sub, tahun) {
        table = $('#table-dokumen').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "ajax": {
            "url": `<?= base_url('akreditasilocal/data_detail_datatable'); ?>/${nomor}/${nomor_sub}/${tahun}`,
            "type": "POST"
          },
          "columnDefs": [{
              "target": 0,
              "orderable": false,
            },
            {
              "width": "2%",
              "target": 0,
            },

            {
              responsivePriority: 1,
              targets: 0,

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

      let year = localStorage.getItem('tahun_apm') || new Date().getFullYear();

      $('[name="tahun"]').change(function() {
        let val = $(this).val();
        localStorage.setItem('tahun_apm', val);
        year = localStorage.getItem('tahun_apm');

      })


      table_dokumen('<?= $data_apm['nomor']; ?>', '1', year);

      $('.sub-btn').click(function(e) {
        e.preventDefault();
        let nomor_sub = $(this).data('sub');
        $('.sub-btn').removeClass('active');
        $(this).addClass('active');
        table.destroy();
        table_dokumen('<?= $data_apm['nomor']; ?>', nomor_sub, year);
      })


      $('.btn-tambah').click(function(e) {
        e.preventDefault();
        let nomor_apm = '<?= $data_apm['nomor']; ?>'
        $.ajax({
          type: "post",
          url: "<?= base_url('akreditasilocal/modal_tambah'); ?>",
          data: {
            nomor_apm
          },
          dataType: "json",
          success: function(response) {
            console.log(response)
            $('#modal').html(response);
            $('#modal_tambah').modal('show');
          }
        });
      })

      $('table').on('click', '.edit-btn', function(e) {
        e.preventDefault();
        console.log('ok')
        let nomor_apm = '<?= $data_apm['nomor']; ?>'
        let id = $(this).data('id');
        $.ajax({
          type: "post",
          url: "<?= base_url('akreditasilocal/modal_tambah'); ?>",
          data: {
            nomor_apm,
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

      $('table').on('click', '.hapus-btn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        console.log(id)
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
              url: "<?= base_url('akreditasilocal/hapus_dok_apm'); ?>",
              data: {
                id
              },
              dataType: "json",
              success: function(response) {
                console.log(response)
                $(location).attr('href', `<?= base_url('akreditasilocal/detail_apm/' . $data_apm['nomor']); ?>`);
              }
            });
          }
        })

      })
    });
  </script>

  <?= $this->endSection(); ?>