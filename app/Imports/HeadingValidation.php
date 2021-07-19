<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;

class HeadingValidation implements OnEachRow
{
    private $rows = 0;

    public function startRow(): int
    {
        return 3;
    }

    // public function model(array $row)
    // {
    //     ++$this->rows;
    // }
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if($rowIndex == 4){
            if($row[0]=="Patient ID #"){
                ++$this->rows;
            }
        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
