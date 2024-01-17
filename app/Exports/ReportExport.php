<?php

namespace App\Exports;

use App\Models\QueryReport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return QueryReport::all();
    // }
    protected $data;

    function __construct($data) {
        $this->data = $data;
    }


    public function view(): View
    {
        return view('reportes.excel', [
            'reportes' => $this->data
        ]);
    }
}
