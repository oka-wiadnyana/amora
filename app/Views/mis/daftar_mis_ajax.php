<?php foreach ($data as $d) : ?>
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?= $d['slug']; ?>" aria-expanded="false" aria-controls="<?= $d['uraian']; ?>">
                        <?= $d['uraian']; ?> <?= ($d['data_mis']) ? '<span class="badge bg-danger">' . count($d['data_mis']) . '</span>' : ""; ?>
                    </button>
                </h2>
            </div>

            <div id="<?= $d['slug']; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <?php if ($d['data_mis']) : ?>

                    <div class="col">

                        <table class="table">
                            <?php if ($d['id'] == 1) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal masuk
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['diinput_tanggal']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 2) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal akhir penahanan
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['tanggal_akhir']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 3) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal Putusan
                                        </td>
                                        <td>
                                            PP
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['tanggal_putusan']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['panitera_nama']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 4) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal Putusan
                                        </td>
                                        <td>
                                            Tanggal Minutasi
                                        </td>
                                        <td>
                                            PP
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['tanggal_putusan']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['tanggal_minutasi']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['panitera_nama']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 5) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal Putusan
                                        </td>
                                        <td>
                                            Tanggal Minutasi
                                        </td>
                                        <td>
                                            PP
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['tanggal_putusan']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['tanggal_minutasi']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['panitera_nama']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 6) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal Putusan Banding
                                        </td>
                                        <td>
                                            Tanggal Pemb Putusan Banding
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara_pn']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['putusan_banding']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['pemberitahuan_putusan_banding']; ?>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 7) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal Putusan Banding
                                        </td>
                                        <td>
                                            Tanggal Pemb Putusan Banding
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara_pn']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['putusan_kasasi']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['pemberitahuan_putusan_kasasi']; ?>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 8) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            PP
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['panitera_nama']; ?>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 9) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal putusan
                                        </td>
                                        <td>
                                            Pihak yang belum diberitahukan
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['tanggal_putusan']; ?>
                                            </td>
                                            <td>
                                                <?php if ($dm['alur_perkara_id'] == 111 || $dm['alur_perkara_id'] == 112 || $dm['alur_perkara_id'] == 113 || $dm['alur_perkara_id'] == 118) : ?>
                                                    <?php $pihak_jenis = ($dm['pihak'] == 1) ? 'Penuntut Umum' : 'Terdakwa'; ?>
                                                    <?= $pihak_jenis; ?>
                                                <?php elseif ($dm['alur_perkara_id'] == 1 || $dm['alur_perkara_id'] == 8) : ?>
                                                    <?php $pihak_jenis = ($dm['pihak'] == 1) ? 'Penggugat' : 'Tergugat'; ?>
                                                    <?= $pihak_jenis; ?>
                                                <?php elseif ($dm['alur_perkara_id'] == 119) : ?>
                                                    <?php $pihak_jenis = ($dm['pihak'] == 1) ? 'Pemohon' : 'Termohon'; ?>
                                                    <?= $pihak_jenis; ?>
                                                <?php else : ?>
                                                    <?php $pihak_jenis = 'Pemohon'; ?>
                                                    <?= $pihak_jenis; ?>
                                                <?php endif; ?>

                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 10) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal banding
                                        </td>
                                        <td>
                                            Tanggal terakhir pengiriman banding
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara_pn']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['permohonan_banding']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['tanggal_akhir_kirim']; ?>

                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 11) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal kasasi
                                        </td>
                                        <td>
                                            Tanggal terakhir pengiriman kasasi
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara_pn']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['permohonan_kasasi']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['tanggal_akhir_kirim']; ?>

                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 12) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal pk
                                        </td>
                                        <td>
                                            Tanggal terakhir pengiriman pk
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara_pn']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['permohonan_pk']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['tanggal_akhir_kirim']; ?>

                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 13) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal pendaftaran
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['tanggal_pendaftaran']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 14) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal pendaftaran
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['tanggal_pendaftaran']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 15) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tanggal pendaftaran
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['tanggal_putusan']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 16) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Nama Mediator
                                        </td>
                                        <td>
                                            PP
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['nama_mediator']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['panitera_nama']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 17) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tgl Sid Terakhir
                                        </td>
                                        <td>
                                            PP
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['tanggal_terakhir']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['panitera_nama']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 18) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tgl Sidang
                                        </td>
                                        <td>
                                            Nama Pihak
                                        </td>
                                        <td>
                                            Jurusita
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['tanggal_sidang']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['nama_pihak']; ?>
                                            </td>
                                            <td>
                                                <?= $dm['jurusita']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 19) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tgl Putusan
                                        </td>
                                        <td>
                                            Sisa panjar
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['tanggal_putusan']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['sisa_panjar']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 20) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tgl Putusan
                                        </td>
                                        <td>
                                            Sisa panjar
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['putusan_banding']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['sisa_panjar']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 21) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tgl Putusan
                                        </td>
                                        <td>
                                            Sisa panjar
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['tanggal_putusan']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['sisa_panjar']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 22) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tgl Sidang
                                        </td>
                                        <td>
                                            Agenda
                                        </td>
                                        <td>
                                            PP
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['tanggal_sidang']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['agenda']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['panitera_nama']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 23) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor perkara
                                        </td>
                                        <td>
                                            Tgl Putusan
                                        </td>
                                        <td>
                                            Tanggal minutasi
                                        </td>
                                        <td>
                                            Tanggal BHT
                                        </td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td width="10">
                                                <?= $dm['tanggal_putusan']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['tanggal_minutasi']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['tanggal_bht']; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            <?php elseif ($d['id'] == 24) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor
                                        </td>
                                        <td>
                                            PP
                                        </td>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['paniteraku']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 25) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor Perkara
                                        </td>
                                        <td>
                                            PP
                                        </td>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['panitera_nama']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 26) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor Perkara
                                        </td>
                                        <td>
                                            Tanggal Pendaftaran
                                        </td>
                                        <td>
                                            Jenis Perkara
                                        </td>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_register']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['tanggal_pendaftaran']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['nama']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php elseif ($d['id'] == 27) : ?>
                                <thead>
                                    <tr>
                                        <td>
                                            Nomor Perkara
                                        </td>
                                        <td>
                                            Tanggal Pendaftaran
                                        </td>
                                        <td>
                                            Jenis Perkara
                                        </td>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($d['data_mis'] as $dm) : ?>
                                        <tr>


                                            <td width="10">
                                                <?= $dm['nomor_perkara']; ?>
                                            </td>
                                            <td width="10">
                                                <?= $dm['tanggal_pendaftaran']; ?>
                                            </td>

                                            <td>
                                                <?= $dm['jenis_perkara_nama']; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            <?php endif; ?>

                        </table>
                    </div>

                <?php else : ?>
                    <div class="col">
                        <table>
                            <td>Tidak data</td>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
<?php endforeach; ?>