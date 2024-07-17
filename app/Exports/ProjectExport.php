<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectExport implements FromView, WithEvents
{
    use RegistersEventListeners;
    private $status;
    private $semester;
    private $text;
    private $rows;

    public function __construct($status, $semester, $text) {
        $this->status = $status;
        $this->semester = $semester;
        $this->text = $text;
        $this->rows = 0;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        // dd($this->status);
        $model = Project::with('category', 'major', 'projectUsers', 'lecture')
                ->status($this->status)
                ->semester($this->semester)
                ->get();
        $this->rows = $model->count();

        $data['excel'] = $model;
        $data['statusText'] = $this->text;

        return view('backsite.project.export', $data);
    }

    public static function afterSheet(AfterSheet $event)
    {
        $defaultFontStyle = [
            'font' => ['name' => 'Arial', 'size' => 10]
        ];

        $strikethrough = [
            'font' => ['strikethrough' => true],
        ];

        $bold = [
            'font' => ['bold' => true],
        ];

        $activeSheet = $event->sheet->getDelegate();
        $activeSheet->getRowDimension('1')->setRowHeight(40);
        $activeSheet->mergeCells('A1:F1');

        
        $activeSheet->getStyle('A1:F1')
            ->applyFromArray($bold)
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);

        $event->sheet->getStyle('A2:F'.$event->sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $activeSheet->getParent()->getDefaultStyle()->applyFromArray($defaultFontStyle);
        
        $activeSheet->getStyle('A1:F1')->applyFromArray($bold)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $activeSheet->getStyle('A2:F2')->applyFromArray($bold);
    }
}
