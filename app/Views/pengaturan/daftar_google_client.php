<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="col-md-6 mb-3 p-0">
          <div class="col p-0">
            <h4 class="my-auto card-title">Daftar Google Client</h4>
          </div>

        </div>

        <form method="post" action="<?= base_url('pengaturan/insert_gc' . ($data ? '/ubah' : '')); ?>">
          <?= csrf_field(); ?>
          <fieldset <?= $data ? 'disabled=true' : ""; ?>>
            <div class="form-group">
              <label for="client_id">Client ID</label>
              <input type="text" class="form-control" name="client_id" value="<?= $data ? $data['client_id'] : ""; ?>">

            </div>
            <div class="form-group">
              <label for="client_secret">Client Secret</label>
              <input type="text" class="form-control" name="client_secret" value="<?= $data ? $data['client_secret'] : ""; ?>">

            </div>
          </fieldset>


          <button type="submit" id="btn-ubah" class="btn btn-warning btn-ubah">Ubah data</button>
          <button type="submit" id="btn-submit" class="btn btn-primary btn-submit">Submit</button>


        </form>

      </div>
    </div>
  </div>
  <div id="modal"></div>
  <script>
    $(document).ready(function() {
      <?php if ($data) : ?>
        $('.btn-submit').hide();
      <?php else : ?>
        $('.btn-ubah').hide();
      <?php endif; ?>
      $('.btn-ubah').click(function(e) {
        e.preventDefault();
        $('fieldset').prop('disabled', false);
        $('.btn-submit').show();
        $('.btn-ubah').hide();

      })



    });
  </script>

  <?= $this->endSection(); ?>