<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;
use Config\Validation;

class Akreditasi extends BaseController
{
    public function __construct()
    {
        // $data_gc = db_connect()->table('google_client')->get()->getRowArray();

        // $this->data_redirect_uri = db_connect()->table('redirect_uri_akreditasi');

        // $this->validation = Services::validation();
        // $this->client = Services::curlrequest();
        // $this->googleClient = new \Google\Client();
        // $this->googleClient->setClientId($data_gc['client_id']);
        // $this->googleClient->setClientSecret($data_gc['client_secret']);
        // $this->googleClient->addScope("https://www.googleapis.com/auth/drive");
        // $this->parentFolderId = db_connect()->table('parent_folder_akreditasi');
        // $this->service = new \Google\Service\Drive($this->googleClient);
    }

    public function index($area = null)
    {
        $data_apm = db_connect()->table('apm')->where('area', 'KETUA')->get()->getResultArray();
        return view('akreditasi/daftar_akreditasi', ['data' => $data_apm]);
    }

    public function getDataApm()
    {
        $area = $this->request->getVar('area');

        if ($area == 'wakil') {
            $data_apm = db_connect()->table('apm')->where('area', 'WAKIL KETUA')->orWhere('area', 'WAKIL KETUA / MR')->get()->getResultArray();
        } else {
            $data_apm = db_connect()->table('apm')->where('area', $area)->get()->getResultArray();
        }
        // $data_apm = db_connect()->table('apm')->where('area', 'KETUA')->get()->getResultArray();

        $data_apm_fix = [];
        foreach ($data_apm as $d) {

            $exploded = preg_split('/\d\./', $d['uraian']);
            // dd($exploded);
            $uraian_fix = "";
            foreach ($exploded as $key => $value) {
                if ($key == 0) {
                    if ($value == "") {

                        continue;
                    } else {
                        $uraian_fix .= "- " . $value;
                    }
                }
                $uraian_fix .= $key . ". " . $value . '</br>';
            }

            $data_apm_fix[] = ['id' => $d['id'], 'nomor' => $d['nomor'], 'area' => $d['area'], 'penilaian' => $d['penilaian'], 'bobot' => $d['bobot'], 'area_zi' => $d['area_zi'], 'uraian' => $uraian_fix];
        }

        return $this->response->setJSON($data_apm_fix);
    }


    public function modal_upload_doc()
    {
        $id = $this->request->getVar('id');
        $data_apm = db_connect()->table('apm')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('akreditasi/modal_upload_doc', ['data' => $data_apm])]);
    }

    public function upload_doc()
    {
        if (!$this->validate([
            'file_apm' => [
                'rules' => 'uploaded[file_apm]|ext_in[file_apm,pdf]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'Jenis file salah'
                ]
            ],
            'nomor_sub_apm' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor sub apm harus diisi',

                ]
            ],

        ])) {
            $msg = implode(', ', $this->validation->getErrors());
            return $this->response->setJSON(['status' => 'invalid', 'msg' => $msg]);
        }


        $area = $this->request->getVar('area');
        $nomor_sub_apm = $this->request->getVar('nomor_sub_apm');
        $nomor_apm = $this->request->getVar('nomor_apm');
        $file_apm = $this->request->getFile('file_apm');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $file_name = $nomor_apm . "-" . $nomor_sub_apm . "-" . $semester . "-" . $tahun . "." . $file_apm->guessExtension();
        $data_exist = db_connect()->table('link_apm')->where('nomor_apm', $nomor_apm)->where('nomor_sub_apm', $nomor_sub_apm)->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();
        if ($data_exist) {
            session()->set('id_file_drive', $data_exist['id_dok']);

            session()->set('id', $data_exist['id']);
            session()->set('exist', true);
        } else {
            session()->set('exist', false);
        }
        session()->set('tahun', $tahun);
        session()->set('area', $area);
        session()->set('semester', $semester);
        session()->set('file_name', $file_name);
        session()->set('nomor_apm', $nomor_apm);
        session()->set('nomor_sub_apm', $nomor_sub_apm);

        if ($file_apm->move('temp_file', $file_name)) {
            $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'upload checklist')->get()->getRowArray()['uri']));
            return redirect()->to($this->googleClient->createAuthUrl());
        } else {
            session()->setFlashdata('validasi', ['Tidak berhasil menuju OAuth Page']);
            return redirect()->to(base_url('akreditasi/index'));
        }
    }

    public function upload_to_drive()
    {
        $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'upload checklist')->get()->getRowArray()['uri']));
        $this->parentFolderId = $this->parentFolderId->where('folder', 'checklist')->get()->getRowArray()['folder_id'];
        $code = $this->request->getVar('code');
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);

        $this->googleClient->setAccessToken($token);

        // store in the session also
        session()->set('upload_token', $token);

        $file_name = session()->get('file_name');
        $nomor_apm = session()->get('nomor_apm');
        $area = session()->get('area');
        $nomor_sub_apm = session()->get('nomor_sub_apm');
        $semester = session()->get('semester');
        $tahun = session()->get('tahun');

        $file_path = ROOTPATH . 'public/temp_file/' . $file_name;
        $target_file = base_url('temp_file/' . $file_name);
        $file = new \CodeIgniter\Files\File($file_path);
        $curl = Services::curlrequest();
        $file_content = $curl->request('GET', $target_file);
        $file_content = $file_content->getBody();
        // $file_content = file_get_contents($target_file);
        $mime_type = $file->getMimeType();

        $fileId = '';
        if ($this->googleClient->getAccessToken()) {
            // We'll setup an empty 1MB file to upload.
            if (session()->get('exist') == true) {

                $this->service->files->delete(session()->get('id_file_drive'));
            }
            // This is uploading a file directly, with no metadata associated.
            try {

                $file = new \Google\Service\Drive\DriveFile();
                $file->setName($file_name);
                $file->setParents([$this->parentFolderId]);
                $return = $this->service->files->create(
                    $file,
                    [
                        'data' => $file_content,
                        'mimeType' => $mime_type,
                        'uploadType' => 'multipart'
                    ]
                );
                $fileId = $return['id'];
            } catch (\Exception $e) {
                session()->setFlashdata('validasi', [$e->getMessage()]);
                return redirect()->to(base_url('akreditasi/index'));
            }

            $newPermission = new \Google_Service_Drive_Permission();
            $newPermission->setType('anyone');
            $newPermission->setRole('reader');

            try {
                $this->service->permissions->create($fileId, $newPermission);
                $file_update = $this->service->files->get($fileId, ['fields' => 'webViewLink']);
                // dd($file_update->getWebViewLink());
                if (session()->get('exist') == true) {

                    db_connect()->table('link_apm')->where('id', session()->get('id'))->update(['id_dok' => $fileId, 'link' => $file_update->getWebViewLink()]);
                    $this->client->request('POST', 'http://localhost/akreditasi/public/apiakreditasi', ['form_params' => ['nomor_apm' => $nomor_apm, 'nomor_sub_apm' => $nomor_sub_apm, 'semester' => $semester, 'tahun' => $tahun, 'id_dok' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]]);
                    session()->setFlashdata('success', 'Berhasil update file');
                    return redirect()->to(base_url('akreditasi/index'));
                } else {
                    db_connect()->table('link_apm')->insert(['area' => $area, 'nomor_apm' => $nomor_apm, 'nomor_sub_apm' => $nomor_sub_apm, 'semester' => $semester, 'tahun' => $tahun, 'id_dok' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]);
                    unlink(ROOTPATH . 'public/temp_file/' . $file_name);
                    $this->client->request('POST', 'http://localhost/akreditasi/public/apiakreditasi', ['form_params' => ['area' => $area, 'nomor_apm' => $nomor_apm, 'nomor_sub_apm' => $nomor_sub_apm, 'semester' => $semester, 'tahun' => $tahun, 'id_dok' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]]);
                    session()->setFlashdata('success', 'Berhasil upload file');
                    return redirect()->to(base_url('akreditasi/index'));
                }
            } catch (\Exception $e) {
                session()->setFlashdata('validasi', [$e->getMessage()]);
                return redirect()->to(base_url('akreditasi/index'));
            }
        }
    }

    public function modal_link()
    {
        $nomor_apm = $this->request->getVar('nomor');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $data_apm = db_connect()->table('link_apm')->where('nomor_apm', $nomor_apm)->where('semester', $semester)->where('tahun', $tahun)->orderBy('nomor_sub_apm')->get()->getResultArray();
        return $this->response->setJSON([view('akreditasi/modal_link', ['data' => $data_apm])]);
    }

    public function modal_preview()
    {

        return $this->response->setJSON([view('akreditasi/modal_preview')]);
    }

    public function preview_checklist()
    {
        if (!$this->validate([

            'semester' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Semester harus diisi',

                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi',

                ]
            ],

        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to(base_url('akreditasi'));
        }
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $data_apm = db_connect()->table('apm')->get()->getResultArray();
        $data_apm_fix = [];
        foreach ($data_apm as $d) {

            $exploded = preg_split('/\d\./', $d['uraian']);
            // dd($exploded);
            $uraian_fix = "";
            foreach ($exploded as $key => $value) {
                if ($key == 0) {
                    if ($value == "") {

                        continue;
                    } else {
                        $uraian_fix .= "- " . $value;
                    }
                }
                $uraian_fix .= $key . ". " . $value . '</br>';
            }

            $data_apm_fix[] = ['id' => $d['id'], 'nomor' => $d['nomor'], 'area' => $d['area'], 'penilaian' => $d['penilaian'], 'bobot' => $d['bobot'], 'area_zi' => $d['area_zi'], 'uraian' => $uraian_fix];
        }
        // dd($data_apm_fix);

        return view('akreditasi/preview_checklist', ['data_apm' => $data_apm_fix, 'semester' => $semester, 'tahun' => $tahun]);
    }

    public function daftar_assesment_internal()
    {
        $data_ass_internal = db_connect()->table('assesment_internal')->get()->getResultArray();
        return view('akreditasi/daftar_assesment_internal', ['data' => $data_ass_internal]);
    }

    public function modal_upload_internal()
    {
        $id = $this->request->getVar('id');
        $data_internal = db_connect()->table('assesment_internal')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('akreditasi/modal_upload_internal', ['data' => $data_internal])]);
    }

    public function upload_ass_internal()
    {
        if (!$this->validate([

            'semester' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Semester harus diisi',

                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi',

                ]
            ],
            'file_internal' => [
                'rules' => 'uploaded[file_internal]|ext_in[file_internal,pdf]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File salah',

                ]
            ],

        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to(base_url('akreditasi/daftar_assesment_internal'));
        }


        $file_internal = $this->request->getFile('file_internal');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $file_name = $semester . "-" . $tahun . "." . $file_internal->guessExtension();
        $data_exist = db_connect()->table('assesment_internal')->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();
        if ($data_exist) {
            session()->set('id_file_internal', $data_exist['file_id']);

            session()->set('id', $data_exist['id']);
            session()->set('exist', true);
        } else {
            session()->set('exist', false);
        }
        session()->set('tahun', $tahun);

        session()->set('semester', $semester);
        session()->set('file_name', $file_name);

        if ($file_internal->move('temp_file', $file_name)) {
            $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'upload ass internal')->get()->getRowArray()['uri']));
            return redirect()->to($this->googleClient->createAuthUrl());
        } else {
            session()->setFlashdata('validasi', ['Tidak berhasil menuju OAuth Page']);
            return redirect()->to(base_url('akreditasi'));
        }
    }

    public function upload_internal_drive()
    {
        $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'upload ass internal')->get()->getRowArray()['uri']));
        $this->parentFolderId = $this->parentFolderId->where('folder', 'ass_internal')->get()->getRowArray()['folder_id'];
        $code = $this->request->getVar('code');
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);

        $this->googleClient->setAccessToken($token);

        // store in the session also
        session()->set('upload_token', $token);

        $file_name = session()->get('file_name');

        $semester = session()->get('semester');
        $tahun = session()->get('tahun');

        $file_path = ROOTPATH . 'public/temp_file/' . $file_name;
        $target_file = base_url('temp_file/' . $file_name);
        $file = new \CodeIgniter\Files\File($file_path);
        $curl = Services::curlrequest();
        $file_content = $curl->request('GET', $target_file);
        $file_content = $file_content->getBody();
        // $file_content = file_get_contents($target_file);
        $mime_type = $file->getMimeType();

        $fileId = '';
        if ($this->googleClient->getAccessToken()) {
            // We'll setup an empty 1MB file to upload.
            if (session()->get('exist') == true) {

                $this->service->files->delete(session()->get('id_file_internal'));
            }
            // This is uploading a file directly, with no metadata associated.
            try {

                $file = new \Google\Service\Drive\DriveFile();
                $file->setName($file_name);
                $file->setParents([$this->parentFolderId]);
                $return = $this->service->files->create(
                    $file,
                    [
                        'data' => $file_content,
                        'mimeType' => $mime_type,
                        'uploadType' => 'multipart'
                    ]
                );
                $fileId = $return['id'];
            } catch (\Exception $e) {
                session()->setFlashdata('validasi', [$e->getMessage()]);
                return redirect()->to(base_url('akreditasi/daftar_assesment_internal'));
            }

            $newPermission = new \Google_Service_Drive_Permission();
            $newPermission->setType('anyone');
            $newPermission->setRole('reader');

            try {
                $this->service->permissions->create($fileId, $newPermission);
                $file_update = $this->service->files->get($fileId, ['fields' => 'webViewLink']);
                // dd($file_update->getWebViewLink());
                if (session()->get('exist') == true) {

                    db_connect()->table('assesment_internal')->where('id', session()->get('id'))->update(['file_id' => $fileId, 'link' => $file_update->getWebViewLink()]);
                    $this->client->request('POST', 'http://localhost/akreditasi/public/apiakreditasi/create_internal', ['form_params' => ['semester' => $semester, 'tahun' => $tahun, 'file_id' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]]);
                    session()->setFlashdata('success', 'Berhasil update file');
                    return redirect()->to(base_url('akreditasi/daftar_assesment_internal'));
                } else {
                    db_connect()->table('assesment_internal')->insert(['semester' => $semester, 'tahun' => $tahun, 'file_id' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]);
                    unlink(ROOTPATH . 'public/temp_file/' . $file_name);
                    $this->client->request('POST', 'http://localhost/akreditasi/public/apiakreditasi/create_internal', ['form_params' => ['semester' => $semester, 'tahun' => $tahun, 'file_id' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]]);
                    session()->setFlashdata('success', 'Berhasil upload file');
                    return redirect()->to(base_url('akreditasi/daftar_assesment_internal'));
                }
            } catch (\Exception $e) {
                session()->setFlashdata('validasi', [$e->getMessage()]);
                return redirect()->to(base_url('akreditasi/daftar_assesment_internal'));
            }
        }
    }

    public function hapus_internal($id = null)
    {
        $data = db_connect()->table('assesment_internal')->where('id', $id)->get()->getRowArray();

        session()->set('id_file_internal', $data['file_id']);

        session()->set('id', $data['id']);

        $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'hapus file internal')->get()->getRowArray()['uri']));
        return redirect()->to($this->googleClient->createAuthUrl());
    }

    public function hapus_internal_drive()
    {
        $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'hapus file internal')->get()->getRowArray()['uri']));

        $code = $this->request->getVar('code');
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
        // dd($token);

        $this->googleClient->setAccessToken($token);

        // store in the session also
        session()->set('upload_token', $token);

        $id_file_internal = session()->get('id_file_internal');

        $id = session()->get('id');


        if ($this->service->files->delete($id_file_internal)) {
            db_connect()->table('assesment_internal')->where('id', $id)->delete();
            $this->client->request('POST', 'http://localhost/akreditasi/public/apiakreditasi/delete_file', ['form_params' => ['id' => $id_file_internal]]);
            session()->setFlashdata('success', 'Berhasil hapus file');
            return redirect()->to(base_url('akreditasi/daftar_assesment_internal'));
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return redirect()->to(base_url('akreditasi/daftar_assesment_internal'));
        }
    }

    public function daftar_assesment_eksternal()
    {
        $data_ass_eksternal = db_connect()->table('assesment_eksternal')->get()->getResultArray();
        return view('akreditasi/daftar_assesment_eksternal', ['data' => $data_ass_eksternal]);
    }

    public function modal_upload_eksternal()
    {
        $id = $this->request->getVar('id');
        $data_eksternal = db_connect()->table('assesment_eksternal')->where('id', $id)->get()->getRowArray();
        return $this->response->setJSON([view('akreditasi/modal_upload_eksternal', ['data' => $data_eksternal])]);
    }

    public function upload_ass_eksternal()
    {
        if (!$this->validate([

            'semester' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Semester harus diisi',

                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun harus diisi',

                ]
            ],
            'file_eksternal' => [
                'rules' => 'uploaded[file_eksternal]|ext_in[file_eksternal,pdf]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File salah',

                ]
            ],

        ])) {
            session()->setFlashdata('validasi', $this->validation->getErrors());
            return redirect()->to(base_url('akreditasi/daftar_assesment_eksternal'));
        }


        $file_eksternal = $this->request->getFile('file_eksternal');
        $semester = $this->request->getVar('semester');
        $tahun = $this->request->getVar('tahun');
        $file_name = $semester . "-" . $tahun . "." . $file_eksternal->guessExtension();
        $data_exist = db_connect()->table('assesment_eksternal')->where('semester', $semester)->where('tahun', $tahun)->get()->getRowArray();
        if ($data_exist) {
            session()->set('id_file_eksternal', $data_exist['file_id']);

            session()->set('id', $data_exist['id']);
            session()->set('exist', true);
        } else {
            session()->set('exist', false);
        }
        session()->set('tahun', $tahun);

        session()->set('semester', $semester);
        session()->set('file_name', $file_name);

        if ($file_eksternal->move('temp_file', $file_name)) {
            $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'upload ass eksternal')->get()->getRowArray()['uri']));
            return redirect()->to($this->googleClient->createAuthUrl());
        } else {
            session()->setFlashdata('validasi', ['Tidak berhasil menuju OAuth Page']);
            return redirect()->to(base_url('akreditasi'));
        }
    }

    public function upload_eksternal_drive()
    {
        $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'upload ass eksternal')->get()->getRowArray()['uri']));
        $this->parentFolderId = $this->parentFolderId->where('folder', 'ass_eksternal')->get()->getRowArray()['folder_id'];
        $code = $this->request->getVar('code');
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);

        $this->googleClient->setAccessToken($token);

        // store in the session also
        session()->set('upload_token', $token);

        $file_name = session()->get('file_name');

        $semester = session()->get('semester');
        $tahun = session()->get('tahun');

        $file_path = ROOTPATH . 'public/temp_file/' . $file_name;
        $target_file = base_url('temp_file/' . $file_name);
        $file = new \CodeIgniter\Files\File($file_path);
        $curl = Services::curlrequest();
        $file_content = $curl->request('GET', $target_file);
        $file_content = $file_content->getBody();
        // $file_content = file_get_contents($target_file);
        $mime_type = $file->getMimeType();

        $fileId = '';
        if ($this->googleClient->getAccessToken()) {
            // We'll setup an empty 1MB file to upload.
            if (session()->get('exist') == true) {

                $this->service->files->delete(session()->get('id_file_eksternal'));
            }
            // This is uploading a file directly, with no metadata associated.
            try {

                $file = new \Google\Service\Drive\DriveFile();
                $file->setName($file_name);
                $file->setParents([$this->parentFolderId]);
                $return = $this->service->files->create(
                    $file,
                    [
                        'data' => $file_content,
                        'mimeType' => $mime_type,
                        'uploadType' => 'multipart'
                    ]
                );
                $fileId = $return['id'];
            } catch (\Exception $e) {
                session()->setFlashdata('validasi', [$e->getMessage()]);
                return redirect()->to(base_url('akreditasi/daftar_assesment_eksternal'));
            }

            $newPermission = new \Google_Service_Drive_Permission();
            $newPermission->setType('anyone');
            $newPermission->setRole('reader');

            try {
                $this->service->permissions->create($fileId, $newPermission);
                $file_update = $this->service->files->get($fileId, ['fields' => 'webViewLink']);
                // dd($file_update->getWebViewLink());
                if (session()->get('exist') == true) {

                    db_connect()->table('assesment_eksternal')->where('id', session()->get('id'))->update(['file_id' => $fileId, 'link' => $file_update->getWebViewLink()]);
                    $this->client->request('POST', 'http://localhost/akreditasi/public/apiakreditasi/create_eksternal', ['form_params' => ['semester' => $semester, 'tahun' => $tahun, 'file_id' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]]);
                    session()->setFlashdata('success', 'Berhasil update file');
                    return redirect()->to(base_url('akreditasi/daftar_assesment_eksternal'));
                } else {
                    db_connect()->table('assesment_eksternal')->insert(['semester' => $semester, 'tahun' => $tahun, 'file_id' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]);
                    unlink(ROOTPATH . 'public/temp_file/' . $file_name);
                    $this->client->request('POST', 'http://localhost/akreditasi/public/apiakreditasi/create_eksternal', ['form_params' => ['semester' => $semester, 'tahun' => $tahun, 'file_id' => $fileId, 'link' => $file_update->getWebViewLink(), 'nama_file' => $file_name]]);
                    session()->setFlashdata('success', 'Berhasil upload file');
                    return redirect()->to(base_url('akreditasi/daftar_assesment_eksternal'));
                }
            } catch (\Exception $e) {
                session()->setFlashdata('validasi', [$e->getMessage()]);
                return redirect()->to(base_url('akreditasi/daftar_assesment_eksternal'));
            }
        }
    }

    public function hapus_eksternal($id = null)
    {
        $data = db_connect()->table('assesment_eksternal')->where('id', $id)->get()->getRowArray();

        session()->set('id_file_eksternal', $data['file_id']);

        session()->set('id', $data['id']);

        $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'hapus file eksternal')->get()->getRowArray()['uri']));
        return redirect()->to($this->googleClient->createAuthUrl());
    }

    public function hapus_eksternal_drive()
    {
        $this->googleClient->setRedirectUri(base_url($this->data_redirect_uri->where('method', 'hapus file eksternal')->get()->getRowArray()['uri']));

        $code = $this->request->getVar('code');
        $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
        // dd($token);

        $this->googleClient->setAccessToken($token);

        // store in the session also
        session()->set('upload_token', $token);

        $id_file_eksternal = session()->get('id_file_eksternal');

        $id = session()->get('id');


        if ($this->service->files->delete($id_file_eksternal)) {
            db_connect()->table('assesment_eksternal')->where('id', $id)->delete();
            $this->client->request('POST', 'http://localhost/akreditasi/public/apiakreditasi/delete_file', ['form_params' => ['id' => $id_file_eksternal]]);
            session()->setFlashdata('success', 'Berhasil hapus file');
            return redirect()->to(base_url('akreditasi/daftar_assesment_eksternal'));
        } else {
            session()->setFlashdata('validasi', ['Data gagal dihapus']);
            return redirect()->to(base_url('akreditasi/daftar_assesment_eksternal'));
        }
    }

    public function import_checklist()
    {
        return view('akreditasi/v_import_checklist');
    }

    // 2022
    // public function import_checklist_db()
    // {
    //     $file = $this->request->getFile('file_checklist');
    //     $file_name = "checklist_" . time() . "." . $file->guessExtension();
    //     $file->move('raw_file', $file_name);
    //     # Create a new Xls Reader
    //     $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    //     // Tell the reader to only read the data. Ignore formatting etc.
    //     $reader->setReadDataOnly(true);

    //     // Read the spreadsheet file.
    //     // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
    //     $spreadsheet = $reader->load(ROOTPATH . 'public/raw_file/' . $file_name);

    //     $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
    //     $data = $sheet->toArray();
    //     dd($data);
    //     db_connect()->table('apm')->truncate();
    //     // dd($data);
    //     $jml_data = 0;
    //     foreach ($data as $key => $value) {
    //         if ($key == 0) {
    //             continue;
    //         }

    //         $data_insert = [
    //             'nomor' => $value[0],
    //             'area' => $value[1],
    //             'penilaian' => $value[2],
    //             'uraian' => $value[3],
    //             'area_zi' => $value[4],
    //             'bobot' => $value[5],
    //             'jumlah_sub' => $value[6]
    //         ];

    //         db_connect()->table('apm')->insert($data_insert);
    //         $jml_data++;
    //     }

    //     if (db_connect()->affectedRows()) {
    //         session()->setFlashdata('success', 'Berhasil import');
    //         return redirect()->to(base_url('akreditasi/import_checklist'));
    //     } else {
    //         session()->setFlashdata('validasi', ['Gagal import']);
    //         return redirect()->to(base_url('akreditasi/import_checklist'));
    //     }
    // }


    // 2023
    public function import_checklist_db()
    {
        $file = $this->request->getFile('file_checklist');
        $file_name = "checklist_" . time() . "." . $file->guessExtension();
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

        db_connect()->table('apm_2023')->truncate();
        // dd($data);
        $jml_data = 0;
        foreach ($data as $key => $value) {
            if ($key == 0) {
                continue;
            }

            $data_insert = [
                'nomor' => $value[0],

                'penilaian' => $value[1],
                'uraian' => $value[2],
                'kriteria' => $value[3],
                'lokasi' => $value[4],
                'bobot' => $value[5]
            ];

            db_connect()->table('apm_2023')->insert($data_insert);
            $jml_data++;
        }

        if (db_connect()->affectedRows()) {
            session()->setFlashdata('success', 'Berhasil import');
            return redirect()->to(base_url('akreditasi/import_checklist'));
        } else {
            session()->setFlashdata('validasi', ['Gagal import']);
            return redirect()->to(base_url('akreditasi/import_checklist'));
        }
    }

    public function download_format_checklist()
    {
        return $this->response->download('/raw_file/checklist.xlsx', null);
    }
}
