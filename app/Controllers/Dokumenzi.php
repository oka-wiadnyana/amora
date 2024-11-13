<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;

class Dokumenzi extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        //
    }

    public function data_dokumen($kode_area = null)
    {
        $data_area = db_connect()->table('area_zi')->where('kode_area', $kode_area)->get()->getRowArray();
        return view('dokumenzi/laporan_dokumen', ['data_area' => $data_area]);
    }

    public function data_dokumenzi_datatable($kode_area = null, $jenis_dokumen = null)
    {

        if ($kode_area && $jenis_dokumen) {

            $queryBuilder = db_connect()->table('dokumen_zi a')->select('a.id as id_dokumen,a.*,b.*')->join('area_zi b', 'a.area_zi=b.kode_area')->where('kode_area', $kode_area)->where('jenis_dokumen', $jenis_dokumen);
        }

        if ($kode_area == null && $jenis_dokumen == null) {

            $queryBuilder = db_connect()->table('dokumen_zi a')->select('a.id as id_dokumen,a.*')->where('jenis_dokumen', 'hasil');
        }


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning edit-btn" data-id="' . $row->id_dokumen . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_dokumen . '">Hapus</a>';
            return $btn;
        });

        $datatables->format('file', function ($value, $row) {
            $extensi = explode('.', $value);
            $extensi = $extensi[1];
            $color = $extensi == "pdf" ? 'danger' : ($extensi == "doc" || $extensi == "docx" || $extensi == "rtf" ? 'primary' : 'success');

            $btn = '<a href="' . base_url('file_dokumen_zi/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-' . $color . ' h2"></span></a>';
            return $btn;
        });

        // $datatables->format('bulan', function ($value, $row) {
        //     $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

        //     return $bulan[$value];
        // });
        if ($kode_area && $jenis_dokumen) {
            $datatables->only(['sub_area', 'sub_sub_area', 'tahun', 'nama_dokumen', 'file']);
        }
        if ($kode_area == null && $jenis_dokumen == null) {
            $datatables->only(['tahun', 'nama_dokumen', 'file']);
        }
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_laporan($kode_area = null)
    {
        $id = $this->request->getVar('id');
        $data_laporan = db_connect()->table('dokumen_zi')->where('id', $id)->get()->getRowArray();
        $bulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('dokumenzi/modal_laporan', ['bulans' => $bulan, 'tahuns' => $tahun, 'kode_area' => $kode_area, 'data_laporan' => $data_laporan])]);
    }

    public function insert_laporan($ubah = null)
    {
        $area_zi = $this->request->getVar('kode_area');
        if ($area_zi) {
            if (!$ubah) {
                if (!$this->validate([

                    'jenis_dokumen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Jenis Dokumen harus diisi'
                        ]
                    ],
                    'sub_area' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Sub Area harus diisi'
                        ]

                    ],
                    'sub_sub_area' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Sub Sub Area harus diisi'
                        ]
                    ],
                    'tahun' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tahun harus diisi'
                        ]
                    ],
                    'nama_dokumen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama dokumen harus diisi'
                        ]
                    ],
                    'file' => [
                        'rules' => 'uploaded[file]|ext_in[file,pdf,doc,docx,rtf,xls,xlsx]',
                        'errors' => [
                            'uploaded' => 'File harus  diisi',
                            'ext_in' => 'Jenis file salah'
                        ]
                    ],


                ])) {
                    session()->setFlashdata('validasi', $this->validation->getErrors());
                    return redirect()->to('dokumenzi/data_dokumen/' . $area_zi);
                }
            }

            if ($ubah) {
                if (!$this->validate([
                    'jenis_dokumen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Jenis Dokumen harus diisi'
                        ]
                    ],
                    'sub_area' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Sub Area harus diisi'
                        ]

                    ],
                    'sub_sub_area' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Sub Sub Area harus diisi'
                        ]
                    ],
                    'tahun' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tahun harus diisi'
                        ]
                    ],
                    'nama_dokumen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama dokumen harus diisi'
                        ]
                    ],
                    'file' => [
                        'rules' => 'ext_in[file,pdf,doc,docx,rtf,xls,xlsx]',
                        'errors' => [

                            'ext_in' => 'Jenis file salah'
                        ]
                    ]

                ])) {
                    session()->setFlashdata('validasi', $this->validation->getErrors());
                    return redirect()->to('dokumenzi/data_dokumen/' . $area_zi);
                }
            }
        }

        if (!$area_zi) {
            if (!$ubah) {
                if (!$this->validate([


                    'tahun' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tahun harus diisi'
                        ]
                    ],
                    'nama_dokumen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama dokumen harus diisi'
                        ]
                    ],
                    'file' => [
                        'rules' => 'uploaded[file]|ext_in[file,pdf,doc,docx,rtf,xls,xlsx]',
                        'errors' => [
                            'uploaded' => 'File harus  diisi',
                            'ext_in' => 'Jenis file salah'
                        ]
                    ],


                ])) {
                    session()->setFlashdata('validasi', $this->validation->getErrors());
                    return redirect()->to('dokumenzi/data_dokumen');
                }
            }

            if ($ubah) {
                if (!$this->validate([

                    'tahun' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Tahun harus diisi'
                        ]
                    ],
                    'nama_dokumen' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Nama dokumen harus diisi'
                        ]
                    ],
                    'file' => [
                        'rules' => 'ext_in[file,pdf,doc,docx,rtf,xls,xlsx]',
                        'errors' => [

                            'ext_in' => 'Jenis file salah'
                        ]
                    ]

                ])) {
                    session()->setFlashdata('validasi', $this->validation->getErrors());
                    return redirect()->to('dokumenzi/data_dokumen');
                }
            }
        }



        $jenis_dokumen = $area_zi ? $this->request->getVar('jenis_dokumen') : 'hasil';
        $sub_area = $this->request->getVar('sub_area');
        $sub_sub_area = $this->request->getVar('sub_sub_area');
        $tahun = $this->request->getVar('tahun');
        $nama_dokumen = $this->request->getVar('nama_dokumen');

        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'File-DokumenZI-'  . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_dokumen_zi', $file);
        } else {
            $file = $this->request->getVar('file_lama');
        }

        if ($area_zi) {
            $data_insert = compact('jenis_dokumen', 'sub_area', 'sub_sub_area', 'tahun', 'nama_dokumen', 'file', 'area_zi');
        }
        if (!$area_zi) {
            $data_insert = compact('jenis_dokumen', 'tahun', 'nama_dokumen', 'file');
        }


        if (!$ubah) {
            if (db_connect()->table('dokumen_zi')->insert($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diinput');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diinput']);
            }
            if ($area_zi) {

                return redirect()->to('dokumenzi/data_dokumen/' . $area_zi);
            }
            if (!$area_zi) {

                return redirect()->to('dokumenzi/data_dokumen');
            }
        }

        if ($ubah) {
            $id = $this->request->getVar('id');
            if (db_connect()->table('dokumen_zi')->where('id', $id)->update($data_insert)) {
                session()->setFlashdata('success', 'Data berhasil diupdate');
            } else {
                session()->setFlashdata('validasi', ['Data gagal diupdate']);
            }
            if ($area_zi) {

                return redirect()->to('dokumenzi/data_dokumen/' . $area_zi);
            }
            if (!$area_zi) {

                return redirect()->to('dokumenzi/data_dokumen');
            }
        }
    }

    public function hapus_laporan()
    {
        $id = $this->request->getVar('id');
        if (db_connect()->table('dokumen_zi')->where('id', $id)->delete()) {
            session()->setFlashdata('success', 'Data berhasil dihapus');
            return $this->response->setJSON(['msg' => 'success']);
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return $this->response->setJSON(['msg' => 'fail']);
        }
    }

    public function import_file()
    {
        return view('dokumenzi/v_import_file');
    }

    public function import_file_db()
    {

        if (!$this->validate([

            'jenis_file' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis File harus diisi'
                ]
            ],
            'file' => [
                'rules' => 'uploaded[file]',
                'errors' => [
                    'uploaded' => 'File harus  diisi',

                ]
            ],


        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('dokumenzi/import_file');
        }

        $jenis_file = $this->request->getVar('jenis_file');
        $file = $this->request->getFile('file');
        $file_name =  $jenis_file . '-' . time() . "." . $file->guessExtension();
        $file->move('raw_file', $file_name);
        # Create a new Xls Reader
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
        $spreadsheet = $reader->load(ROOTPATH . 'public/raw_file/' . $file_name);

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();

        if ($jenis_file == 'area') {

            db_connect()->table('area_zi')->truncate();
            $jml_data = 0;
            foreach ($data as $key => $value) {
                if ($key == 0) {
                    continue;
                }

                $data_insert = [
                    'kode_area' => $value[0],
                    'nama_area' => $value[1],


                ];

                db_connect()->table('area_zi')->insert($data_insert);
                $jml_data++;
            }
        }

        if ($jenis_file == 'sub_area') {

            db_connect()->table('sub_area')->truncate();
            $jml_data = 0;
            foreach ($data as $key => $value) {
                if ($key == 0) {
                    continue;
                }

                $data_insert = [
                    'kode_sub_area' => $value[0],
                    'area' => $value[1],
                    'sub_area' => $value[2],
                    'uraian' => $value[3],

                ];

                db_connect()->table('sub_area')->insert($data_insert);
                $jml_data++;
            }
        }

        if ($jenis_file == 'sub_sub_area') {

            db_connect()->table('sub_sub_area')->truncate();
            $jml_data = 0;
            foreach ($data as $key => $value) {
                if ($key == 0) {
                    continue;
                }

                $data_insert = [


                    'kode_sub_sub_area' => $value[0],
                    'area' => $value[1],
                    'sub_area' => $value[2],
                    'sub_sub_area' => $value[3],
                    'uraian' => $value[4],

                ];

                db_connect()->table('sub_sub_area')->insert($data_insert);
                $jml_data++;
            }
        }

        if ($jenis_file == 'sub_reform') {

            db_connect()->table('sub_reform')->truncate();
            $jml_data = 0;
            foreach ($data as $key => $value) {
                if ($key == 0) {
                    continue;
                }

                $data_insert = [
                    'kode_sub_reform' => $value[0],
                    'area' => $value[1],
                    'sub_area' => $value[2],
                    'uraian' => $value[3],

                ];

                db_connect()->table('sub_reform')->insert($data_insert);
                $jml_data++;
            }
        }

        if ($jenis_file == 'sub_sub_reform') {

            db_connect()->table('sub_sub_reform')->truncate();
            $jml_data = 0;
            foreach ($data as $key => $value) {
                if ($key == 0) {
                    continue;
                }

                $data_insert = [


                    'kode_sub_sub_reform' => $value[0],
                    'area' => $value[1],
                    'sub_area' => $value[2],
                    'sub_sub_area' => $value[3],
                    'uraian' => $value[4],

                ];

                db_connect()->table('sub_sub_reform')->insert($data_insert);
                $jml_data++;
            }
        }

        if (db_connect()->affectedRows()) {
            session()->setFlashdata('success', 'Berhasil import');
            return redirect()->to(base_url('dokumenzi/import_file'));
        } else {
            session()->setFlashdata('validasi', ['Gagal import']);
            return redirect()->to(base_url('dokumenzi/import_file'));
        }
    }

    public function data_area($area = null)
    {
        $sub_sub_area = db_connect()->table('sub_sub_area')->where('area', $area)->get()->getResultArray();

        $data = [];

        foreach ($sub_sub_area as $key => $value) {
            $data[$value['area']][$value['sub_area']][] = ['sub_sub_area' => $value['sub_sub_area'], 'kode' => $value['kode_sub_sub_area'], 'uraian' => $value['uraian']];
        }

        $data_area = db_connect()->table('area_zi')->get()->getResultArray();
        $area_zi = [];
        foreach ($data_area as $da) {
            $area_zi[$da['kode_area']] = $da['nama_area'];
        }

        $data_sub_area = db_connect()->table('sub_area')->where('area', $area)->get()->getResultArray();

        $sub_area = [];
        foreach ($data_sub_area as $ds) {
            $sub_area[$ds['sub_area']] = $ds['uraian'];
        }
        // dd($sub_area);
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return view('dokumenzi/table_area', ['data' => $data, 'area_zi' => $area_zi, 'sub_area' => $sub_area, 'area' => $area, 'tahuns' => $tahun]);
    }

    public function modal_upload($area = null)
    {
        $kode = $this->request->getVar('kode');
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('dokumenzi/modal_upload', ['kode' => $kode, 'tahuns' => $tahun, 'area' => $area])]);
    }

    public function insert_file()
    {
        $area = $this->request->getVar('area');
        if (!$this->validate([

            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi'
                ]
            ],
            'nama_file' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]

            ],
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,pdf,doc,docx,rtf,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'File harus  diisi',
                    'ext_in' => 'Jenis file salah'
                ]
            ],


        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('dokumenzi/data_area/' . $area);
        }




        $tahun = $this->request->getVar('tahun');
        $kode = $this->request->getVar('kode');
        $nama_file = $this->request->getVar('nama_file');

        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'ZI-'  . $kode . '-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_dokumen_zi', $file);
        }


        if (db_connect()->table('zi_file')->insert(['kode_sub_sub_area' => $kode, 'tahun' => $tahun, 'nama_file' => $nama_file, 'file' => $file])) {
            session()->setFlashdata('success', 'Data berhasil diinput');
            return redirect()->to('dokumenzi/data_area/' . $area);
        }
    }

    public function modal_file($area = null)
    {
        $kode = $this->request->getVar('kode');
        $tahun = $this->request->getVar('tahun');
        $data_file = db_connect()->table('zi_file')->where('kode_sub_sub_area', $kode)->where('tahun', $tahun)->get()->getResultArray();

        return $this->response->setJSON([view('dokumenzi/modal_file', ['kode' => $kode, 'tahuns' => $tahun, 'area' => $area, 'data_file' => $data_file])]);
    }

    public function data_reform($area = null)
    {
        $sub_sub_reform = db_connect()->table('sub_sub_reform')->where('area', $area)->get()->getResultArray();

        $data = [];

        foreach ($sub_sub_reform as $key => $value) {
            $data[$value['area']][$value['sub_area']][] = ['sub_sub_area' => $value['sub_sub_area'], 'kode' => $value['kode_sub_sub_reform'], 'uraian' => $value['uraian']];
        }

        $data_area = db_connect()->table('area_zi')->get()->getResultArray();
        $area_zi = [];
        foreach ($data_area as $da) {
            $area_zi[$da['kode_area']] = $da['nama_area'];
        }

        $data_sub_reform = db_connect()->table('sub_reform')->where('area', $area)->get()->getResultArray();

        $sub_reform = [];
        foreach ($data_sub_reform as $ds) {
            $sub_reform[$ds['sub_area']] = $ds['uraian'];
        }
        // dd($sub_area);
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return view('dokumenzi/table_reform', ['data' => $data, 'area_zi' => $area_zi, 'sub_reform' => $sub_reform, 'area' => $area, 'tahuns' => $tahun]);
    }

    public function modal_upload_reform($area = null)
    {
        $kode = $this->request->getVar('kode');
        $tahun_ini = date('Y');
        $tahun = [];
        for ($i = 0; $i < 10; $i++) {
            $tahun[] = $tahun_ini - $i;
        }

        return $this->response->setJSON([view('dokumenzi/modal_upload_reform', ['kode' => $kode, 'tahuns' => $tahun, 'area' => $area])]);
    }

    public function insert_file_reform()
    {
        $area = $this->request->getVar('area');
        if (!$this->validate([

            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi'
                ]
            ],
            'nama_file' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi'
                ]

            ],
            'file' => [
                'rules' => 'uploaded[file]|ext_in[file,pdf,doc,docx,rtf,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'File harus  diisi',
                    'ext_in' => 'Jenis file salah'
                ]
            ],


        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to('dokumenzi/data_reform/' . $area);
        }




        $tahun = $this->request->getVar('tahun');
        $kode = $this->request->getVar('kode');
        $nama_file = $this->request->getVar('nama_file');

        $file_doc = $this->request->getFile('file');
        if ($file_doc->isValid()) {

            $file = 'ZI-Reform'  . $kode . '-' . time() . '.' . $file_doc->guessExtension();
            $file_doc->move('file_dokumen_zi', $file);
        }


        if (db_connect()->table('reform_file')->insert(['kode_sub_sub_reform' => $kode, 'tahun' => $tahun, 'nama_file' => $nama_file, 'file' => $file])) {
            session()->setFlashdata('success', 'Data berhasil diinput');
            return redirect()->to('dokumenzi/data_reform/' . $area);
        }
    }

    public function modal_file_reform($area = null)
    {
        $kode = $this->request->getVar('kode');
        $tahun = $this->request->getVar('tahun');
        $data_file = db_connect()->table('reform_file')->where('kode_sub_sub_reform', $kode)->where('tahun', $tahun)->get()->getResultArray();

        return $this->response->setJSON([view('dokumenzi/modal_file_reform', ['kode' => $kode, 'tahuns' => $tahun, 'area' => $area, 'data_file' => $data_file])]);
    }

    public function delete_file()
    {
        $id = $this->request->getVar('id');
        db_connect()->table('zi_file')->where('id', $id)->delete();
        session()->setFlashdata('success', 'File berhasil dihapus');
        return $this->response->setJSON(['success']);
    }

    public function delete_file_reform()
    {
        $id = $this->request->getVar('id');
        db_connect()->table('reform_file')->where('id', $id)->delete();
        session()->setFlashdata('success', 'File berhasil dihapus');
        return $this->response->setJSON(['success']);
    }
}
