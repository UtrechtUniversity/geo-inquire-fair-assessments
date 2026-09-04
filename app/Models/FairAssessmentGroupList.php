<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FairAssessmentGroupList extends Model
{
    protected $fillable = [
        'name',
        'version',
        'description'
    ];

    public function fair_assessment_groups()
    {
        return $this->hasMany(FairAssessmentGroup::class);
    }

    public function fair_asessment_batches()
    {
        return $this->hasMany(FairAssessmentBatch::class);
    }

    public function fair_assessment_objects()
    {
        return $this->hasManyThrough(FairAssessmentObject::class, FairAssessmentGroup::class);
    }
}
