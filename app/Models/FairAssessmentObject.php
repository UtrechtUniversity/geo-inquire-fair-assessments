<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FairAssessmentObject extends Model
{
    protected $fillable = [
        'pid',
        'datacite_metadata',
        'datacite_publisher'
    ];

    public function fair_assessment_group()
    {
        return $this->belongsToMany(FairAssessmentGroup::class, 'fair_asessment_group_object');
    }

    public function fair_assessments()
    {
        return $this->hasMany(FairAssessment::class);
    }
}
