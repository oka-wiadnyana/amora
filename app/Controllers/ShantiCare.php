<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ngekoding\CodeIgniterDataTables\DataTables;
use CodeIgniter\I18n\Time;

class ShantiCare extends BaseController
{
    private $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }
    public function keluhan()
    {

        return view('shanti_care/keluhan');
    }

    public function keluhan_datatable()
    {


        $queryBuilder = db_connect('shanti_care')->table('inputs a')->select('a.id as id_input,a.*,b.*')->join('responses b', 'a.id=b.input_id', 'left')->where('input_type', 1);


        $datatables = new DataTables($queryBuilder, '4');
        $datatables->addColumn('action', function ($row) {

            $btn = '<a class="btn btn-warning response-btn" data-id="' . $row->id_input . '">Response</a>';
            return $btn;
        });
        $datatables->addColumn('evidence', function ($row) {

            if ($row->evidence) {

                $btn = '<a class="" href="' . getenv('SHANTI_CARE') . $row->evidence . '" data-id="">Evidence</a>';
                return $btn;
            }
        });

        // $datatables->format('file', function ($value, $row) {
        //     $btn = '<a href="' . base_url('file_monev_zi/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
        //     return $btn;
        // });



        $datatables->only(['input_date', 'name', 'phone_number', 'input', 'evidence', 'response']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }

    public function modal_response()
    {
        $id = $this->request->getVar('id');
        $data_keluhan = db_connect('shanti_care')->table('responses')->where('input_id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('shanti_care/modal_response', ['data_keluhan' => $data_keluhan, 'input_id' => $id])]);
    }

    public function insert_response($ubah = null)
    {
        if (!$ubah) {
            if (!$this->validate([

                'response' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Response  harus diisi',

                    ]
                ],


            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->back();
            }
        } else {
            if (!$this->validate([

                'response' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Response  harus diisi',

                    ]
                ],
            ])) {
                session()->setFlashdata('validasi', $this->validation->getErrors());
                return redirect()->back();
            }
        }



        $response = $this->request->getVar('response');
        $input_id = $this->request->getVar('input_id');

        $response_date = Time::now();



        if (!$ubah) {

            db_connect('shanti_care')->table('responses')->insert(compact('input_id', 'response', 'response_date'));
        } else {
            db_connect('shanti_care')->table('responses')->where('input_id', $input_id)->update(compact('response'));
        }


        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function saran($jenis)
    {

        return view('shanti_care/saran', ['jenis' => $jenis]);
    }

    public function saran_datatable($jenis)
    {


        $queryBuilder = db_connect('shanti_care')->table('inputs a')->select('a.id as id_input,a.*,b.*')->join('responses b', 'a.id=b.input_id', 'left')->where('input_type', $jenis);


        $datatables = new DataTables($queryBuilder, '4');
        // $datatables->addColumn('action', function ($row) {

        //     $btn = '<a class="btn btn-warning response-btn" data-id="' . $row->id_input . '">Edit</a> <a class="btn btn-danger hapus-btn" data-id="' . $row->id_input . '">Hapus</a>';
        //     return $btn;
        // });
        $datatables->addColumn('evidence', function ($row) {

            if ($row->evidence) {

                $btn = '<a class="" href="' . getenv('SHANTI_CARE') . $row->evidence . '" data-id="">Evidence</a>';
                return $btn;
            }
        });

        // $datatables->format('file', function ($value, $row) {
        //     $btn = '<a href="' . base_url('file_monev_zi/' . $value) . '" target="_blank"><span class="mdi mdi-file-document text-danger h2"></span></a>';
        //     return $btn;
        // });



        $datatables->only(['input_date', 'name', 'phone_number', 'input', 'evidence']);
        $datatables->addSequenceNumber();
        $datatables->generate(); // done
    }
}
