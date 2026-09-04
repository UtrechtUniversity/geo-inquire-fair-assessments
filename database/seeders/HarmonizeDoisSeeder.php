<?php

namespace Database\Seeders;

use App\Models\FairAssessment;
use App\Models\FairAssessmentObject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HarmonizeDoisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objects = FairAssessmentObject::all();

        // cleanup pids to be able to match them        
        foreach($objects as $object) {
            if(str_starts_with($object->pid, 'doi.org/')) {
                $object->pid = substr($object->pid, strlen('doi.org/'));
                $object->save();
                continue;
            }

            if(str_starts_with($object->pid, 'http://dx.doi.org/')) {
                $object->pid = substr($object->pid, strlen('http://dx.doi.org/'));
                $object->save();
                continue;
            }

            if(str_starts_with($object->pid, 'https://doi.org/')) {
                $object->pid = substr($object->pid, strlen('https://doi.org/'));
                $object->save();
                continue;
            }
        }
        

        // convert current relations to many to many        
        foreach($objects as $object) {
            DB::table('fair_asessment_group_object')->insert([
                'fair_assessment_object_id' => $object->id,
                'fair_assessment_group_id' => $object->fair_assessment_group_id
            ]);
        }
        

        // remove duplicates from objects table
        $groupedResults = DB::table('fair_assessment_objects')->selectRaw('count(pid) as count, pid')->groupBy('pid')->get();

        foreach($groupedResults as $groupedResult) {
            //dd($groupedResult->count, $groupedResult->pid);
            
            if($groupedResult->count > 1) {
                // get all objects with the same pid
                $matches = FairAssessmentObject::where('pid', $groupedResult->pid)->get();
                
                if(count($matches) > 1) {
                    $first = true;
                    $firstMatch = null;

                    foreach($matches as $match) {
                        if($first) {
                            $firstMatch = $match;
                            $first = false;
                            continue;
                        }

                        DB::table('fair_asessment_group_object')->where('fair_assessment_object_id', $match->id)->update(['fair_assessment_object_id' => $firstMatch->id]);

                        // delete the assessments for the match
                        FairAssessment::where('fair_assessment_object_id', $match->id)->delete();
                        
                        // delete the match
                        $match->delete();
                    }
                }
                
            }
        }
    }


}
