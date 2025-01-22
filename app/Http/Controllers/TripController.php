<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientPlan; // Ensure this model is included
use Illuminate\Support\Facades\Auth; // Make sure Auth is imported

class TripController extends Controller
{
    public function showForm()
    {
        return view('plan-your-trip');
    }

    }
