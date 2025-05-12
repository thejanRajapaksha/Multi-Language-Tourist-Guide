<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    if (Auth::user()->role_id != 1) {
        abort(403, 'Unauthorized');
    }

    $jsonPath = public_path('ml_graphs/analysis_summary.json');
    $analysis = [];

    if (\File::exists($jsonPath)) {
        $analysis = json_decode(\File::get($jsonPath), true);
    }

    $graphs = [
        asset('ml_graphs/regression_spending_prediction.png'),
        asset('ml_graphs/arima_spending_forecast.png'),
        asset('ml_graphs/spending_clusters.png'),
        asset('ml_graphs/tourist_clusters_total_spending.png'),
        asset('ml_graphs/income_vs_spending.png'),
        asset('ml_graphs/tax_included_comparison.png'),
        asset('ml_graphs/countrywise_spending.png'),
    ];

    return view('government.dashboard', compact('analysis', 'graphs'));
}

}


