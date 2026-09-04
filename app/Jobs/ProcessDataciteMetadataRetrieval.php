<?php

namespace App\Jobs;

use App\Datacite\Datacite;
use App\Models\FairAssessmentObject;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessDataciteMetadataRetrieval implements ShouldQueue
{
    use Queueable;

    protected FairAssessmentObject $object;

    /**
     * Create a new job instance.
     */
    public function __construct(FairAssessmentObject $fairAssessmentObject)
    {
        $this->object = $fairAssessmentObject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $dataciteClient =  new Datacite;

        $result = $dataciteClient->doisRequest($this->object->pid);

        if($result->response_code == 200) {
            $this->object->datacite_metadata = $result->response_body;

            // set publisher
            $this->object->datacite_publisher = $result->response_body['data']['attributes']['publisher'];
            $this->object->save();
        }
    }
}
