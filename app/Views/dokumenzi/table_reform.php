<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<style>
  td {
    vertical-align: top;
    text-align: left;
    padding: 0.5rem;
  }
</style>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-1 align-items-center p-0">
            <h4 class="my-auto card-title">Dokumen Reform ZI</h4>
          </div>
          <div class="col-md-2">
            <select name="tahun" id="" class="form-select">

              <?php foreach ($tahuns as $tahun) : ?>
                <option><?= $tahun; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row">

          <div class="bg-white p-2 rounded-3 shadow">

            <table class="table-bordered" width="100%">

              <tbody>
                <?php $areacolspan = 0; ?>
                <?php foreach ($data as $key => $value) : ?>
                  <tr>
                    <td style="width: 5%;" rowspan="<?= $areacolspan; ?>">
                      <strong><?= $key; ?></strong>
                    </td>
                    <td colspan="3"><strong><?= $area_zi[$key]; ?></strong></td>

                  </tr>
                  <?php foreach ($value as $key2 => $value2) : ?>
                    <tr>

                      <td rowspan="<?= count($value2) + 1; ?>" style="width: 5%;">
                        <strong><?= $key2; ?></strong>
                      </td>
                      <td colspan="2"><strong><?= $sub_reform[$key2]; ?></strong></td>
                    </tr>
                    <?php foreach ($value2 as $key3 => $value3) : ?>
                      <tr>


                        <td style="word-wrap: break-word;">
                          <?= $value3['sub_sub_area']; ?>. <?= $value3['uraian']; ?>
                        </td>
                        <td style="width: 10%;">
                          <a href="" class="btn btn-primary upload-btn" data-kode="<?= $value3['kode']; ?>"><span class="mdi mdi-arrow-up-bold"></span></a> <a href="" class="btn btn-success file-btn" data-kode="<?= $value3['kode']; ?>"><span class="mdi mdi-file-check"></span></span></a>
                        </td>
                      </tr>
                      <?php $areacolspan++; ?>
                    <?php endforeach; ?>
                    </tr>
                    <?php $areacolspan++; ?>
                  <?php endforeach; ?>
                  <?php $areacolspan++; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>
<div id="modal"></div>
<script>
  $(document).ready(function() {
    $('.upload-btn').click(function(e) {
      e.preventDefault();
      let kode = $(this).data('kode');
      $.ajax({
        type: "post",
        url: "<?= base_url('dokumenzi/modal_upload_reform/' . $area); ?>",
        data: {
          kode
        },
        dataType: "json",
        success: function(response) {
          $('#modal').html(response);
          $('#modal_upload').modal('show');
        }
      });
    })

    $('.file-btn').click(function(e) {
      e.preventDefault();
      let tahun = $('select[name="tahun"]').val();

      let kode = $(this).data('kode');
      $.ajax({
        type: "post",
        url: "<?= base_url('dokumenzi/modal_file_reform/' . $area); ?>",
        data: {
          kode,
          tahun
        },
        dataType: "json",
        success: function(response) {
          $('#modal').html(response);
          $('#modal_file').modal('show');
        }
      });
    })
  });
</script>

<?= $this->endSection(); ?>