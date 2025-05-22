@include('Includes.header')
@include('Includes.top-navbar')

<style>.nav-tabs .nav-link {
    padding: 5px 8px;      /* Smaller padding = smaller height */
    font-size: 17px;       /* Optional: reduce font size */
    line-height: 3;      /* Controls vertical spacing */
}

.nav-tabs .nav-link.active {
    padding: 4px 8px;
    border-radius: 4px 4px 0 0; /* Optional for aesthetics */
}
</style>

<div class="container mt-3">
    <h2 class="mb-4 text-center">Admin Dashboard</h2>

    <!-- Nav Tabs -->
    <ul class="nav nav-tabs mb-3" id="dashboardTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active py-1 px-2" id="forecast-tab" data-bs-toggle="tab" data-bs-target="#forecast" type="button" role="tab">Spending Forecast</button>
        </li>
        <li class="nav-item">
            <button class="nav-link py-1 px-2" id="clustering-tab" data-bs-toggle="tab" data-bs-target="#clustering" type="button" role="tab">Clustering</button>
        </li>
        <li class="nav-item">
            <button class="nav-link py-1 px-2" id="correlation-tab" data-bs-toggle="tab" data-bs-target="#correlation" type="button" role="tab">Correlation</button>
        </li>
        <li class="nav-item">
            <button class="nav-link py-1 px-2" id="spending-tab" data-bs-toggle="tab" data-bs-target="#spending" type="button" role="tab">Spending Summary</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="dashboardTabsContent">
        <!-- Spending Forecast Tab -->
        <div class="tab-pane fade show active" id="forecast" role="tabpanel">
            @if(!empty($analysis))
                <div class="card mb-4 p-3 shadow-sm">
                    <h4>Forecast Summary</h4>
                    <ul>
                        <!-- <li><strong>Regression R² Score:</strong> {{ $analysis['regression_r2'] }}</li> -->
                        <li><strong>Forecast Total (Next 6 Months):</strong> LKR {{ number_format($analysis['arima_forecast_total'], 2) }}</li>
                        <li><strong>On average, forecasts deviate from actual values by </strong> {{ $analysis['arima_accuracy'] }} %</li>
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[0] }}" alt="Spending Forecast" class="img-fluid rounded shadow-sm" style="height: 100%;">
                </div>
                <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[7] }}" alt="Monthly Spending" class="img-fluid rounded shadow-sm">
                </div>
            </div>
        </div>

        <!-- Clustering Tab -->
        <div class="tab-pane fade" id="clustering" role="tabpanel">
            @if(!empty($analysis))
                <div class="card mb-4 p-3 shadow-sm">
                    <h4>Clustering Summary</h4>
                    <ul>
                        <li><strong>Cluster Segments:</strong> {{ $analysis['cluster_count'] }}</li>
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[1] }}" alt="Spending Clusters" class="img-fluid rounded shadow-sm">
                </div>
                <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[2] }}" alt="Tourist Cluster Spending" class="img-fluid rounded shadow-sm">
                </div>
            </div>
        </div>

        <!-- Correlation Tab -->
        <div class="tab-pane fade" id="correlation" role="tabpanel">
            @if(!empty($analysis))
                <div class="card mb-4 p-3 shadow-sm">
                    <h4>Tax Overview</h4>
                    <ul>
                        <li><strong>Time period:</strong> {{ ($analysis['tax_period']) }}</li>
                        <li><strong>Tax Included Spending:</strong> LKR {{ number_format($analysis['tax_included'], 2) }}</li>
                        <li><strong>Tax Excluded Spending:</strong> LKR {{ number_format($analysis['tax_excluded'], 2) }}</li>
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[3] }}" alt="Income vs Spending" class="img-fluid rounded shadow-sm">
                </div>
                <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[4] }}" alt="Tax Comparison" class="img-fluid rounded shadow-sm">
                </div>
            </div>
        </div>

        <!-- Spending Summary Tab -->
        <div class="tab-pane fade" id="spending" role="tabpanel">
            @if(!empty($analysis))
                <div class="card mb-4 p-3 shadow-sm">
                    <h4>Spending Overview</h4>
                    <ul>
                        <li><strong>Top Spending Country:</strong> {{ $analysis['top_country'] }}</li>
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[5] }}" alt="Countrywise Spending" class="img-fluid rounded shadow-sm">
                </div>
                <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[6] }}" alt="Bar Spending by Category" class="img-fluid rounded shadow-sm">
                </div>
                <!-- <div class="col-md-6 mb-3">
                    <img src="{{ $graphs[8] }}" alt="Pie Spending by Category" class="img-fluid rounded shadow-sm">
                </div> -->
            </div>
        </div>
    </div>
</div>

@include('Includes.footer')
@include('Includes.footerscripts')
@include('Includes.footerbar')
