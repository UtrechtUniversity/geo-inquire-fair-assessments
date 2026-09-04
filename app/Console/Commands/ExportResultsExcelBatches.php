<?php

namespace App\Console\Commands;

use App\Exports\ExcelResultsPerWPBatches;
use App\Models\Exports\ExportFairAssessmentGroupList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportResultsExcelBatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-results-excel-batches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Excel file per work package/list containing grouped results over time';

    /**
     * Execute the console command.
     */
    public function handle()
    {                
        $basePath = 'results-grouped/';

        $lists = ExportFairAssessmentGroupList::where('version', 2)->get();

        foreach ($lists as $list) {
            $path = $basePath . $list->name . '.xlsx';
            Excel::store(new ExcelResultsPerWPBatches($list), $path, 'local');
        }
    }
}
