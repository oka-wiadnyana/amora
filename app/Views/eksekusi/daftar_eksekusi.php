<?= $this->extend('layout/main'); ?>
<?= $this->section('mainContent'); ?>
<div class="content-wrapper">

  <div class="d-xl-flex justify-content-between align-items-start">
    <h2 class="text-dark font-weight-bold mb-2"> Daftar Eksekusi Putusan Selesai </h2>
  </div>
  <div class="row bg-white p-2">
    <table class="table table-bordered" id="table-eksekusi">
      <thead>
        <tr>
          <th> # </th>
          <th> Nomor Eksekusi </th>
          <th> Nama Pemohon </th>
          <th> Tgl Pen Aanmaning </th>
          <th> Tgl Aanmaning </th>
          <th> Tgl Pen Sita </th>
          <th> Tgl Sita </th>
          <th> Tgl Pen Lelang </th>
          <th> Tgl Lelang </th>
          <th> Tgl Pen Riil </th>
          <th> Tgl Eks Riil </th>
          <th> Tgl Non Eks </th>
          <th> Tgl Cabut </th>
          <th> Catatan </th>
          <th> Status </th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>
<script>
  $(document).ready(function() {
    function table_data_eksekusi() {
      let table = $('#table-eksekusi').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          "url": "<?= base_url('eksekusi/data_eksekusi_datatable'); ?>",
          "type": "POST"
        },
        "columnDefs": [{
            "target": 0,
            "orderable": false,
          },
          {
            responsivePriority: 1,
            targets: 0,

          },
          {
            responsivePriority: 1,
            targets: -1,

          },
          {
            responsivePriority: 1,
            targets: 1,

          },

        ],
        rowReorder: {
          selector: 'td:nth-child(1)'
        },
        responsive: true

      })

    }
    table_data_eksekusi();
  });
</script>
<?= $this->endSection(); ?>