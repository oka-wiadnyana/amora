<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Laporan Review</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row text-center">
            <h1>LAPORAN REVIEW STANDAR PELAYANAN</h1>
            <h1>Bulan <?= $bulan; ?> <?= $tahun; ?></h1>
        </div>
        <div class="col mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">No. Telp</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Evl. Waktu</th>
                        <th scope="col">Syarat</th>
                        <th scope="col">Evl. Syarat</th>
                        <th scope="col">Biaya</th>
                        <th scope="col">Evl. Biaya</th>
                        <th scope="col">Sarana Pengaduan</th>
                        <th scope="col">Evl. Srn Pengaduan</th>
                        <th scope="col">Waktu Layanan</th>
                        <th scope="col">Evl. Wakt Lyn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($data as $d) : ?>
                        <tr>
                            <th scope="row"><?= $no++; ?></th>
                            <td><?= $d->name; ?></td>
                            <td><?= $d->phone_number; ?></td>
                            <td><?= $d->time_suitability == 1 ? "Sesuai" : "Tidak Sesuai"; ?></td>
                            <td><?= $d->time_review; ?></td>
                            <td><?= $d->term_suitability == 1 ? "Sesuai" : "Tidak Sesuai"; ?></td>
                            <td><?= $d->term_review; ?></td>
                            <td><?= $d->cost_suitability == 1 ? "Sesuai" : "Tidak Sesuai"; ?></td>
                            <td><?= $d->cost_review; ?></td>
                            <td><?= $d->complaint_suitability == 1 ? "Sesuai" : "Tidak Sesuai"; ?></td>
                            <td><?= $d->complaint_review; ?></td>
                            <td><?= $d->service_hours_suitability == 1 ? "Sesuai" : "Tidak Sesuai"; ?></td>
                            <td><?= $d->service_hours_review; ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col text-center">
                    <br>
                    <h6>Ketua Pembangunan ZI</h6>
                    <br>
                    <br>
                    <br>
                    <h6><?= $wakil->nama; ?></h6>
                    <h6>NIP.<?= $wakil->nip; ?></h6>
                </div>
                <div class="col text-center">
                    <h6><?= $tanggal_laporan; ?></h6>
                    <h6>Ketua Pembangunan ZI</h6>
                    <br>
                    <br>
                    <br>
                    <h6><?= $koordinator->nama; ?></h6>
                    <h6>NIP.<?= $koordinator->nip; ?></h6>
                </div>
            </div>
            <div class="row text-center">
                <h6>Mengetahui</h6>
                <h6>Ketua</h6>
                <br>
                <br>
                <br>
                <h6><?= $ketua->nama; ?></h6>
                <h6>NIP.<?= $ketua->nip; ?></h6>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>