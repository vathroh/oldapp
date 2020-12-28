<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\personnel_evaluation_value;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class rekapEvkinjaExport implements FromCollection, WithHeadings
{
    protected $values;

    public function __construct($values) {
		    $this->values = $values;
	  }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        foreach($this->values as $key=>$value)
        {
            $array[$key] = collect([
                [
                    'no'        => $key+1,
                    'nama'      => $value->user()->first()->name,
                    'posisi'    => $value->user()->first()->posisi()->first()->job_title,
                    'kabupaten' => $value->jobDesc()->first()->kabupaten()->first()->NAMA_KAB,
                    'status'    => $value->finalResult,
                    'score'     => $value->totalScore
                 ]
            ]); 
        }   

        return $collection = collect($array);    
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Jabatan',
            'Kabupaten/Kota',
            'Kinerja',
            'Nilai',
        ];
    }
}
