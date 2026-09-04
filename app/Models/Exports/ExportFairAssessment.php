<?php

namespace App\Models\Exports;

use Illuminate\Database\Eloquent\Model;

class ExportFairAssessment extends Model
{

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

    public function export_fair_assessment_batch() 
    {
        return $this->belongsTo(ExportFairAssessmentBatch::class, 'fair_assessment_batch_id');
    }

    public function export_fair_assessment_object()
    {
        return $this->belongsTo(ExportFairAssessmentObject::class, 'fair_assessment_object_id');
    }
}
