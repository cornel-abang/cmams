<?php

namespace App\Imports;

use App\VLCLookup;
use Maatwebsite\Excel\Concerns\ToModel;

class VlcLookUp implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new VLCLookup([
            //
        ]);
    }
}
