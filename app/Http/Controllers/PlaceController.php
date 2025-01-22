<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Places; 

class PlaceController extends Controller
{
    public function show($id)
    {
        $place = Places::with('images')->findOrFail($id);

        return view('place', compact('place'));
    }
}

