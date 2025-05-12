@include('Includes.header')
@include('Includes.top-navbar')

<div class="container mt-3">
    <h2 class="mb-4">Tourist Spending Dashboard</h2>

    <!-- Dynamic Summary Panel -->
    <div class="card mb-4 p-3 shadow-sm">
        <h4>Analysis Summary</h4>
        @if(!empty($analysis))
            <ul>
                <li><strong>Regression R² Score:</strong> {{ $analysis['regression_r2'] }}</li>
                <li><strong>Forecast Total (Next 6 Months):</strong> LKR {{ number_format($analysis['arima_forecast_total'], 2) }}</li>
                <li><strong>Cluster Segments:</strong> {{ $analysis['cluster_count'] }}</li>
                <li><strong>Tax Included Spending:</strong> LKR {{ number_format($analysis['tax_included'], 2) }}</li>
                <li><strong>Tax Excluded Spending:</strong> LKR {{ number_format($analysis['tax_excluded'], 2) }}</li>
                <li><strong>Top Spending Country:</strong> {{ $analysis['top_country'] }}</li>
            </ul>
            <small class="text-muted">* Data updates automatically based on latest tourist and business records.</small>
        @else
            <p>No analysis data found. Please run the ML model script.</p>
        @endif
    </div>

    <!-- Dynamic Graph Display -->
    <div class="row">
        @foreach($graphs as $graph)
            <div class="col-md-6 mb-3">
                <img src="{{ $graph }}" alt="ML Graph" class="img-fluid rounded shadow-sm">
            </div>
        @endforeach
    </div>
</div>

@include('Includes.footer')
@include('Includes.footerscripts')
@include('Includes.footerbar')
