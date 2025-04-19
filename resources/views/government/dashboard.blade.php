@include('Includes.header')
@include('Includes.top-navbar')

<div class="container mt-5">
    <h2 class="mb-4">Tourist Spending Dashboard</h2>
    <img src="{{ asset('ml_graphs/spending_by_country.png') }}" alt="Spending Chart" class="img-fluid">
</div>

@include('Includes.footer')
@include('Includes.footerscripts')
@include('Includes.footerbar')
