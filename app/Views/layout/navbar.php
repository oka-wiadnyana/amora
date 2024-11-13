<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center p-4">
        <!-- <a class="navbar-brand brand-logo" href="index.html"><img src="<?= base_url(); ?>/template-assets/images/logo.svg" alt="logo" /></a> -->
        <span class="navbar-brand text-white brand-logo"><i class="mdi mdi-math-compass"></i>MORA</span>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="<?= base_url(); ?>/template-assets/images/logo-mini.svg" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-xl-block">
            <form class="d-flex align-items-center h-100" action="#">

            </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="<?= base_url(); ?>/img/no-profil.png" alt="image">
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black"><?= session()->get('nama'); ?> (<?= session()->get('nama_bagian'); ?>)</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                    <div class="p-3 text-center bg-primary">
                        <img class="img-avatar img-avatar48 img-avatar-thumb" src="<?= base_url(); ?>/img/no-profil.png" alt="">
                    </div>
                    <div class="p-2">

                        <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="<?= base_url('auth/logout'); ?>">
                            <span>Log Out</span>
                            <i class="mdi mdi-logout ml-1"></i>
                        </a>
                    </div>
                </div>
            </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>