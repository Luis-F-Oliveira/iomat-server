<?php

namespace App\Imports;

use App\Models\Servant;
use Maatwebsite\Excel\Concerns\ToModel;

class ServantsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Servant([
            'enrollment' => $row[0],
            'contract' => $row[1],
            'name' => $row[2],
            'email' => $row[3]
        ]);
    }
}
