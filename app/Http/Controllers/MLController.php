<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MLController extends Controller
{
    public static function runMLPipeline()
    {
        $pythonPath = 'C:/Users/oshan/AppData/Local/Programs/Python/Python312/python.exe';
        $scriptPath = 'C:/xampp2/htdocs/Multi-Language-Tourist-Guide/ml/ml_model.py';
        exec("$pythonPath $scriptPath");
    }

}
