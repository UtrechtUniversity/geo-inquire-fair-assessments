<?php

namespace App\Exports\Sheets;

use App\Models\Exports\ExportFairAssessmentGroupList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelSheetResultsBatch implements FromCollection, WithTitle, WithHeadings, WithStrictNullComparison, ShouldAutoSize
{
    public ExportFairAssessmentGroupList $list;

    public int $measurementBatch;

    public function __construct($list, $batch)
    {
        $this->list = $list;
        $this->measurementBatch = $batch;
    }

    public function collection()
    {
        $groups = $this->list->export_fair_assessment_groups;
        $data = [];
                
        foreach($groups as $group) {
            $objects = $group->export_fair_assessment_objects;
            foreach($objects as $object) {                
                $measurement = $object->export_fair_assessments->where('measurement_grouped_batch', $this->measurementBatch)->first();
                if($measurement) {
                    $row = [];

                    $row['identifier'] = $group->name;
                    $row['doi'] = $object->pid;
                    $row['score total'] = $measurement->score_percent;
                    $row['F'] = $measurement->score_F;
                    $row['F1'] = $measurement->score_F1;
                    $row['F2'] = $measurement->score_F2;
                    $row['F3'] = $measurement->score_F3;
                    $row['F4'] = $measurement->score_F4;
                    $row['A'] = $measurement->score_A;
                    $row['A1'] = $measurement->score_A1;
                    $row['I'] = $measurement->score_I;
                    $row['I1'] = $measurement->score_I1;
                    $row['I2'] = $measurement->score_I2;
                    $row['I3'] = $measurement->score_I3;
                    $row['R'] = $measurement->score_R;
                    $row['R1'] = $measurement->score_R1;
                    $row['R1_1'] = $measurement->score_R1_1;
                    $row['R1_2'] = $measurement->score_R1_2;
                    $row['R1_3'] = $measurement->score_R1_3; 

                    $data[] = $row;
                }
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
            'score total',
            'F',
            'F1',
            'F2',
            'F3',
            'F4',
            'A',
            'A1',
            'I',
            'I1',
            'I2',
            'I3',
            'R',
            'R1',
            'R1_1',
            'R1_2',
            'R1_3'
        ];
    }

    public function title(): string
    {
        return 'measurement-'.$this->measurementBatch;
    }
}