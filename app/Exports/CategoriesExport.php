<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\CategoryName;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CategoriesExport implements FromCollection, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CategoryName::orderBy('category_name', 'asc')->get(['category_name']);
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            '',
        ];
    }

}
