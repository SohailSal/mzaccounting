<?php

namespace App\Exports;

use App\Entry;
use Maatwebsite\Excel\Concerns\FromCollection;

class EntryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Entry::all();
    }
}
