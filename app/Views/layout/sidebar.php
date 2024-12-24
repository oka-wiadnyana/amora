<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url(''); ?>">
                <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">Eksekusi</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#eks_putusan" aria-expanded="false" aria-controls="eks_putusan">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Eksekusi Putusan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="eks_putusan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('eksekusi/putusan_selesai'); ?>">Selesai</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('eksekusi/putusan_belum_selesai'); ?>">Belum selesai</a></li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#eks_ht" aria-expanded="false" aria-controls="eks_ht">
                <span class="icon-bg"><i class="mdi mdi-crosshairs-gps menu-icon"></i></span>
                <span class="menu-title">Eksekusi HT</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="eks_ht">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('eksekusi/ht_selesai'); ?>">Selesai</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('eksekusi/ht_belum_selesai'); ?>">Belum selesai</a></li>

                </ul>
            </div>
        </li>
        <!-- <li class="nav-item nav-category">Monev SIPP</li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('mis'); ?>">
                <span class="icon-bg"><i class="mdi mdi-ballot menu-icon"></i></span>
                <span class="menu-title">MIS</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('eis/daftar_eis'); ?>">
                <span class="icon-bg"><i class="mdi mdi-code-equal menu-icon"></i></span>
                <span class="menu-title">EIS</span>
            </a>
        </li> -->
        <li class="nav-item nav-category">Akreditasi</li>
        <li class="nav-item">
            <!-- <a class="nav-link" data-toggle="collapse" href="#apm" aria-expanded="false" aria-controls="apm">
                <span class="icon-bg"><i class="mdi mdi-contacts menu-icon"></i></span>
                <span class="menu-title">APM Cloud</span>
                <i class="menu-arrow"></i>
            </a> -->
            <!-- <div class="collapse" id="apm">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('akreditasi/index'); ?>">Checklist</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('akreditasi/daftar_assesment_internal'); ?>">Ass Internal</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('akreditasi/daftar_assesment_eksternal'); ?>">Ass Eksternal</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('akreditasi/import_checklist'); ?>">Import Checklist</a></li> -->
            <!-- <li class="nav-item"> <a class="nav-link" href="<?= base_url('eksekusi/putusan_belum_selesai'); ?>">Belum selesai</a></li> -->

            <!-- </ul>
            </div> -->
            <a class="nav-link" data-toggle="collapse" href="#apmlocal" aria-expanded="false" aria-controls="apmlocal">
                <span class="icon-bg"><i class="mdi mdi-contacts menu-icon"></i></span>
                <span class="menu-title">APM</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="apmlocal">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('akreditasilocal/index'); ?>">Checklist</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('akreditasilocal/daftar_assesment_internal'); ?>">Ass Internal</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('akreditasilocal/daftar_assesment_eksternal'); ?>">Ass Eksternal</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('akreditasilocal/import_checklist'); ?>">Import Checklist</a></li>
                    <!-- <li class="nav-item"> <a class="nav-link" href="<?= base_url('eksekusi/putusan_belum_selesai'); ?>">Belum selesai</a></li> -->

                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Pengawasan</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#hawasbid" aria-expanded="false" aria-controls="hawasbid">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Hawasbid</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="hawasbid">
                <ul class="nav flex-column sub-menu">
                    <?php foreach (session()->get('daftar_sub_unit') as $sub_unit) : ?>
                        <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('hawasbid/data_laporan/' . $sub_unit['level']); ?>"><?= $sub_unit['nama_bagian']; ?></a></li>
                    <?php endforeach; ?>
                    <!-- <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('hawasbid/data_laporan/ptsp') ?>">PTSP</a></li> -->

                </ul>
            </div>
            <a class="nav-link" data-toggle="collapse" href="#eksternal" aria-expanded="false" aria-controls="eksternal">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Eksternal</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="eksternal">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('pengadilantinggi/data_laporan/'); ?>">PT</a></li>

                </ul>
            </div>
            <div class="collapse" id="eksternal">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('bawas/data_laporan/'); ?>">Bawas</a></li>

                </ul>
            </div>
            <div class="collapse" id="eksternal">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('bpk/data_laporan/'); ?>">BPK</a></li>

                </ul>
            </div>
            <div class="collapse" id="eksternal">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('pengawasanlainnya/data_laporan/'); ?>">Lainnya</a></li>

                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">PTSP</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ptsp" aria-expanded="false" aria-controls="ptsp">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Monev</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ptsp">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('ptsp/data_laporan/perdata'); ?>">Perdata</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('ptsp/data_laporan/pidana'); ?>">Pidana</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('ptsp/data_laporan/hukum'); ?>">Hukum</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('ptsp/data_laporan/umum'); ?>">Umum</a></li>

                </ul>
            </div>
            <a class="nav-link" data-toggle="collapse" href="#briefing" aria-expanded="false" aria-controls="briefing">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Brief & Eval</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="briefing">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('briefing/data_laporan/perdata'); ?>">Perdata</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('briefing/data_laporan/pidana'); ?>">Pidana</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('briefing/data_laporan/hukum'); ?>">Hukum</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('briefing/data_laporan/umum'); ?>">Umum</a></li>

                </ul>
            </div>
            <a class="nav-link" data-toggle="collapse" href="#absen_ptsp" aria-expanded="false" aria-controls="absen_ptsp">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Absen</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="absen_ptsp">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('absen_ptsp/data_laporan/perdata'); ?>">Perdata</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('absen_ptsp/data_laporan/pidana'); ?>">Pidana</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('absen_ptsp/data_laporan/hukum'); ?>">Hukum</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('absen_ptsp/data_laporan/umum'); ?>">Umum</a></li>

                </ul>
            </div>
            <a class="nav-link" data-toggle="collapse" href="#standar_pelayanan" aria-expanded="false" aria-controls="standar_pelayanan">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Standar Pel.</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="standar_pelayanan">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('standar_pelayanan/daftar_standar_pelayanan/perdata'); ?>">Perdata</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('standar_pelayanan/daftar_standar_pelayanan/pidana'); ?>">Pidana</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('standar_pelayanan/daftar_standar_pelayanan/hukum'); ?>">Hukum</a></li>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('standar_pelayanan/daftar_standar_pelayanan/umum'); ?>">Umum</a></li>

                </ul>
            </div>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('ptsp/data_korwasbid'); ?>">
                <span class="icon-bg"><i class="mdi mdi-code-equal menu-icon"></i></span>
                <span class="menu-title">Korwasbid</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('ptsp/data_pengawas'); ?>">
                <span class="icon-bg"><i class="mdi mdi-code-equal menu-icon"></i></span>
                <span class="menu-title">Pengawas</span>
            </a>
        </li>

        </li>
        <li class="nav-item nav-category">Zona Integritas</li>
        <li class="nav-item">

            <a class="nav-link" data-toggle="collapse" href="#rencana_aksi" aria-expanded="false" aria-controls="rencana_aksi">
                <span class="icon-bg"><i class="mdi mdi-amplifier menu-icon"></i></span>
                <span class="menu-title">Rencana Aksi</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="rencana_aksi">
                <ul class="nav flex-column sub-menu">
                    <?php foreach (session()->get('area_zi') as $area_zi) : ?>
                        <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('rencana_aksi/data_monev/' . $area_zi['kode_area']); ?>"><?= $area_zi['nama_area']; ?></a></li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </li>
        <li class="nav-item">

            <a class="nav-link" data-toggle="collapse" href="#monev_zi" aria-expanded="false" aria-controls="monev_zi">
                <span class="icon-bg"><i class="mdi mdi-amplifier menu-icon"></i></span>
                <span class="menu-title">Monev ZI</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="monev_zi">
                <ul class="nav flex-column sub-menu">
                    <?php foreach (session()->get('area_zi') as $area_zi) : ?>
                        <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('monevzi/data_monev/' . $area_zi['kode_area']); ?>"><?= $area_zi['nama_area']; ?></a></li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#dokumen_zi" aria-expanded="false" aria-controls="dokumen_zi">
                <span class="icon-bg"><i class="mdi mdi-alpha-g-box menu-icon"></i></span>
                <span class="menu-title">Pemenuhan</span>
                <i class="menu-arrow"></i>
            </a>
            <!-- <div class="collapse" id="dokumen_zi">
                <ul class="nav flex-column sub-menu">
                    <?php foreach (session()->get('area_zi') as $area_zi) : ?>
                        <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('dokumenzi/data_dokumen/' . $area_zi['kode_area']); ?>"><?= $area_zi['nama_area']; ?></a></li>
                    <?php endforeach; ?>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('dokumenzi/data_dokumen'); ?>">Hasil</a></li>
                </ul>
            </div> -->
            <div class="collapse" id="dokumen_zi">
                <ul class="nav flex-column sub-menu">
                    <?php foreach (session()->get('area_zi') as $area_zi) : ?>
                        <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('dokumenzi/data_area/' . $area_zi['kode_area']); ?>"><?= $area_zi['nama_area']; ?></a></li>
                    <?php endforeach; ?>

                </ul>
            </div>

        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#reform_zi" aria-expanded="false" aria-controls="reform_zi">
                <span class="icon-bg"><i class="mdi mdi-alpha-g-box menu-icon"></i></span>
                <span class="menu-title">Reform</span>
                <i class="menu-arrow"></i>
            </a>
            <!-- <div class="collapse" id="reform_zi">
                <ul class="nav flex-column sub-menu">
                    <?php foreach (session()->get('area_zi') as $area_zi) : ?>
                        <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('dokumenzi/data_dokumen/' . $area_zi['kode_area']); ?>"><?= $area_zi['nama_area']; ?></a></li>
                    <?php endforeach; ?>
                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('dokumenzi/data_dokumen'); ?>">Hasil</a></li>
                </ul>
            </div> -->
            <div class="collapse" id="reform_zi">
                <ul class="nav flex-column sub-menu">
                    <?php foreach (session()->get('area_zi') as $area_zi) : ?>
                        <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('dokumenzi/data_reform/' . $area_zi['kode_area']); ?>"><?= $area_zi['nama_area']; ?></a></li>
                    <?php endforeach; ?>

                </ul>
            </div>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dokumenzi/data_dokumen'); ?>">
                <span class="icon-bg"><i class="mdi mdi-file-document-box menu-icon"></i></span>
                <span class="menu-title">Hasil</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('agenperubahan/daftar_dokumen'); ?>">
                <span class="icon-bg"><i class="mdi mdi-file-document-box menu-icon"></i></span>
                <span class="menu-title">Agen Perubahan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('ziarticle'); ?>">
                <span class="icon-bg"><i class="mdi mdi-file-document-box menu-icon"></i></span>
                <span class="menu-title">Article</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dokumenzi/import_file'); ?>">
                <span class="icon-bg"><i class="mdi mdi-file-document-box menu-icon"></i></span>
                <span class="menu-title">Import File</span>
            </a>
        </li>
        <li class="nav-item nav-category">Aplikasi</li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('aplikasi'); ?>">
                <span class="icon-bg mdi mdi-file-check text-success h5"></span></span>
                <span class="menu-title">Daftar Aplikasi</span>
            </a>
        </li>


        <li class="nav-item nav-category">Dokumen Lainnya</li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('putusanpidana/daftar_dokumen'); ?>">
                <span class="icon-bg mdi mdi-file-check text-success h5"></span></span>
                <span class="menu-title">Putusan Pidana</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('suratkeputusan/daftar_surat_keputusan'); ?>">
                <span class="icon-bg"><i class="mdi mdi-file-document-box menu-icon"></i></span>
                <span class="menu-title">SK</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sop" aria-expanded="false" aria-controls="sop">
                <span class="icon-bg"><i class="mdi mdi-briefcase-check menu-icon"></i></span>
                <span class="menu-title">SOP</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="sop">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/hakim'); ?>">Hakim</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/pp'); ?>">PP</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/js'); ?>">JS</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/pidana'); ?>">Pidana</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/perdata'); ?>">Perdata</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/hukum'); ?>">Hukum</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/umum'); ?>">U&K</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/ortala'); ?>">Ortala</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/ptip'); ?>">PTIP</a></li>
                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('sop/daftar_sop/mr'); ?>">MR</a></li>

                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dokumenrapat/daftar_dokumen'); ?>">
                <span class="icon-bg"><i class="mdi mdi-file-document-box menu-icon"></i></span>
                <span class="menu-title">Notulen Rapat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('video'); ?>">
                <span class=" icon-bg mdi mdi-video-check text-success h5"></span>
                <span class="menu-title">Video</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('audio'); ?>">
                <span class="icon-bg mdi mdi-music-box text-success h5"></span></span>
                <span class="menu-title">Audio</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('mou'); ?>">
                <span class="icon-bg mdi mdi-file-check text-success h5"></span></span>
                <span class="menu-title">MoU</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#hawasbid" aria-expanded="false" aria-controls="hawasbid">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Dokumen per ruang</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="hawasbid">
                <ul class="nav flex-column sub-menu">
                    <?php foreach (session()->get('daftar_sub_unit') as $sub_unit) : ?>
                        <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('doklainnya/daftar/' . $sub_unit['level']); ?>"><?= $sub_unit['nama_bagian']; ?></a></li>
                    <?php endforeach; ?>

                </ul>
            </div>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('dokprivate/daftar/' . session()->get('username')); ?>">
                <span class="icon-bg mdi mdi-file-check text-success h5"></span></span>
                <span class="menu-title">Doc Private</span>
            </a>
        </li>
        <!-- <li class="nav-item nav-category">SHANTI CARE</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#shanti_care" aria-expanded="false" aria-controls="shanti_care">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Shanti Care</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="shanti_care">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('shanti_care/keluhan'); ?>">Keluhan</a></li>

                </ul>
            </div>
            <div class="collapse" id="shanti_care">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('shanti_care/saran/2'); ?>">Saran Kebersihan</a></li>

                </ul>
            </div>
            <div class="collapse" id="shanti_care">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('shanti_care/saran/3'); ?>">Saran Pelayanan</a></li>

                </ul>
            </div>
        </li> -->

        <!-- <li class="nav-item nav-category">SP REVIEW</li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sp_review" aria-expanded="false" aria-controls="sp_review">
                <span class="icon-bg"><i class="mdi mdi-air-filter menu-icon"></i></span>
                <span class="menu-title">Review</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="sp_review">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('review/referensi'); ?>">Referensi</a></li>

                </ul>
            </div>
            <div class="collapse" id="sp_review">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"> <a class="nav-link" href="<?= base_url('review/list'); ?>">Hasil</a></li>

                </ul>
            </div>

        </li> -->
        <!-- <li class="nav-item nav-category">SBK</li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('sbk'); ?>">
                <span class="icon-bg mdi mdi-file-check text-success h5"></span></span>
                <span class="menu-title">Hasil SBK</span>
            </a>
        </li> -->
        <!-- <?php if (session()->get('level') == "administrator" || session()->get('level') == "ketua" || session()->get('level') == "wakil" || session()->get('level') == "panitera") : ?>
            <li class="nav-item nav-category">Pembagian Perkara</li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#panitera" aria-expanded="false" aria-controls="panitera">
                    <span class="icon-bg"><i class="mdi mdi-contacts menu-icon"></i></span>
                    <span class="menu-title">Panitera</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="panitera">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('panitera/daftar_pp_perdata'); ?>">PP Perdata</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('panitera/daftar_pp_pidana'); ?>">PP Pidana</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('panitera/daftar_js_perdata'); ?>">JS Perdata</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('panitera/daftar_js_pidana'); ?>">JS Pidana</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#hakim" aria-expanded="false" aria-controls="hakim">
                    <span class="icon-bg"><i class="mdi mdi-contacts menu-icon"></i></span>
                    <span class="menu-title">Hakim</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="hakim">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('hakim/daftar_hakim_perdata'); ?>">Hakim Perdata</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('hakim/daftar_hakim_pidana'); ?>">Hakim Pidana</a></li>

                    </ul>
                </div>
            </li>
        <?php endif; ?> -->
        <?php if (session()->get('level') == "administrator" || session()->get('level') == "ketua" || session()->get('level') == "wakil" || session()->get('level') == "sekretaris" || session()->get('level') == "panitera") : ?>
            <li class="nav-item nav-category">Admin</li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#setting" aria-expanded="false" aria-controls="setting">
                    <span class="icon-bg"><i class="mdi mdi-settings menu-icon"></i></span>
                    <span class="menu-title">Setting</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="setting">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('pengaturan/bagian'); ?>">Bagian</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('pengaturan/hakim'); ?>">Urutan hakim</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('pengaturan/daftar_akun'); ?>">Akun</a></li>
                        <!-- <li class="nav-item"> <a class="nav-link" href="<?= base_url('pengaturan/daftar_google_client'); ?>">Google Client</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('pengaturan/parent_folder'); ?>">Parent Folder</a></li>
                        <li class="nav-item"> <a class="nav-link" href="<?= base_url('pengaturan/redirect_uri'); ?>">Redirect URI</a></li> -->
                        <!-- <li class="nav-item"> <a class="nav-link" href="<?= base_url('eksekusi/putusan_belum_selesai'); ?>">Belum selesai</a></li> -->
                        <a class="nav-link" data-toggle="collapse" href="#ref_monev" aria-expanded="false" aria-controls="ref_monev">
                            <span class="icon-bg"><i class="mdi mdi-arrow-right menu-icon"></i></span>
                            <span class="menu-title">Ref Monev Bagian</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ref_monev">
                            <ul class="nav flex-column sub-menu">
                                <?php foreach (session()->get('daftar_sub_unit') as $sub_unit) : ?>
                                    <li class="nav-item"> <a class="nav-link text-wrap" href="<?= base_url('pengaturan/daftar_monev/' . $sub_unit['level']); ?>"><?= $sub_unit['nama_bagian']; ?></a></li>
                                <?php endforeach; ?>


                            </ul>
                        </div>
                    </ul>
                </div>

            </li>
        <?php endif; ?>


        <li class="nav-item sidebar-user-actions">
            <div class="sidebar-user-menu">
                <a href="<?= base_url('auth/logout'); ?>" class="nav-link"><i class="mdi mdi-logout menu-icon"></i>
                    <span class="menu-title">Log Out</span></a>
            </div>
        </li>
    </ul>
</nav>