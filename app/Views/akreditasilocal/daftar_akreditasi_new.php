<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">
  <style>
    table {
      table-layout: fixed;
    }

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

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex col-md-6 align-items-center mb-3">
          <div class="col-md-4 align-items-center">
            <h4 class="my-auto card-title">Ceklist APM</h4>
          </div>

          <!-- <select name="tahun" id="cari-tahun" class="form-control">
            <option selected disabled>Pilih tahun</option>
            <?php
            $tahun = date('Y');
            for ($i = 0; $i < 5; $i++) : ?>
              <option value="<?= $tahun - $i; ?>"><?= $tahun - $i; ?></option>
            <?php endfor; ?>
          </select> -->

        </div>


        <div class="table-responsive pt-2">
          <table class="table table-bordered mt-2 pt-2" id="table-dokumen">
            <thead>
              <tr>
                <th style="border-top: 1px solid grey;"> Nomor </th>

                <th style="border-top: 1px solid grey;"> Penilaian </th>
                <th style="border-top: 1px solid grey;"> Uraian </th>
                <th style="border-top: 1px solid grey;"> Kriteria </th>
                <th style="border-top: 1px solid grey;"> Lokasi assesmen </th>
                <th style="border-top: 1px solid grey;"> Bobot </th>
                <th style="border-top: 1px solid grey;"> Aksi </th>
              </tr>
            </thead>
            <tbody class="tbody-akreditasi">


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div id="modal"></div>
  <script>
    $(document).ready(function() {
      let table;

      function table_dokumen(jenis_dokumen) {
        table = $('#table-dokumen').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [],
          "ajax": {
            "url": `<?= base_url('akreditasilocal/data_akreditasi_datatable'); ?>`,
            "type": "POST"
          },
          "columnDefs": [{
              "target": 0,
              "orderable": false,
            },
            {
              "width": "2%",
              "targets": 0
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
      table_dokumen();




    });
  </script>

  <?= $this->endSection(); ?>