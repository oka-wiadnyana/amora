<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Administrator extends BaseController
{
    public function index()
    {
        //
    }

    public function upload_excel_akreditasi()
    {
        # Create a new Xls Reader
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
        $spreadsheet = $reader->load(ROOTPATH . 'public/raw_file/ceklist.xlsx');

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        // dd($data);

        foreach ($data as $key => $value) {
            if ($key == 0) {
                continue;
            }

            $data_insert = [
                'nomor' => $value[0],
                'area' => $value[1],
                'penilaian' => $value[2],
                'uraian' => $value[3],
                'area_zi' => $value[4],
                'bobot' => $value[5],
                'jumlah_sub' => $value[6]
            ];
            db_connect()->table('apm')->insert($data_insert);
        }

        echo 'Data Finish';
    }

    public function upload_excel_mis()
    {
        # Create a new Xls Reader
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        // Tell the reader to only read the data. Ignore formatting etc.
        $reader->setReadDataOnly(true);

        // Read the spreadsheet file.
        // $spreadsheet = $reader->load(base_url('raw_file/ceklist.xlsx'));
        $spreadsheet = $reader->load(ROOTPATH . 'public/raw_file/mis.xlsx');

        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        // dd($data);
        db_connect()->table('mis')->truncate();

        foreach ($data as $key => $value) {
            if ($key == 0) {
                continue;
            }

            $data_insert = [
                'uraian' => $value[0],

            ];
            db_connect()->table('mis')->insert($data_insert);
        }

        echo 'Data Finish';
    }
}
