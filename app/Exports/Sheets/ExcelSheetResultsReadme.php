<?php

namespace App\Exports\Sheets;

use App\Models\Exports\ExportFairAssessmentGroupList;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelSheetResultsReadme implements FromCollection, WithTitle, WithStrictNullComparison, ShouldAutoSize
{

    public function __construct()
    {
    }

    public function collection()
    {
        $data = [];
        $row[] = "To generate this information multiple FAIR measurements have been grouped to remove ‘fluctuations’ in scores caused by possible issues due to network or temporary hosting issues. This file contains 3 measurements, which are the highest scores from all FAIR assessments done for a given DOI in a certain period.
Measurement 1: period between 9-9-2024 and 30-10-2024
Measurement 2: period between 21-7-2025 and 6-12-2024
Measurement 3: period between 21-7-2025 and 25-5-2026
This Excel file contains several sheets:
Aggregation: Shows the change in fair score grouped by installation identifier. 
Overview: Shows the total percentage score per DOI per measurement in each installation.
Measurement-1, -2 etc.: Contains detailed results for specific measurements per batch.
";

        $data[] = $row;
        
        $collection = collect($data);

        return $collection;
    }
    
    public function title(): string
    {
        return 'readme';
    }
}