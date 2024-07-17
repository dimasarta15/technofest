<?php

namespace App\Exports;

use App\Models\FormCustom;
use App\Models\FormResponse;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuizionerExport implements FromView, WithEvents
{
    use RegistersEventListeners;
    private $semester;
    private $rows;

    public function __construct($semester) {
        $this->semester = $semester;
        $this->rows = 0;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        // dd($this->status);
        
        
        $model = FormCustom::where('semester_id', $this->semester->id)->orderBy('id', 'asc')->get();

        $responses =  FormResponse::with('formCustom')->whereHas('formCustom', function($q) {
            $q->where('semester_id', $this->semester->id);
        })->get()->groupBy('created_at');
/* 
        $arr = [];
        foreach ($model as $key => $md) {
            dd($responses->toArray());
            $arr[] = [
                'qt' => $md->id,
                'rs' => $responses->where('form_custom_id', $md->id)
            ];
        } */
        
        // $this->rows = $model->count();

        $data['excel'] = $model;
        $data['responses'] = array_values($responses->toArray());
        $data['semester'] = $this->semester;

        return view('backsite.quizioner.export', $data);
    }

  /*   public static function afterSheet(AfterSheet $event)
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
    } */
}
