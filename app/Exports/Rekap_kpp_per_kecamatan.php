<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class Rekap_kpp_per_kecamatan implements FromCollection
{

    protected $kppdatas;

	public function __construct($kppdatas) {
		$this->kppdatas = $kppdatas;
	}
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return $this->kppdatas;   
    }
}
