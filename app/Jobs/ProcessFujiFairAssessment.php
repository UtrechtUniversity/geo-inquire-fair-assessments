<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\fuji\FujiClient;
use App\Models\FairAssessment;

class ProcessFujiFairAssessment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $fujiFairAssessment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FairAssessment $fujiFairAssessment)
    {
        $this->fujiFairAssessment = $fujiFairAssessment;                
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()    
    {        
        $fuji =  new FujiClient();
        
        $result = $fuji->evaluateRequest($this->fujiFairAssessment->fair_assessment_object->pid);
        
        $this->fujiFairAssessment->processed = true;
        $this->fujiFairAssessment->response_code = $result->response_code;
        $this->fujiFairAssessment->response_full = $result->response_body;
        if(isset($result->response_body['summary']['score_percent']['FAIR'])) {
            $this->fujiFairAssessment->score_percent = $result->response_body['summary']['score_percent']['FAIR'];
        }
        
                
        if(isset($result->response_body['summary']['score_percent']['F'])) {
            $this->fujiFairAssessment->score_F = $result->response_body['summary']['score_percent']['F'];
        }
        if(isset($result->response_body['summary']['score_percent']['F1'])) {
            $this->fujiFairAssessment->score_F1 = $result->response_body['summary']['score_percent']['F1'];
        }
        if(isset($result->response_body['summary']['score_percent']['F2'])) {
            $this->fujiFairAssessment->score_F2 = $result->response_body['summary']['score_percent']['F2'];
        }
        if(isset($result->response_body['summary']['score_percent']['F3'])) {
            $this->fujiFairAssessment->score_F3 = $result->response_body['summary']['score_percent']['F3'];
        }
        if(isset($result->response_body['summary']['score_percent']['F4'])) {
            $this->fujiFairAssessment->score_F4 = $result->response_body['summary']['score_percent']['F4'];
        }
        
        if(isset($result->response_body['summary']['score_percent']['A'])) {
            $this->fujiFairAssessment->score_A = $result->response_body['summary']['score_percent']['A'];
        }
        if(isset($result->response_body['summary']['score_percent']['A1'])) {
            $this->fujiFairAssessment->score_A1 = $result->response_body['summary']['score_percent']['A1'];
        }
        if(isset($result->response_body['summary']['score_percent']['A2'])) {
            $this->fujiFairAssessment->score_A2 = $result->response_body['summary']['score_percent']['A2'];
        }
        
        if(isset($result->response_body['summary']['score_percent']['I'])) {
            $this->fujiFairAssessment->score_I = $result->response_body['summary']['score_percent']['I'];
        }
        if(isset($result->response_body['summary']['score_percent']['I1'])) {
            $this->fujiFairAssessment->score_I1 = $result->response_body['summary']['score_percent']['I1'];
        }
        if(isset($result->response_body['summary']['score_percent']['I2'])) {
            $this->fujiFairAssessment->score_I2 = $result->response_body['summary']['score_percent']['I2'];
        }
        if(isset($result->response_body['summary']['score_percent']['I3'])) {
            $this->fujiFairAssessment->score_I3 = $result->response_body['summary']['score_percent']['I3'];
        }
        
        if(isset($result->response_body['summary']['score_percent']['R'])) {
            $this->fujiFairAssessment->score_R = $result->response_body['summary']['score_percent']['R'];
        }
        if(isset($result->response_body['summary']['score_percent']['R1'])) {
            $this->fujiFairAssessment->score_R1 = $result->response_body['summary']['score_percent']['R1'];
        }
        if(isset($result->response_body['summary']['score_percent']['I'])) {
            $this->fujiFairAssessment->score_R1_1 = $result->response_body['summary']['score_percent']['R1.1'];
        }
        if(isset($result->response_body['summary']['score_percent']['I'])) {
            $this->fujiFairAssessment->score_R1_2 = $result->response_body['summary']['score_percent']['R1.2'];
        }
        if(isset($result->response_body['summary']['score_percent']['I'])) {
            $this->fujiFairAssessment->score_R1_3 = $result->response_body['summary']['score_percent']['R1.3'];
        }

        if(isset($result->response_body['software_version'])) {
            $this->fujiFairAssessment->software_version = $result->response_body['software_version'];
        }
        if(isset($result->response_body['metric_specification'])) {
            $this->fujiFairAssessment->metric_specification = $result->response_body['metric_specification'];
        }
        
        $this->fujiFairAssessment->save();
    }    
}