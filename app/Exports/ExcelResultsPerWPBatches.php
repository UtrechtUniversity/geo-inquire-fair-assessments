<?php

namespace App\Exports;

use App\Models\Exports\ExportFairAssessmentGroupList;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\ExcelSheetResultsBatchOverview;
use App\Exports\Sheets\ExcelSheetResultsBatch;
use App\Exports\Sheets\ExcelSheetResultsBatchOverviewAggregation;
use App\Exports\Sheets\ExcelSheetResultsReadme;

class ExcelResultsPerWPBatches implements WithMultipleSheets
{
    public ExportFairAssessmentGroupList $list;

    public function __construct($list)
    {
        $this->list = $list;
    }

    public function sheets(): array
    {
        $sheets = [
            new ExcelSheetResultsReadme(),
            new ExcelSheetResultsBatchOverviewAggregation($this->list),
            new ExcelSheetResultsBatchOverview($this->list),
            new ExcelSheetResultsBatch($this->list, 1),
            new ExcelSheetResultsBatch($this->list, 2),
            new ExcelSheetResultsBatch($this->list, 3),
        ];

        return $sheets;
    }
}
