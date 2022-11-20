<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex col-md-6 align-items-center mb-3">

                    <h4 class="my-auto card-title"> Data MIS</h4>

                </div>

                <div class="row view-mis">
                    <div class="spinner-mis h1"></div>
                </div>

            </div>
        </div>
    </div>
    <div id="modal"></div>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "get",
                url: "<?= base_url('mis/mis_ajax'); ?>",

                dataType: "json",
                beforeSend: function() {
                    $('.spinner-mis').html("<i class='fa fa-spin fa-spinner'></i>")

                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $('.view-mis').html(response)

                }

            });
        });
    </script>



    <?= $this->endSection(); ?>