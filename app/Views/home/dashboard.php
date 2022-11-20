<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 d-flex justify-content-center">
                        <div class="rounded-circle border border-success d-flex flex-column align-items-center justify-content-center" style="height: 10rem; width: 10rem">
                            <span class="h6 font-weight-bold">EIS bulan ini</span>
                            <span class="h4 font-weight-bold now"></span>
                            <span class="spin-now h4"></span>

                        </div>
                    </div>
                    <div class="col-md-3 d-flex flex-column align-items-center justify-content-center">
                        <span class="h4 font-weight-bold">Peringkat Bulan Ini</span>
                        <span class="peringkat-now h1 font-weight-bold"></span>
                        <span class="spin-now h1"></span>
                    </div>
                    <div class="col-md-3 d-flex flex-column align-items-center justify-content-center">
                        <span class="h4 font-weight-bold">Peringkat Bulan Lalu</span>
                        <span class="peringkat-past h1 font-weight-bold"></span>
                        <span class="spin-past h1"></span>
                    </div>
                    <div class="col-md-3 d-flex justify-content-center">
                        <div class="rounded-circle border border-danger d-flex flex-column align-items-center justify-content-center" style="height: 10rem; width: 10rem">
                            <span class="h6 font-weight-bold">EIS bulan lalu</span>
                            <span class="h4 font-weight-bold past"></span>
                            <span class="spin-past h4"></span>

                        </div>
                    </div>
                </div>
                <div class="d-flex col-md-6 align-items-center mb-3">

                    <h4 class="my-auto card-title"> Data Eksekusi</h4>


                </div>

                <div class="row">
                    <div class="col-md-6">


                        <!-- <h4 class="card-title">Bar chart</h4> -->
                        <canvas id="eksekusiPutusan"></canvas>


                    </div>
                    <div class="col-md-6">

                        <!-- <h4 class="card-title">Bar chart</h4> -->
                        <canvas id="eksekusiHt"></canvas>

                    </div>
                </div>
                <div class="d-flex col-md align-items-center mb-3 mt-2">
                    <div class="col-md-4">
                        <h4 class="my-auto card-title"> Data APM</h4>

                    </div>
                    <select name="semester" id="cari-semester" class="form-control mr-2">
                        <option selected disabled>Pilih semester</option>
                        <option value="I">I</option>
                        <option value="II">II</option>

                    </select>
                    <select name="tahun" id="cari-tahun" class="form-control">
                        <option selected disabled>Pilih tahun</option>
                        <?php
                        $tahun = date('Y');
                        for ($i = 0; $i < 5; $i++) : ?>
                            <option value="<?= $tahun - $i; ?>"><?= $tahun - $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <div class="col">
                        <a href="" class="btn btn-primary cari-data-apm">
                            Submit
                        </a>
                    </div>
                </div>

                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Area</th>
                                <th scope="col">Jumlah Sub Checklist</th>
                                <th scope="col">Jumlah link terisi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-link-apm">


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div id="modal"></div>

    <script>
        $(document).ready(function() {

            let ctx = document.getElementById('eksekusiPutusan'); // node
            ctx = document.getElementById('eksekusiPutusan').getContext('2d'); // 2d context

            myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total', 'Selesai'],
                    datasets: [{
                        label: 'Eksekusi Putusan',
                        backgroundColor: [
                            'rgba(255, 99, 132,0.5)',
                            'rgba(255, 159, 64,0.5)',
                        ],
                        borderColor: 'rgb(255, 99, 132)',
                        data: [<?= $total_eks_putusan; ?>, <?= $total_eks_putusan_selesai; ?>],
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    maintainAspectRatio: false

                },
                plugins: {
                    datalabels: {
                        display: false,
                    },
                }
            });

            let ctx2 = document.getElementById('eksekusiHt'); // node
            ctx2 = document.getElementById('eksekusiHt').getContext('2d'); // 2d context

            myChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: ['Total', 'Selesai'],
                    datasets: [{
                        label: 'Eksekusi Hak Tanggungan',
                        backgroundColor: [
                            'rgba(255, 205, 86,0.5)',
                            'rgba(75, 192, 192,0.5)',
                        ],
                        borderColor: 'rgb(255, 99, 132)',
                        data: [<?= $total_eks_ht; ?>, <?= $total_eks_ht_selesai; ?>],
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    maintainAspectRatio: false

                },
                plugins: {
                    datalabels: {
                        display: false,
                    },
                }
            });

            let data_semester;
            if (new Date().getMonth() >= 1 && new Date().getMonth() <= 6) {
                data_semester = 'I';
            } else {
                data_semester = 'II';
            }
            let linkApm = (semester = null, tahun = null) => {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('home/getLinkApm'); ?>",
                    data: {
                        semester,
                        tahun

                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        $('#tbody-link-apm').html("");
                        let nomorUrut = 1;
                        Object.entries(response).forEach(([key, val]) => {
                            if (key != 'jumlah_total_target' && key != 'jumlah_total_link')
                                $('#tbody-link-apm').append(
                                    `
                        <tr>
                                    <td>${nomorUrut++}</td>
                                    <td class="text-wrap">${key}</td>
                                    <td class="text-wrap">${val.jumlah_target}</td>
                                    <td class="text-wrap">${(val.jumlah_link)?val.jumlah_link:'-'}</td>

                                  </tr>
                        `
                                )
                        });
                        $('#tbody-link-apm').append(
                            `
                        <tr>
                                    <td colspan=2>Total</td>
                                    
                                    <td class="text-wrap">${(response.jumlah_total_target)?response.jumlah_total_target:'-'}</td>
                                    <td class="text-wrap">${(response.jumlah_total_target)?response.jumlah_total_link:'-'}</td>

                                  </tr>
                        `
                        )
                        // response.forEach(element => {
                        //     $('.tbody-akreditasi').append(
                        //         `
                        // <tr>
                        //             <td>${nomorUrut++}</td>
                        //             <td class="text-wrap">${element.jumlah_target}</td>
                        //             <td class="text-wrap">${element.jumlah_link}</td>

                        //           </tr>
                        // `
                        //     )
                        // });

                    }
                });
            }

            linkApm(data_semester, new Date().getFullYear());

            $('.cari-data-apm').on('click', function(e) {
                e.preventDefault();
                let semester = $('#cari-semester').val();
                let tahun = $('#cari-tahun').val();
                linkApm(semester, tahun);
            })

            $.ajax({
                type: "get",
                url: "http://localhost:3000/getdataeis",

                dataType: "json",
                beforeSend: function() {
                    $('.spin-now').html('<i class="fa fa-spin fa-spinner">');
                    $('.spin-past').html('<i class="fa fa-spin fa-spinner">');

                },
                complete: function() {
                    $('.spin-now').html('');
                    $('.spin-past').html('');
                },
                success: function(response) {
                    console.log(response.response);
                    $('.now').text(response.response.now.skor);
                    $('.peringkat-now').text(response.response.now.peringkat);
                    $('.past').text(response.response.past.skor);
                    $('.peringkat-past').text(response.response.past.peringkat);

                },
                error: function(xhr, textStatus, error) {
                    console.log(textStatus);
                    let status = (textStatus == 'error') ? 'Error' : "";
                    $('.now').text(status);
                    $('.peringkat-now').text(status);
                    $('.past').text(status);
                    $('.peringkat-past').text(status);

                }
            });

        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?= $this->endSection(); ?>