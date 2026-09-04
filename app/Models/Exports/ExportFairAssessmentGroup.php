<?php

namespace App\Models\Exports;

use Illuminate\Database\Eloquent\Model;

class ExportFairAssessmentGroup extends Model
{

    public function export_fair_assessment_group_list()
    {
        return $this->belongsTo(ExportFairAssessmentGroupList::class, 'fair_assessment_group_list_id');
    }

    public function export_fair_assessment_objects()
    {
        return $this->belongsToMany(ExportFairAssessmentObject::class, 'export_fair_assessment_group_object', 'fair_assessment_group_id', 'fair_assessment_object_id');
    }
}
