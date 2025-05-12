<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Spending;
use Illuminate\Support\Facades\Storage;


class SpendingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->user_type == 2) {
            // Business user
            return view('business.record-spending'); // Updated view name
        } else {
            $spendings = \App\Models\Spending::where('passport_number', $user->passport_number)->get();
            return view('tourist.view-spending', compact('spendings'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'passport_number' => 'required|string',
            'business_category' => 'required|string',
            'spending_category' => 'required|string',
            'spending_amount' => 'required|numeric',
            'tax_included' => 'required|numeric',
        ]);

        $record = Spending::create([
            'passport_number' => $request->passport_number,
            'business_id' => Auth::id(),
            'business_category' => $request->business_category,
            'spending_category' => $request->spending_category,
            'spending_amount' => $request->spending_amount,
            'tax_included' => $request->tax_included,
            'spending_date' => today(),
        ]);

        $csvLine = [
            $record->passport_number,
            $record->business_category,
            $record->spending_category,
            $record->spending_amount,
            $record->tax_included == 0 ? 'Yes' : 'No',
            $record->spending_date->format('Y/m/d')
        ];
        $csvString = implode(',', $csvLine) . "\n";
        // \Log::info('Attempting to write to CSV', ['line' => $csvString]);
        $filePath = storage_path('app/python-input/business_records.csv');
        file_put_contents($filePath, $csvString, FILE_APPEND);

        \App\Http\Controllers\MLController::runMLPipeline();

        return redirect()->back()->with('success', 'Spending record added successfully!');
    }
}
