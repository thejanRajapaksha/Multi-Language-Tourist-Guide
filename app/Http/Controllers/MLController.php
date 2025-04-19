<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MLController extends Controller
{
    public static function runMLPipeline()
    {
        // 1. Export CSVs
        self::exportCSV('tourists', 'storage/app/python-input/tourists.csv');
        self::exportCSV('spendings', 'storage/app/python-input/business_records.csv');

        // 2. Run Python script
        exec("python3 ml/ml_model.py");
    }

    private static function exportCSV($table, $filePath)
    {
        $data = DB::table($table)->get();

        if ($data->isEmpty()) return;

        $csv = implode(',', array_keys((array)$data[0])) . "\n";

        foreach ($data as $row) {
            $csv .= implode(',', array_map('strval', (array) $row)) . "\n";
        }

        Storage::put(str_replace("storage/app/", "", $filePath), $csv);
    }
}
