<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Spending;

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

        Spending::create([
            'passport_number' => $request->passport_number,
            'business_id' => Auth::id(),
            'business_category' => $request->business_category,
            'spending_category' => $request->spending_category,
            'spending_amount' => $request->spending_amount,
            'tax_included' => $request->tax_included,
            'spending_date' => today(),
        ]);

        \App\Http\Controllers\MLController::runMLPipeline();

        return redirect()->back()->with('success', 'Spending record added successfully!');
    }
}
