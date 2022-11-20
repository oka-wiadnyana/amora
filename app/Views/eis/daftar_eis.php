<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0 isi-pane">
          <div class="col p-0">
            <h4 class="my-auto card-title">EIS</h4>
          </div>
          <div class="row">
            <div class="col d-flex">
              <select name="bulan-cari" id="" class="form-control mr-2">
                <option value="" selected disabled>Pilih bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">Nopember</option>
                <option value="12">Desember</option>
              </select>
              <select name="tahun-cari" id="" class="form-control mr-2">
                <option value="" selected disabled>Pilih tahun</option>
                <?php foreach ($tahun as $t) : ?>

                  <option value="<?= $t; ?>"><?= $t; ?></option>
                <?php endforeach; ?>

              </select>
              <button class="btn btn-success btn-cari disabled">Cari</button>
            </div>

          </div>



        </div>
        <!-- Nav tabs -->
        <div class="tab-eis">
          <div class="spinner-eis h1"></div>
        </div>


      </div>
    </div>
  </div>
</div>
<div id="modal"></div>
<script>
  $(document).ready(function() {
    let bulan = new Date().getMonth() + 1;
    let tahun = new Date().getFullYear();

    console.log(bulan);

    let getDataEis = (bulan, tahun) => {
      $('.tab-eis').html("")
      $('.tab-eis').append(' <div class="spinner-eis h1"></div>')
      $.ajax({
        type: "post",
        url: "<?= base_url('eis/daftar_eis_ajax'); ?>",
        data: {
          bulan,
          tahun
        },
        beforeSend: function() {
          $('.spinner-eis').html("<i class='fa fa-spin fa-spinner'></i>")

        },
        dataType: "json",
        success: function(response) {
          console.log(response);
          $('.tab-eis').html(response)

        }
      });
    }

    getDataEis(bulan, tahun);

    $('.btn-cari').click(function(e) {
      e.preventDefault();
      let bulanCari = $('[name="bulan-cari"]').val();
      let tahunCari = $('[name="tahun-cari"]').val();
      getDataEis(bulanCari, tahunCari);
    })

  });

  $('[name="tahun-cari"]').change(function() {
    let val_bulan = $('[name="bulan-cari"]').val();
    let val_tahun = $(this).val();
    if (val_bulan && val_tahun) {
      $('.btn-cari').removeClass('disabled');
    }
  })
</script>

<?= $this->endSection(); ?>