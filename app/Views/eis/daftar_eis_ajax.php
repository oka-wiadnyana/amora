<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-kinerja-tab" data-toggle="tab" data-target="#nav-kinerja" type="button" role="tab" aria-controls="nav-kinerja" aria-selected="true">Kinerja</button>
        <button class="nav-link" id="nav-kepatuhan-tab" data-toggle="tab" data-target="#nav-kepatuhan" type="button" role="tab" aria-controls="nav-kepatuhan" aria-selected="false">Kepatuhan</button>
        <button class="nav-link" id="nav-kelengkapan-tab" data-toggle="tab" data-target="#nav-kelengkapan" type="button" role="tab" aria-controls="nav-kelengkapan" aria-selected="false">Kelengkapan</button>
        <button class="nav-link" id="nav-kesesuaian-tab" data-toggle="tab" data-target="#nav-kesesuaian" type="button" role="tab" aria-controls="nav-kesesuaian" aria-selected="false">Kesesuaian</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-kinerja" role="tabpanel" aria-labelledby="nav-kinerja-tab">
        <div class="accordion" id="">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0 d-flex" type="button" data-toggle="collapse" data-target="" aria-expanded="true" aria-controls="" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Jumlah Rasio Penanganan Perkara </span>
                            <span class="font-italic font-weight-light">Rekapitulasi Rasio Penanganan Perkara</span>
                        </div>
                        <div class="col-md-2 m-auto">

                            <span class="h5 font-weight-bold m-auto"><?= $data_kinerja['data_rasio']; ?>%</span>
                        </div>

                    </button>


                </div>


            </div>

        </div>
        <div class="accordion" id="pelaksanaan_delegasi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kinerja['pelaksanaan_delegasi'])) ? "#pelaksanaanDelegasi" : ""; ?>" aria-expanded="true" aria-controls="pelaksanaanDelegasi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span> Jangka Waktu Pelaksanaan Delegasi Masuk <span class="badge badge-danger"><?= (count($data_kinerja['pelaksanaan_delegasi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Waktu Pelaksanaan Delegasi Masuk, Maksimal 7 Hari Kerja</span>
                        </div>

                    </button>


                </div>

                <div id="pelaksanaanDelegasi" class="collapse" aria-labelledby="headingOne" data-parent="#pelaksanaan_delegasi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>PN Asal</th>
                                    <th>Tanggal delegasi</th>
                                    <th>Tanggal pelaksanaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kinerja['pelaksanaan_delegasi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['pn_asal_text']; ?></td>
                                        <td><?= $dpp['tanggal_delegasi']; ?></td>
                                        <td><?= $dpp['pelaksanaan_delegasi']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="tab-pane fade" id="nav-kepatuhan" role="tabpanel" aria-labelledby="nav-kepatuhan-tab">
        <div class="accordion" id="pendaftaran_perkara">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['pendaftaran_perkara'])) ? "#pendaftaranPerkara" : ""; ?>" aria-expanded="true" aria-controls="pendaftaranPerkara" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pendaftaran Perkara <span class="badge badge-danger"><?= (count($data_kepatuhan['pendaftaran_perkara'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan pendaftaran perkara dalam waktu 1x24 jam</span>
                        </div>

                    </button>


                </div>

                <div id="pendaftaranPerkara" class="collapse" aria-labelledby="headingOne" data-parent="#pendaftaran_perkara">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pendaftaran</th>
                                    <th>Tanggal input</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['pendaftaran_perkara'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_pendaftaran']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="barang_bukti">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['barang_bukti'])) ? "#barangBukti" : ""; ?>" aria-expanded="true" aria-controls="barangBukti" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pencatatan Barang Bukti <span class="badge badge-danger"><?= (count($data_kepatuhan['barang_bukti'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan Pengguna dalam mengisi Barang Bukti suatu perkara</span>
                        </div>

                    </button>


                </div>

                <div id="barangBukti" class="collapse" aria-labelledby="headingOne" data-parent="#pendaftaran_perkara">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pendaftaran</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['barang_bukti'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_pendaftaran']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="penetapan_majelis_hakim">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penetapan_majelis_hakim'])) ? "#penetapanMajelisHakim" : ""; ?>" aria-expanded="true" aria-controls="penetapanMajelisHakim" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span> Penetapan Hakim <span class="badge badge-danger"><?= (count($data_kepatuhan['penetapan_majelis_hakim'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan penetapan majelis/hakim dalam waktu maksimal 3 (tiga) hari</span>
                        </div>

                    </button>


                </div>

                <div id="penetapanMajelisHakim" class="collapse" aria-labelledby="headingOne" data-parent="#penetapan_majelis_hakim">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pendaftaran</th>
                                    <th>Tanggal penetapan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penetapan_majelis_hakim'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_pendaftaran']; ?></td>
                                        <td><?= $dpp['tanggal_penetapan']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penetapan_pp">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penetapan_pp'])) ? "#penetapanPP" : ""; ?>" aria-expanded="true" aria-controls="penetapanPP" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penetapan Panitera Pengganti <span class="badge badge-danger"><?= (count($data_kepatuhan['penetapan_pp'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan penetapan panitera pengganti dalam waktu maksimal 3 (tiga) hari</span>
                        </div>

                    </button>


                </div>

                <div id="penetapanPP" class="collapse" aria-labelledby="headingOne" data-parent="#penetapan_pp">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pendaftaran</th>
                                    <th>Tanggal penetapan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penetapan_pp'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_pendaftaran']; ?></td>
                                        <td><?= $dpp['tanggal_penetapan']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penetapan_js">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penetapan_js'])) ? "#penetapanJS" : ""; ?>" aria-expanded="true" aria-controls="penetapanJS" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penetapan Jurusita/Jurusita Pengganti <span class="badge badge-danger"><?= (count($data_kepatuhan['penetapan_js'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan penetapan jurusita dalam waktu maksimal 3 (tiga) hari </span>
                        </div>

                    </button>


                </div>

                <div id="penetapanJS" class="collapse" aria-labelledby="headingOne" data-parent="#penetapan_js">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pendaftaran</th>
                                    <th>Tanggal penetapan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penetapan_js'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_pendaftaran']; ?></td>
                                        <td><?= $dpp['tanggal_penetapan']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penetapan_hari_sidang">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penetapan_hari_sidang'])) ? "#penetapanHS" : ""; ?>" aria-expanded="true" aria-controls="penetapanHS" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penetapan Hari Sidang <span class="badge badge-danger"><?= (count($data_kepatuhan['penetapan_hari_sidang'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan penetapan majelis/hakim dalam waktu maksimal 3 (tiga) hari </span>
                        </div>

                    </button>


                </div>

                <div id="penetapanHS" class="collapse" aria-labelledby="headingOne" data-parent="#penetapan_hari_sidang">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pendaftaran</th>
                                    <th>Tanggal penetapan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penetapan_hari_sidang'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_pendaftaran']; ?></td>
                                        <td><?= $dpp['tanggal_penetapan']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="perkara_penuntutan">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['perkara_penuntutan'])) ? "#perkaraPenuntutan" : ""; ?>" aria-expanded="true" aria-controls="perkaraPenuntutan" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Tuntutan <span class="badge badge-danger"><?= (count($data_kepatuhan['perkara_penuntutan'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Ketepatan Waktu dalam input Tuntutan dalam suatu perkara </span>
                        </div>

                    </button>


                </div>

                <div id="perkaraPenuntutan" class="collapse" aria-labelledby="headingOne" data-parent="#perkara_penuntutan">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal penuntutan</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['perkara_penuntutan'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_penuntutan']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_putusan">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_putusan'])) ? "#penginputanPutusan" : ""; ?>" aria-expanded="true" aria-controls="penginputanPutusan" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Putusan Akhir <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_putusan'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Ketepatan Waktu dalam input Putusan dalam suatu perkara </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanPutusan" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_putusan">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal putusan</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_putusan'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_putusan']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_minutasi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_minutasi'])) ? "#penginputanMinutasi" : ""; ?>" aria-expanded="true" aria-controls="penginputanMinutasi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Minutasi <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_minutasi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan penginputan minutasi maksimal 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanMinutasi" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_minutasi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal minutasi</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_minutasi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_minutasi']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="ketepatan_minutasi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['ketepatan_minutasi'])) ? "#ketepatanMinutasi" : ""; ?>" aria-expanded="true" aria-controls="ketepatanMinutasi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Minutasi Perkara <span class="badge badge-danger"><?= (count($data_kepatuhan['ketepatan_minutasi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Ketepatan waktu dalam melakukan minutasi dalam waktu 7 Hari (Pidana) dan 14 Hari (Perdata) </span>
                        </div>

                    </button>


                </div>

                <div id="ketepatanMinutasi" class="collapse" aria-labelledby="headingOne" data-parent="#ketepatan_minutasi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal putusan</th>
                                    <th>Tanggal minutasi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['ketepatan_minutasi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_putusan']; ?></td>
                                        <td><?= $dpp['tanggal_minutasi']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_banding">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_banding'])) ? "#penginputanBanding" : ""; ?>" aria-expanded="true" aria-controls="penginputanBanding" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Permohonan Banding <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_banding'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input Permohonan Banding dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanBanding" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_banding">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal banding</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_banding'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara_pn']; ?></td>
                                        <td><?= $dpp['permohonan_banding']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_kasasi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_kasasi'])) ? "#penginputanKasasi" : ""; ?>" aria-expanded="true" aria-controls="penginputanKasasi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Permohonan Kasasi <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_kasasi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input Permohonan Kasasi dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanKasasi" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_kasasi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal kasasi</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_kasasi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara_pn']; ?></td>
                                        <td><?= $dpp['permohonan_kasasi']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_pk">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_pk'])) ? "#penginputanPK" : ""; ?>" aria-expanded="true" aria-controls="penginputanPK" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Permohonan Peninjauan Kembali <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_pk'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input Permohonan Peninjauan Kembali dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanPK" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_pk">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pk</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_pk'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara_pn']; ?></td>
                                        <td><?= $dpp['permohonan_pk']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="pengiriman_banding">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['pengiriman_banding'])) ? "#pengirimanBanding" : ""; ?>" aria-expanded="true" aria-controls="pengirimanBanding" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pengiriman Berkas Banding <span class="badge badge-danger"><?= (count($data_kepatuhan['pengiriman_banding'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam pengiriman berkas banding ke Pengadilan Tinggi dalam waktu maksimal 30 hari (PERDATA) atau 14 hari (PIDANA) </span>
                        </div>

                    </button>


                </div>

                <div id="pengirimanBanding" class="collapse" aria-labelledby="headingOne" data-parent="#pengiriman_banding">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal banding</th>
                                    <th>Tanggal pengiriman banding</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['pengiriman_banding'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['permohonan_banding']; ?></td>
                                        <td><?= $dpp['pengiriman_berkas_banding']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="pengiriman_kasasi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['pengiriman_kasasi'])) ? "#pengirimanKasasi" : ""; ?>" aria-expanded="true" aria-controls="pengirimanKasasi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pengiriman Berkas Kasasi <span class="badge badge-danger"><?= (count($data_kepatuhan['pengiriman_kasasi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam pengiriman berkas kasasi ke Mahkamah Agung dalam waktu maksimal 65 hari </span>
                        </div>

                    </button>


                </div>

                <div id="pengirimanKasasi" class="collapse" aria-labelledby="headingOne" data-parent="#pengiriman_kasasi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal kasasi</th>
                                    <th>Tanggal pengiriman kasasi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['pengiriman_kasasi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['permohonan_kasasi']; ?></td>
                                        <td><?= $dpp['pengiriman_berkas_kasasi']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="pengiriman_pk">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['pengiriman_pk'])) ? "#pengirimanPK" : ""; ?>" aria-expanded="true" aria-controls="pengirimanPK" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pengiriman Berkas Peninjauan Kembali <span class="badge badge-danger"><?= (count($data_kepatuhan['pengiriman_pk'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam pengiriman berkas peninjuan kembali ke Mahkamah Agung dalam waktu maksimal 30 hari setelah Pemeriksaan Persidangan (PIDANA) atau 30 hari setelah Jawaban/tanggapan atas alasan PK (PERDATA) </span>
                        </div>

                    </button>


                </div>

                <div id="pengirimanPK" class="collapse" aria-labelledby="headingOne" data-parent="#pengiriman_pk">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pk</th>
                                    <th>Tanggal pengiriman pk</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['pengiriman_pk'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['permohonan_pk']; ?></td>
                                        <td><?= $dpp['pengiriman_berkas_pk']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="pemberitahuan_putusan">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['pemberitahuan_putusan'])) ? "#pemberitahuanPutusan" : ""; ?>" aria-expanded="true" aria-controls="pemberitahuanPutusan" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pemberitahuan Putusan/Penentapan <span class="badge badge-danger"><?= (count($data_kepatuhan['pemberitahuan_putusan'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input tanggal pemberitahuan putusan dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="pemberitahuanPutusan" class="collapse" aria-labelledby="headingOne" data-parent="#pemberitahuan_putusan">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pemberitahuan putusan</th>
                                    <th>Tanggal Input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['pemberitahuan_putusan'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['pemberitahuan_putusan']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_hakim">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_hakim'])) ? "#penginputanHakim" : ""; ?>" aria-expanded="true" aria-controls="penginputanHakim" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Penetapan Majelis/Hakim <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_hakim'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input penetapan Majelis Hakim/Hakim dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanHakim" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_hakim">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal penetapan</th>
                                    <th>Tanggal Input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_hakim'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['penginputan_hakim']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_pp">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_pp'])) ? "#penginputanPP" : ""; ?>" aria-expanded="true" aria-controls="penginputanPP" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Penetapan Panitera Pengganti <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_pp'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input penunjukan Panitera Pengganti dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanPP" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_pp">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal penetapan</th>
                                    <th>Tanggal Input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_pp'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['penginputan_pp']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_hs">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_hs'])) ? "#penginputanHS" : ""; ?>" aria-expanded="true" aria-controls="penginputanHS" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Penetapan Hari Sidang <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_hs'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input penetapan hari sidang dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanHS" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_hs">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal penetapan</th>
                                    <th>Tanggal Input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_hs'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['penginputan_hs']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_js">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_js'])) ? "#penginputanJS" : ""; ?>" aria-expanded="true" aria-controls="penginputanJS" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Penetapan Jurusita/Jurusita Pengganti <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_js'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input penunjukan Jurusita/Jurusita Pengganti dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanJS" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_js">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal penetapan</th>
                                    <th>Tanggal Input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_js'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['penginputan_js']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_delegasi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_delegasi'])) ? "#penginputanDelegasi" : ""; ?>" aria-expanded="true" aria-controls="penginputanDelegasi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Data Pelaksanaan Delegasi <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_delegasi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan waktu dalam input Data Pelaksanaan Delegasi dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanDelegasi" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_delegasi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>PN Asal</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pelaksanaan</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_delegasi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['pn_asal_text']; ?></td>
                                        <td><?= $dpp['nomor_relaas']; ?></td>
                                        <td><?= $dpp['tgl_relaas_reverse']; ?></td>
                                        <td><?= $dpp['diinput_tanggal_reverse']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_jadwal_sidang">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_jadwal_sidang'])) ? "#penginputanJadwalSidang" : ""; ?>" aria-expanded="true" aria-controls="penginputanJadwalSidang" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Kepatuhan Penundaan Jadwal Sidang <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_jadwal_sidang'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan input penundaan jadwal sidang dalam waktu 1x24 jam </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanJadwalSidang" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_jadwal_sidang">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tgl Sidang</th>
                                    <th>Tgl Sidang Sebelumnya</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_jadwal_sidang'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_sidang']; ?></td>
                                        <td><?= $dpp['previous_sidang']; ?></td>
                                        <td><?= $dpp['input']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="penginputan_penahanan">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kepatuhan['penginputan_penahanan'])) ? "#penginputanPenahanan" : ""; ?>" aria-expanded="true" aria-controls="penginputanPenahanan" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penginputan Penetapan Perpanjangan Penahanan <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_penahanan'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kepatuhan penginputan perpanjangan penahanan maksimal 1x24 jam sejak tanggal penetapan </span>
                        </div>

                    </button>


                </div>

                <div id="penginputanPenahanan" class="collapse" aria-labelledby="headingOne" data-parent="#penginputan_penahanan">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tgl Penetapan</th>
                                    <th>Tanggal input</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kepatuhan['penginputan_penahanan'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_surat']; ?></td>
                                        <td><?= $dpp['diinput_tanggal']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        <div class="accordion" id="unggah_putusan_akhir">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="" aria-expanded="true" aria-controls="penginputanPenahanan" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Unggah Putusan Akhir <span class="badge badge-danger"><?= (count($data_kepatuhan['penginputan_penahanan'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">(On Progress) </span>
                        </div>

                    </button>


                </div>



            </div>

        </div>
    </div>

    <div class="tab-pane fade" id="nav-kelengkapan" role="tabpanel" aria-labelledby="nav-kelengkapan-tab">
        <div class="accordion" id="petitum_dakwaan">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kelengkapan['petitum_dakwaan'])) ? "#petitumDakwaan" : ""; ?>" aria-expanded="true" aria-controls="petitumDakwaan" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>E-Document Dakwaan/Petitum <span class="badge badge-danger"><?= (count($data_kelengkapan['petitum_dakwaan'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kelengkapan Dokumen Elektronik dalam pendaftaran perkara (Data Umum)</span>
                        </div>

                    </button>


                </div>

                <div id="petitumDakwaan" class="collapse" aria-labelledby="headingOne" data-parent="#petitum_dakwaan">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pendaftaran</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kelengkapan['petitum_dakwaan'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_pendaftaran']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="data_saksi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kelengkapan['data_saksi'])) ? "#dataSaksi" : ""; ?>" aria-expanded="true" aria-controls="dataSaksi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pencatatan Saksi <span class="badge badge-danger"><?= (count($data_kelengkapan['data_saksi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kelengkapan pencatatan Data Saksi</span>
                        </div>

                    </button>


                </div>

                <div id="dataSaksi" class="collapse" aria-labelledby="headingOne" data-parent="#data_saksi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kelengkapan['data_saksi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="edoc_tuntutan">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kelengkapan['edoc_tuntutan'])) ? "#edocTuntutan" : ""; ?>" aria-expanded="true" aria-controls="edocTuntutan" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>E-Document Tuntutan <span class="badge badge-danger"><?= (count($data_kelengkapan['edoc_tuntutan'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kelengkapan Dokumen Elektronik Tuntutan </span>
                        </div>

                    </button>


                </div>

                <div id="edocTuntutan" class="collapse" aria-labelledby="headingOne" data-parent="#edoc_tuntutan">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal tuntutan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kelengkapan['edoc_tuntutan'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_penuntutan']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="edoc_putusan">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kelengkapan['edoc_putusan'])) ? "#edocPutusan" : ""; ?>" aria-expanded="true" aria-controls="edocPutusan" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>E-Document Putusan Akhir/Penetapan <span class="badge badge-danger"><?= (count($data_kelengkapan['edoc_putusan'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kelengkapan Dokumen Elektronik Putusan </span>
                        </div>

                    </button>


                </div>

                <div id="edocPutusan" class="collapse" aria-labelledby="headingOne" data-parent="#edoc_putusan">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal putusan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kelengkapan['edoc_putusan'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_putusan']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="lapor_mediasi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kelengkapan['lapor_mediasi'])) ? "#laporMediasi" : ""; ?>" aria-expanded="true" aria-controls="laporMediasi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Data Lapor Mediasi <span class="badge badge-danger"><?= (count($data_kelengkapan['lapor_mediasi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kesesuaian pencatatan Tanggal Lapor Mediasi </span>
                        </div>

                    </button>


                </div>

                <div id="laporMediasi" class="collapse" aria-labelledby="headingOne" data-parent="#lapor_mediasi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal keputusan mediasi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kelengkapan['lapor_mediasi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['keputusan_mediasi']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="lapor_diversi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kelengkapan['lapor_diversi'])) ? "#laporDiversi" : ""; ?>" aria-expanded="true" aria-controls="laporDiversi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span> Data Diversi <span class="badge badge-danger"><?= (count($data_kelengkapan['lapor_diversi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kesesuaian pencatatan Tanggal Lapor Diversi </span>
                        </div>

                    </button>


                </div>

                <div id="laporDiversi" class="collapse" aria-labelledby="headingOne" data-parent="#lapor_diversi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal kesepakatan diversi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kelengkapan['lapor_diversi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tgl_kesepakatan_diversi']; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="nilai_gs">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kelengkapan['nilai_gs'])) ? "#nilaiGS" : ""; ?>" aria-expanded="true" aria-controls="nilaiGS" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Data Nilai Sengketa <span class="badge badge-danger"><?= (count($data_kelengkapan['nilai_gs'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kesesuaian pencatatan Nilai Sengketa dalam Perkara Gugatan Sederhana </span>
                        </div>

                    </button>


                </div>

                <div id="nilaiGS" class="collapse" aria-labelledby="headingOne" data-parent="#nilai_gs">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kelengkapan['nilai_gs'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="tab-pane fade" id="nav-kesesuaian" role="tabpanel" aria-labelledby="nav-kesesuaian-tab">
        <div class="accordion" id="kesesuaian_agenda">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kesesuaian['kesesuaian_agenda'])) ? "#kesesuaianAgenda" : ""; ?>" aria-expanded="true" aria-controls="kesesuaianAgenda" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Agenda Sidang Terakhir <span class="badge badge-danger"><?= (count($data_kesesuaian['kesesuaian_agenda'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kesesuaian Agenda Sidang Terakhir dengan status perkara putus </span>
                        </div>

                    </button>


                </div>

                <div id="kesesuaianAgenda" class="collapse" aria-labelledby="headingOne" data-parent="#kesesuaian_agenda">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Agenda terakhir</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kesesuaian['kesesuaian_agenda'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['agenda']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="kesesuaian_tanggal_sidang">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kesesuaian['kesesuaian_tanggal_sidang'])) ? "#kesesuaianTanggalSidang" : ""; ?>" aria-expanded="true" aria-controls="kesesuaianTanggalSidang" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Tanggal Putusan dan Tanggal Sidang Terakhir <span class="badge badge-danger"><?= (count($data_kesesuaian['kesesuaian_tanggal_sidang'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kesesuaian Tanggal Sidang Terakhir dengan Tanggal Putusan </span>
                        </div>

                    </button>


                </div>

                <div id="kesesuaianTanggalSidang" class="collapse" aria-labelledby="headingOne" data-parent="#kesesuaian_tanggal_sidang">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal terakhir sidang</th>
                                    <th>Tanggal putusan</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kesesuaian['kesesuaian_tanggal_sidang'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_sidang']; ?></td>
                                        <td><?= $dpp['tanggal_putusan']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="data_publikasi">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kesesuaian['data_publikasi'])) ? "#dataPublikasi" : ""; ?>" aria-expanded="true" aria-controls="dataPublikasi" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Publikasi Pihak <span class="badge badge-danger"><?= (count($data_kesesuaian['data_publikasi'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kesesuaian Publikasi Perkara </span>
                        </div>

                    </button>


                </div>

                <div id="dataPublikasi" class="collapse" aria-labelledby="headingOne" data-parent="#data_publikasi">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal pendaftaran</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kesesuaian['data_publikasi'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_pendaftaran']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="data_bht">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kesesuaian['data_bht'])) ? "#dataBht" : ""; ?>" aria-expanded="true" aria-controls="dataBht" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pengisian BHT <span class="badge badge-danger"><?= (count($data_kesesuaian['data_bht'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Ada Atau Tidaknya Pencatatan BHT pada suatu perkara </span>
                        </div>

                    </button>


                </div>

                <div id="dataBht" class="collapse" aria-labelledby="headingOne" data-parent="#data_bht">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal putusan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kesesuaian['data_bht'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_putusan']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="penahanan_habis">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kesesuaian['penahanan_habis'])) ? "#penahananHabis" : ""; ?>" aria-expanded="true" aria-controls="penahananHabis" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Penahanan <span class="badge badge-danger"><?= (count($data_kesesuaian['penahanan_habis'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kesesuaian pencatatan penahanan habis sebelum perkara putus </span>
                        </div>

                    </button>


                </div>

                <div id="penahananHabis" class="collapse" aria-labelledby="headingOne" data-parent="#penahanan_habis">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal putusan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kesesuaian['penahanan_habis'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_putusan']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="accordion" id="sisa_panjar">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data_kesesuaian['sisa_panjar'])) ? "#sisaPanjar" : ""; ?>" aria-expanded="true" aria-controls="sisaPanjar" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Sisa Biaya Perkara tk pertama <span class="badge badge-danger"><?= (count($data_kesesuaian['sisa_panjar'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">Kesesuaian pencatatan pengembalian sisa panjar </span>
                        </div>

                    </button>


                </div>

                <div id="sisaPanjar" class="collapse" aria-labelledby="headingOne" data-parent="#sisa_panjar">
                    <div class="card-body p-1">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor perkara</th>
                                    <th>Tanggal putusan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data_kesesuaian['sisa_panjar'] as $dpp) : ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $dpp['nomor_perkara']; ?></td>
                                        <td><?= $dpp['tanggal_putusan']; ?></td>


                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>