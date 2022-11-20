<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="<?= base_url(''); ?>/assets/jquery.js" crossorigin="anonymous"></script>

  <title>Checklist apm</title>
</head>

<body>
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0">
          <h4 class="m-0">Ceklist APM</h4>
          <h4 class="m-0 p-0">Pengadilan Negeri Negara</h4>
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
              <?php foreach ($data_apm as $d) : ?>
                <tr>

                  <td><?= $d['nomor']; ?></td>
                  <td class="text-wrap"><?= $d['area']; ?></td>
                  <td class="text-wrap"><?= $d['penilaian']; ?></td>
                  <td class="text-wrap"><?= $d['uraian']; ?></td>
                  <td><?= $d['area_zi']; ?></td>
                  <td><?= $d['bobot']; ?></td>
                  <td><a href="" class="btn btn-primary btn-link text-white" data-nomor="<?= $d['nomor']; ?>">Link</a>
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
                <td><a href="" class="btn btn-primary btn-link" data-nomor="${element.nomor}">Link</a> <a href="" class="btn btn-info btn-tambah" data-id="${element.id}">Tambah</a></td>
              </tr>
    `
              )
            });

          }
        });
      }

      // getDataApm(area_local_storage);
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

        let semester = "<?= $semester; ?>";
        let tahun = "<?= $tahun; ?>";
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
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>