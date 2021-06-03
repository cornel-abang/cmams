<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class SentExport implements FromCollection
{
   public $data;

	public function  __construct($data)
    {	
        $this->data = collect($data);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {	
    	$resData = [];
    	foreach ($this->data as $data) {
        	array_push($resData, [
	        	'Facility'    => $data->facility,
	        	'Hospital_No' => $data->hospital_num,
	        	'Result'	  => $data->result
        	]);
    	}

    	return collect($resData);
    }

    public function headings(): array
    {
        return [
            'Facility',
            'Hospital No.',
            'Result'
        ];
    }
}
