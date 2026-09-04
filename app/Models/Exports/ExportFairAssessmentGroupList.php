<?php

namespace App\Models\Exports;

use Illuminate\Database\Eloquent\Model;

class ExportFairAssessmentGroupList extends Model
{

    public function export_fair_assessment_groups()
    {
        return $this->hasMany(ExportFairAssessmentGroup::class, 'fair_assessment_group_list_id');
    }

    public function export_fair_asessment_batches()
    {
        return $this->hasMany(ExportFairAssessmentBatch::class, 'fair_assessment_group_list_id');
    }

    public function export_fair_assessment_objects()
    {
        return $this->hasManyThrough(ExportFairAssessmentObject::class, ExportFairAssessmentGroup::class, 'fair_assessment_object_id', 'fair_assessment_group_id');
    }
}
