<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    public function store(Request $request)
    {      

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Insert review with user ID
        Support::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'phone' => $validated['phone']
        ]);

        return back()->with('success', 'Thank you for contact us!');
    }
}
