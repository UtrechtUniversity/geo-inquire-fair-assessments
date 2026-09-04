<?php

namespace App\Models\Exports;

use Illuminate\Database\Eloquent\Model;

class ExportFairAssessmentObject extends Model
{

    /*
    public function export_fair_assessment_group()
    {
        return $this->belongsToMany(ExportFairAssessmentGroup::class, 'export_fair_assessment_group_object');
    }
    */

    public function export_fair_assessments()
    {
        return $this->hasMany(ExportFairAssessment::class, 'fair_assessment_object_id');
    }
}
