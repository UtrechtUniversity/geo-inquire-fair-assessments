<?php

namespace App\Console\Commands;

use App\Models\FairAssessmentGroupList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportDoiFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-doi-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create text files for future input';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lists = FairAssessmentGroupList::where('version', 2)->get();

        foreach($lists as $list) {
            $groups = $list->fair_assessment_groups;            
            foreach($groups as $group) {
                $objects = $group->fair_assessment_objects;
                $fileName = $group->name . '.txt';
                $path = 'input-files/' . $list->name .  '/';
                $fileContent = '';
                foreach($objects as $object) {
                    $fileContent .= $object->pid . PHP_EOL;
                }

                if(strlen($fileContent) > 0) {
                    $fullPath = $path . $fileName;
                    Storage::disk('local')->put($fullPath, $fileContent);
                }
            }
        }
    }
}
