<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Message;

class Home extends BaseController
{
    public function index()
    {
        $data_total_eksekusi_putusan = db_connect('sipp')->table('perkara_eksekusi')->countAllResults();
        $data_eksekusi_putusan_selesai = db_connect('sipp')->table('perkara_eksekusi')->groupStart()->where('pelaksanaan_eksekusi_lelang !=', null)->where('pelaksanaan_eksekusi_lelang !=', '0000-00-00')->groupEnd()->orGroupStart()->where('pelaksanaan_eksekusi_rill !=', null)->where('pelaksanaan_eksekusi_rill !=', '0000-00-00')->groupEnd()->orGroupStart()->where('penetapan_noneksekusi !=', null)->where('penetapan_noneksekusi !=', '0000-00-00')->groupEnd()->orGroupStart()->where('tanggal_cabut_eks !=', null)->where('tanggal_cabut_eks !=', '0000-00-00')->groupEnd()->countAllResults();
        $data_total_eksekusi_ht = db_connect('sipp')->table('perkara_eksekusi_ht')->countAllResults();
        $data_eksekusi_ht_selesai = db_connect('sipp')->table('perkara_eksekusi_ht')->groupStart()->where('pelaksanaan_eksekusi_lelang !=', null)->where('pelaksanaan_eksekusi_lelang !=', '0000-00-00')->groupEnd()->orGroupStart()->where('pelaksanaan_eksekusi_rill !=', null)->where('pelaksanaan_eksekusi_rill !=', '0000-00-00')->groupEnd()->orGroupStart()->where('penetapan_noneksekusi !=', null)->where('penetapan_noneksekusi !=', '0000-00-00')->groupEnd()->orGroupStart()->where('tanggal_cabut_ht !=', null)->where('tanggal_cabut_ht !=', '0000-00-00')->groupEnd()->countAllResults();
        // dd($data_eksekusi_putusan_selesai);
        $message = new Message();


        $data = [
            'total_eks_putusan' => $data_total_eksekusi_putusan,
            'total_eks_putusan_selesai' => $data_eksekusi_putusan_selesai,
            'total_eks_ht' => $data_total_eksekusi_ht,
            'total_eks_ht_selesai' => $data_eksekusi_ht_selesai,
            'host' => $message->headers()['Host']->getValue()

        ];
        return view('home/dashboard', $data);
    }

    public function getLinkApm()
    {
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $jumlah_data_apm = db_connect()->table('apm')->select('area')->selectSum('jumlah_sub')->groupBy('apm.area')->get()->getResultArray();
        $jumlah_link_apm = db_connect()->table('link_apm')->select('area')->selectCount('area', 'jml_link')->where('semester', $semester)->where('tahun', $tahun)->groupBy('area')->get()->getResultArray();

        $jml_data_target = [];
        foreach ($jumlah_data_apm as $value) {
            $jml_data_target[$value['area']] = ['jumlah_target' => $value['jumlah_sub']];
        }

        $jml_data_link = [];
        foreach ($jumlah_link_apm as $la) {
            $jml_data_link[$la['area']] = ['jumlah_link' => $la['jml_link']];
        }

        $jumlah_total_target = db_connect()->table('apm')->selectSum('jumlah_sub', 'jumlah_sub')->get()->getRowArray()['jumlah_sub'];

        $jumlah_total_link = db_connect()->table('link_apm')->where('semester', $semester)->where('tahun', $tahun)->countAllResults();


        // dd($jml_dataku);
        $data_baru = array_merge_recursive($jml_data_target, $jml_data_link, ['jumlah_total_target' => $jumlah_total_target], ['jumlah_total_link' => $jumlah_total_link]);

        return $this->response->setJSON($data_baru);
    }
}
