<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="kepatuhan-tab" data-toggle="tab" data-target="#kepatuhan" type="button" role="tab" aria-controls="kepatuhan" aria-selected="true">Kepatuhan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="kelengkapan-tab" data-toggle="tab" data-target="#kelengkapan" type="button" role="tab" aria-controls="kelengkapan" aria-selected="false">Kelengkapan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="kesesuaian-tab" data-toggle="tab" data-target="#kesesuaian" type="button" role="tab" aria-controls="kesesuaian" aria-selected="false">kesesuaian</button>
    </li>

</ul>

<!-- Tab panes -->
<div class="tab-content" id="tab-content">
    <div class="tab-pane active" id="kepatuhan" role="tabpanel" aria-labelledby="home-tab">
        <div class="accordion" id="pendaftaran_perkara">
            <div class="card">
                <div class="card-header p-1" id="headingOne">

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data['pendaftaran_perkara'])) ? "#pendaftaranPerkara" : ""; ?>" aria-expanded="true" aria-controls="pendaftaranPerkara" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pendaftaran Perkara <span class="badge badge-danger"><?= (count($data['pendaftaran_perkara'])) ?: ""; ?></span></span>
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
                                <?php foreach ($data['pendaftaran_perkara'] as $dpp) : ?>

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

                    <button class="btn btn-link btn-block text-left p-0 m-0" type="button" data-toggle="collapse" data-target="<?= (count($data['barang_bukti'])) ? "#barangBukti" : ""; ?>" aria-expanded="true" aria-controls="barangBukti" style="text-decoration: none">
                        <div class="col-md-10 d-flex flex-column">

                            <span>Pencatatan Barang Bukti <span class="badge badge-danger"><?= (count($data['barang_bukti'])) ?: ""; ?></span></span>
                            <span class="font-italic font-weight-light">KKepatuhan Pengguna dalam mengisi Barang Bukti suatu perkara</span>
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
                                <?php foreach ($data['barang_bukti'] as $dpp) : ?>

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
        <div class="tab-pane " kelengkapan" role="tabpanel" aria-labelledby="kelengkapan-tab">Profile</div>
        <div class="tab-pane " kesesuaian" role="tabpanel" aria-labelledby="kesesuaian-tab">Message</div>

    </div>
</div>
<script>

</script>