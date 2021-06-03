<?php

namespace App\Exports;

use App\MetAppt;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MetApptsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MetAppt::where('due_date', Carbon::yesterday())->get();
    }

    public function headings(): array
    {
        return [
            'Case Manageer',
            'Client Hospital Num',
            'Refill Due Date',
            'Date Returned',
            'Facility',
        ];
    }
}
