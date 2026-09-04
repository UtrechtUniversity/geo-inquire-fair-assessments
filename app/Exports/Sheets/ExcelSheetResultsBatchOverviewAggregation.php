<?php

namespace App\Exports\Sheets;

use App\Models\Exports\ExportFairAssessmentGroupList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelSheetResultsBatchOverviewAggregation implements FromCollection, WithTitle, WithHeadings, WithStrictNullComparison, ShouldAutoSize
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
        $results = [];
                
        foreach($groups as $group) {
            $objects = $group->export_fair_assessment_objects;
            foreach($objects as $object) {
                $measurement1 = $object->export_fair_assessments->where('measurement_grouped_batch', 1)->first();
                $measurement2 = $object->export_fair_assessments->where('measurement_grouped_batch', 3)->first();

                if($measurement1 && $measurement2) {
                    if(isset($results[$group->name])) {
                        $results[$group->name] = $results[$group->name] + ($measurement2->score_percent - $measurement1->score_percent);
                    } else {
                        $results[$group->name] = $measurement2->score_percent - $measurement1->score_percent;
                    }                        
                }
            }
        }

        foreach($results as $key => $value) {
            $row = [];
            $row['installation'] = $key;
            $row['change'] = $value;
            $data[] = $row;
        }        
        
        $collection = collect($data);

        return $collection;
    }

    public function headings(): array
    {
        return [
            'installation',
            'change',
        ];
    }

    public function title(): string
    {
        return 'aggregation';
    }
}