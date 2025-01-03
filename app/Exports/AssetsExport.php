<?php

namespace App\Exports;

use App\Models\Asset;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetsExport implements FromView, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $assets;

    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function view(): View
    {
        return view('exports.assets', [
            'assets' => $this->assets
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Set background warna untuk header
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid']],
        ];
    }
}
