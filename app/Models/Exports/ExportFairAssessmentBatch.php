<?php

namespace App\Models\Exports;

use Illuminate\Database\Eloquent\Model;

class ExportFairAssessmentBatch extends Model
{
    protected $fillable = [
        'fair_assessment_group_list_id'
    ];

    public function export_fair_assessment_group_list()
    {
        return $this->belongsTo(ExportFairAssessmentGroupList::class, 'fair_assessment_group_list_id');
    }

    public function export_fair_assessments()
    {
        return $this->hasMany(ExportFairAssessment::class, 'fair_assessment_batch_id');
    }
}
