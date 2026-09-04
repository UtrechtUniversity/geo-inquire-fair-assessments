<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FairAssessmentBatch extends Model
{
    protected $fillable = [
        'fair_assessment_group_list_id'
    ];

    public function fair_assessment_group_list()
    {
        return $this->belongsTo(FairAssessmentGroupList::class);
    }

    public function fair_assessments()
    {
        return $this->hasMany(FairAssessment::class);
    }
}
