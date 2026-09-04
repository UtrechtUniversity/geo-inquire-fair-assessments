<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FairAssessmentGroup extends Model
{
    protected $fillable = [
        'name',
        'fair_assessment_group_list_id'
    ];

    public function fair_assessment_group_list()
    {
        return $this->belongsTo(FairAssessmentGroupList::class);
    }

    public function fair_assessment_objects()
    {
        return $this->belongsToMany(FairAssessmentObject::class, 'fair_asessment_group_object');
    }
}
