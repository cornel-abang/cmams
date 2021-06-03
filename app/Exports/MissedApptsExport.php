<?php

namespace App\Exports;

use App\MissedAppt;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MissedApptsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MissedAppt::where('appt_date', Carbon::yesterday())->where('appt_type', 'Refill')->get();
    }

    public function headings(): array
    {
        return [
            'Case Manageer',
            'Client Hospital Num',
            'Refill Due Date',
        ];
    }
}
