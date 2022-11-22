<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Apiakreditasi extends ResourceController
{
    // protected $modelName = 'App\Models\SuratKuasaModel';
    protected $format    = 'json';
    protected $validation;

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }


    public function create()

    {
        $area = $this->request->getVar('area');
        $nomor_apm = $this->request->getVar('nomor_apm');
        $nomor_sub_apm = $this->request->getVar('nomor_sub_apm');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $id_dok = $this->request->getVar('id_dok');
        $link = $this->request->getVar('link');
        $nama_file = $this->request->getVar('nama_file');


        $data_exist = db_connect()->table('link_apm')->where('nomor_apm', $nomor_apm)->where('nomor_sub_apm', $nomor_sub_apm)->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();


        if (!$data_exist) {

            db_connect()->table('link_apm')->insert(['area' => $area, 'nomor_apm' => $nomor_apm, 'nomor_sub_apm' => $nomor_sub_apm, 'semester' => $semester, 'tahun' => $tahun, 'id_dok' => $id_dok, 'link' => $link, 'nama_file' => $nama_file]);
        } else {
            db_connect()->table('link_apm')->where('id', $data_exist['id'])->update(['id_dok' => $id_dok, 'link' => $link]);
        }

        return $this->respond(200);
    }

    public function create_internal()

    {

        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $file_id = $this->request->getVar('file_id');
        $link = $this->request->getVar('link');
        $nama_file = $this->request->getVar('nama_file');


        $data_exist = db_connect()->table('assesment_internal')->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();


        if (!$data_exist) {

            db_connect()->table('assesment_internal')->insert(['semester' => $semester, 'tahun' => $tahun, 'file_id' => $file_id, 'link' => $link, 'nama_file' => $nama_file]);
        } else {
            db_connect()->table('assesment_internal')->where('id', $data_exist['id'])->update(['file_id' => $file_id, 'link' => $link,]);
        }

        return $this->respond(200);
    }

    public function delete_file()
    {
        $id = $this->request->getVar('id');
        db_connect()->table('assesment_internal')->where('file_id', $id)->delete();
        return $this->respond(200);
    }

    public function create_eksternal()

    {

        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $file_id = $this->request->getVar('file_id');
        $link = $this->request->getVar('link');
        $nama_file = $this->request->getVar('nama_file');


        $data_exist = db_connect()->table('assesment_eksternal')->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();


        if (!$data_exist) {

            db_connect()->table('assesment_eksternal')->insert(['semester' => $semester, 'tahun' => $tahun, 'file_id' => $file_id, 'link' => $link, 'nama_file' => $nama_file]);
        } else {
            db_connect()->table('assesment_eksternal')->where('id', $data_exist['id'])->update(['file_id' => $file_id, 'link' => $link,]);
        }

        return $this->respond(200);
    }

    public function delete_file_eksternal()
    {
        $id = $this->request->getVar('id');
        db_connect()->table('assesment_eksternal')->where('file_id', $id)->delete();
        return $this->respond(200);
    }

    public function insert_checklist()

    {

        $data_checklist = $this->request->getVar('data_curl');
        db_connect()->table('apm')->truncate();
        // dd($data);
        // $data_checklist = json_decode($data_checklist, true);

        foreach ($data_checklist as $d) {

            db_connect()->table('apm')->insert($d);
        }

        // return $this->response->setJson($data_checklist);
        return $this->respond(200);
    }





    // ...
}
