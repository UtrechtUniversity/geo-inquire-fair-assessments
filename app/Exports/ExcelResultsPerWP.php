<?php

namespace App\Exports;

use App\Models\FairAssessmentGroupList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExcelResultsPerWP implements FromCollection, WithHeadings, WithStrictNullComparison
{
    public FairAssessmentGroupList $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $groups = $this->list->fair_assessment_groups;
        $data = [];

        foreach($groups as $group) {
            $objects = $group->fair_assessment_objects;
            foreach($objects as $object) {
                $latestAssessment = $object->fair_assessments()->orderBy('fair_assessment_batch_id', 'desc')->first();
                
                $row = [];
                $row['identifier'] = $group->name;
                $row['doi'] = $object->pid;
                $row['score total'] = $latestAssessment->score_percent;
                $row['F'] = $latestAssessment->score_F;
                $row['F1'] = $latestAssessment->score_F1;
                $row['F2'] = $latestAssessment->score_F2;
                $row['F3'] = $latestAssessment->score_F3;
                $row['F4'] = $latestAssessment->score_F4;
                $row['A'] = $latestAssessment->score_A;
                $row['A1'] = $latestAssessment->score_A1;
                $row['I'] = $latestAssessment->score_I;
                $row['I1'] = $latestAssessment->score_I1;
                $row['I2'] = $latestAssessment->score_I2;
                $row['I3'] = $latestAssessment->score_I3;
                $row['R'] = $latestAssessment->score_R;
                $row['R1'] = $latestAssessment->score_R1;
                $row['R1_1'] = $latestAssessment->score_R1_1;
                $row['R1_2'] = $latestAssessment->score_R1_2;
                $row['R1_3'] = $latestAssessment->score_R1_3;                

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
}
