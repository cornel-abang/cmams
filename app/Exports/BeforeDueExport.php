<?php

namespace App\Exports;

use App\BeforeDue;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BeforeDueExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	return BeforeDue::where('due_date', Carbon::yesterday())
                            ->where('returned_date', '<', Carbon::yesterday())
                            ->get();
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
