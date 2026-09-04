<?php

namespace Database\Seeders;

use App\Models\FairAssessment;
use App\Models\FairAssessmentBatch;
use App\Models\FairAssessmentGroup;
use App\Models\FairAssessmentGroupList;
use App\Models\FairAssessmentObject;
use Illuminate\Database\Seeder;


class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FairAssessment::truncate();
        FairAssessmentBatch::truncate();
        FairAssessmentGroupList::truncate();
        FairAssessmentGroup::truncate();
        FairAssessmentObject::truncate();

        $this->addFromFile('WP2-AD03', 'database/seeders/initialdata/WP2-AD03.json');
        $this->addFromFile('WP2-ND03', 'database/seeders/initialdata/WP2-ND03.json');
        $this->addFromFile('WP3-AD03', 'database/seeders/initialdata/WP3-AD03.json');
        $this->addFromFile('WP3-ND03', 'database/seeders/initialdata/WP3-ND03.json');
        $this->addFromFile('WP4-AD03', 'database/seeders/initialdata/WP4-AD03.json');
        $this->addFromFile('WP4-ND03', 'database/seeders/initialdata/WP4-ND03.json');
        $this->addFromFile('WP5-AD03', 'database/seeders/initialdata/WP5-AD03.json');
    }


    private function addFromFile($listName, $filePath, $createdAt = '2024-09-09 10:00:00')
    {
        $this->command->outputComponents()->info('Seeding ' . $listName);

        $fileString = file_get_contents(base_path($filePath));
        $data = json_decode($fileString);

        $list = FairAssessmentGroupList::create([
            'name' => $listName,
            'description' => ''
        ]);

        $list->created_at = $createdAt;
        $list->save();

        $batch = FairAssessmentBatch::create([
            'fair_assessment_group_list_id' => $list->id
        ]);

        $batch->created_at = $createdAt;
        $batch->save();

        foreach($data as $entry)
        {
            $group = FairAssessmentGroup::where('name', $entry->group_identifier)->where('fair_assessment_group_list_id', $list->id)->first();

            if(!$group) {
                $group = FairAssessmentGroup::create([
                    'name' => $entry->group_identifier,
                    'fair_assessment_group_list_id' => $list->id
                ]);

                $group->created_at = $createdAt;
                $group->save();
            }

            $object = FairAssessmentObject::create([
                'pid' => $entry->uid,
                'fair_assessment_group_id' => $group->id
            ]);

            $object->created_at = $createdAt;
            $object->save();

            $assessment = FairAssessment::create([
                'fair_assessment_batch_id' => $batch->id,
                'fair_assessment_object_id' => $object->id
            ]);

            $assessment->score_percent = $entry->score_FAIR;
            $assessment->score_F = $entry->score_F;
            $assessment->score_F1 = $entry->score_F1;
            $assessment->score_F2 = $entry->score_F2;
            $assessment->score_F3 = $entry->score_F3;
            $assessment->score_F4 = $entry->score_F4;
            $assessment->score_A = $entry->score_A;
            $assessment->score_A1 = $entry->score_A1;
            $assessment->score_A2 = $entry->score_A2;
            $assessment->score_I = $entry->score_I;
            $assessment->score_I1 = $entry->score_I1;
            $assessment->score_I2 = $entry->score_I2;
            $assessment->score_I3 = $entry->score_I3;
            $assessment->score_R = $entry->score_R;
            $assessment->score_R1 = $entry->score_R1;
            $assessment->score_R1_1 = $entry->score_R1_1;
            $assessment->score_R1_2 = $entry->score_R1_2;
            $assessment->score_R1_3 = $entry->score_R1_3;

            $assessment->response_code = 200;
            $assessment->processed = true;

            $assessment->created_at = $createdAt;
            $assessment->save();
        }


    }
}
