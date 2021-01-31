<?php

namespace App\Imports;

use App\Manager;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ManagerUpdateImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(collection $rows)
    {
        foreach ($rows as $row) {
            $manager = Manager::where('names', 'like', '%'.$row['case_manager'].'%')
                                ->orWhereRaw("CONCAT_WS(' ', 'names', 'surname') like ?", '%'.$row['case_manager'].'%')
                                ->first();
                // dd($manager);
            if ($manager) {
                $manager->facility = $row['facility'];
                $manager->save();
            }
        }
    }
}
