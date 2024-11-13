<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register Amora</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?= base_url('template-assets'); ?>/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?= base_url('template-assets'); ?>/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?= base_url('template-assets'); ?>/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="<?= base_url('template-assets'); ?>/css/style2.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?= base_url('template-assets'); ?>/images/favicon.png" />
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row flex-grow">
          <div class="col-lg-4 mx-auto">
            <div class="row mb-2">
              <div class="col text-center">
                <img src="<?= base_url('img/logo negara.png'); ?>" alt="" class="img-fluid" width="100rem">
              </div>
            </div>
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo  text-center">
                <span class="navbar-brand text-dark h1"><i class="mdi mdi-math-compass"></i>MORA</span>
                <br>
                <h2 class="text-dark">(Aplikasi Monitoring Kinerja)</h2>
              </div>

              <form class="pt-3" action="<?= base_url('auth/attempt_register'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" name="nama" class="form-control" placeholder="Masukkan nama ">
                </div>
                <div class="form-group">
                  <label for="level">Level</label>
                  <select name="level" class="form-control">
                    <option selected disabled>Pilih level</option>
                    <?php foreach ($bagian as $b) : ?>
                      <?php if ($b['nama_bagian'] == 'ADMINISTRATOR') : ?>
                        <?php continue; ?>
                      <?php else : ?>
                        <option value="<?= $b['id']; ?>"><?= $b['nama_bagian']; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>

                  </select>
                </div>
                <div class="form-group">
                  <label for="username">Username</label>
                  <input type="text" name="username" class="form-control" placeholder="Masukkan username">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Masukkan password" value="">
                </div>
                <div class="form-group">
                  <label for="password">Konfirmasi Password</label>
                  <input type="password" name="password2" class="form-control" placeholder="Konfirmasi password" value="">
                </div>

                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SUBMIT</button>
                <a href="<?= base_url('auth'); ?>">Sign in</a>
            </div>

            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?= base_url('template-assets'); ?>/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?= base_url('template-assets'); ?>/js/off-canvas.js"></script>
  <script src="<?= base_url('template-assets'); ?>/js/hoverable-collapse.js"></script>
  <script src="<?= base_url('template-assets'); ?>/js/misc.js"></script>
  <!-- endinject -->
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })


    <?php if (session()->has('fail')) : ?>
      Toast.fire({
        icon: 'error',
        title: '<?= session()->getFlashdata('fail'); ?>'
      })
    <?php endif; ?>
    <?php if (session()->has('success')) : ?>
      Toast.fire({
        icon: 'success',
        title: '<?= session()->getFlashdata('success'); ?>'
      })
    <?php endif; ?>
  </script>
</body>

</html>