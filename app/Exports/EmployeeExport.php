<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeeExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    //function will define the heading, which would be displayed in an excel file
    public function headings():array{
        return[
            'id',
            'first_name',
            'last_name',
            'hiringDate',
        ];
    }
    //function will return the data which we have to export
    public function collection()
    {
        return Employee::all();
    }
}
