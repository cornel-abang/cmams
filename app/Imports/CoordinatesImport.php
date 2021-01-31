<?php

namespace App\Imports;

use App\Coordinate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CoordinatesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $coord = new Coordinate;
        $coord->facility = $row['facility_nameimplementing_agent'];
        $coord->longitude = $row['longitude'];
        $coord->latitude = $row['latitude'];
        $coord->save();
    }
}
