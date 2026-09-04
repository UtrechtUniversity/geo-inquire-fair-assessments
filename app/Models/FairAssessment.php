<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FairAssessment extends Model
{
    protected $fillable = [
        'fair_assessment_batch_id',
        'fair_assessment_object_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'response_full' => 'array',
        ];
    }
        
    public function getResponseBodyAsJson($pretty = false)
    {
        if($pretty) {
            return json_encode(json_decode($this->response_full), JSON_PRETTY_PRINT);
        } else {
            return json_encode(json_decode($this->response_full));
        }
    }

    public function fair_assessment_batch() 
    {
        return $this->belongsTo(FairAssessmentBatch::class);
    }

    public function fair_assessment_object()
    {
        return $this->belongsTo(FairAssessmentObject::class);
    }
}
