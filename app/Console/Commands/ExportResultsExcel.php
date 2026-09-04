<?php

namespace App\Console\Commands;

use App\Exports\ExcelResultsPerWP;
use App\Models\FairAssessmentGroupList;
use App\Models\FairAssessmentObject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportResultsExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-results-excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Excel file per work package/list';

    /**
     * Execute the console command.
     */
    public function handle()
    {                
        $basePath = 'results/';

        $lists = FairAssessmentGroupList::where('version', 2)->get();

        foreach ($lists as $list) {
            $path = $basePath . $list->name . '.xlsx';
            Excel::store(new ExcelResultsPerWP($list), $path, 'local');            
        }
    }
}
