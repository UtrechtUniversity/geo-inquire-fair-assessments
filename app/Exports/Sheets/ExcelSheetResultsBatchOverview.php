<?php

namespace App\Exports\Sheets;

use App\Models\Exports\ExportFairAssessmentGroupList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelSheetResultsBatchOverview implements FromCollection, WithTitle, WithHeadings, WithStrictNullComparison, ShouldAutoSize
{
    public ExportFairAssessmentGroupList $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    public function collection()
    {
        $groups = $this->list->export_fair_assessment_groups;
        $data = [];
                
        foreach($groups as $group) {
            $objects = $group->export_fair_assessment_objects;
            foreach($objects as $object) {
                
                $measurement1 = $object->export_fair_assessments->where('measurement_grouped_batch', 1)->first();
                $measurement2 = $object->export_fair_assessments->where('measurement_grouped_batch', 2)->first();
                $measurement3 = $object->export_fair_assessments->where('measurement_grouped_batch', 3)->first();
                $row = [];

                $row['identifier'] = $group->name;
                $row['doi'] = $object->pid;
                $row['score total measurement 1'] = null;
                $row['score total measurement 2'] = null;
                $row['score total measurement 3'] = null;

                if($measurement1) {
                    $row['score total measurement 1'] = $measurement1->score_percent;
                }

                if($measurement2) {
                    $row['score total measurement 2'] = $measurement2->score_percent;
                }

                if($measurement3) {
                    $row['score total measurement 3'] = $measurement3->score_percent;
                }

                $data[] = $row;
            }
        }
        
        $collection = collect($data);

        return $collection;
    }

    public function headings(): array
    {
        return [
            'identifier',
            'doi',
            'score total measurement 1',
            'score total measurement 2',
            'score total measurement 3',
        ];
    }

    public function title(): string
    {
        return 'overview';
    }
}