<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex col-md-6 align-items-center mb-3">
          <div class="col-md-4 align-items-center">
            <h4 class="my-auto card-title">Ceklist APM</h4>
          </div>
          <select name="semester" id="cari-semester" id="" class="form-control mr-2">

            <option selected disabled>Pilih semester</option>
            <option value="I">I</option>
            <option value="II">II</option>

          </select>
          <select name="tahun" id="cari-tahun" class="form-control">
            <option selected disabled>Pilih tahun</option>
            <?php
            $tahun = date('Y');
            for ($i = 0; $i < 5; $i++) : ?>
              <option value="<?= $tahun - $i; ?>"><?= $tahun - $i; ?></option>
            <?php endfor; ?>
          </select>

        </div>

        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link area-btn" href="#" data-area="ketua">Ketua</a>
          </li>
          <li class="nav-item">
            <a class="nav-link area-btn" href="#" data-area="wakil">Wakil Ketua/MR</a>
          </li>
          <li class="nav-item">
            <a class="nav-link area-btn" href="#" data-area="hakim">Hakim</a>

          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="koordinator area">Koordinator Area</a>
          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="panitera">Panitera</a>
          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="sekretaris">Sekretaris</a>
          </li>

        </ul>

        <ul class="nav nav-tabs mt-2">

          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="panmud pidana">Panmud Pidana</a>
          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="panmud perdata">Panmud Perdata</a>
          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="panmud hukum">Panmud Hukum</a>
          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="panitera pengganti">PP</a>

          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="KEPEGAWAIAN, ORGANISASI DAN TATA LAKSANA">Ortala</a>
          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="UMUM DAN KEUANGAN">UK</a>
          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="PERENCANAAN, TI DAN PELAPORAN">PTIP</a>
          </li>
          <li class="nav-item">

            <a class="nav-link area-btn" href="#" data-area="jurusita/jurusita pengganti">JS</a>
          </li>
        </ul>
        <div class="row my-2">
          <div class="col">
            <a href="" class="btn btn-danger btn-preview">Preview</a>
          </div>
        </div>
        <div class="table-responsive pt-2">
          <table class="table table-bordered mt-2 pt-2">
            <thead>
              <tr>
                <th style="border-top: 1px solid grey;"> Nomor </th>
                <th style="border-top: 1px solid grey;"> Area </th>
                <th style="border-top: 1px solid grey;"> Penilaian </th>
                <th style="border-top: 1px solid grey;"> Uraian </th>
                <th style="border-top: 1px solid grey;"> Area ZI </th>
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
      let area_local_storage = window.sessionStorage.getItem('area') || 'ketua';
      console.log(area_local_storage);
      let getDataApm = (area = null) => {
        $.ajax({
          type: "post",
          url: "<?= base_url('akreditasi/getDataApm'); ?>",
          data: {
            area,

          },
          dataType: "json",
          success: function(response) {
            $('.tbody-akreditasi').html("");
            response.forEach(element => {

              $('.tbody-akreditasi').append(
                `
    <tr>
                <td>${element.nomor}</td>
                <td class="text-wrap">${element.area}</td>
                <td class="text-wrap">${element.penilaian}</td>
                <td class="text-wrap">${element.uraian}</td>
                <td>${element.area_zi}</td>
                <td>${element.bobot}</td>
                <td><a href="" class="btn btn-primary btn-link" data-nomor="${element.nomor}">Link</a> <a href="" class="btn btn-info btn-tambah " data-id="${element.id}">Tambah</a></td>
              </tr>
    `
              )
            });

          }
        });
      }

      getDataApm(area_local_storage);
      $('.area-btn').each(function() {
        $(this).on('click', function(e) {
          e.preventDefault();

          $(this).parent().siblings().find('.nav-link').removeClass('active');
          $(this).parent().parent().siblings().find('.nav-link').removeClass('active');

          $(this).addClass('active');
          let area = $(this).data('area');
          window.sessionStorage.setItem('area', area);
          getDataApm(area);
        })
      })


      $('.tbody-akreditasi').on('click', '.btn-tambah', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
          type: "post",
          url: "<?= base_url('akreditasi/modal_upload_doc'); ?>",
          data: {
            id
          },
          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_upload_doc').modal('show');
          }
        });
      })

      $('.tbody-akreditasi').on('click', '.btn-link', function(e) {
        e.preventDefault();
        let nomor = $(this).data('nomor');
        let data_semester = "";
        if (new Date().getMonth() >= 1 && new Date().getMonth() <= 6) {
          data_semester = 'I';
        } else {
          data_semester = 'II';
        }
        let semester = window.sessionStorage.getItem('semester') || data_semester;
        let tahun = window.sessionStorage.getItem('tahun') || new Date().getFullYear();
        $.ajax({
          type: "post",
          url: "<?= base_url('akreditasi/modal_link'); ?>",
          data: {
            nomor,
            semester,
            tahun
          },
          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_link').modal('show');
          }
        });
      })

      $('#cari-semester').on('change', function() {
        semester = $(this).val();
        window.sessionStorage.setItem('semester', semester);
      })

      $('#cari-tahun').on('change', function() {
        tahun = $(this).val();
        window.sessionStorage.setItem('tahun', tahun);
      })

      $('.btn-preview').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: "get",
          url: "<?= base_url('akreditasi/modal_preview'); ?>",

          dataType: "json",
          success: function(response) {
            $('#modal').html(response);
            $('#modal_preview').modal('show');
          }
        });
      })
    });
  </script>

  <?= $this->endSection(); ?>