@include('Includes.header')
@include('Includes.top-navbar')

<div class="container mt-5">
    <h1 class="mb-4">Your Spending Records</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($spendings->isEmpty())
        <p>You have no spending records yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Business Category</th>
                        <th>Spending Category</th>
                        <th>Amount (LKR)</th>
                        <th>Tax Included</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spendings as $spending)
                        <tr>
                            <td>{{ $spending->spending_date }}</td>
                            <td>{{ $spending->business_category }}</td>
                            <td>{{ $spending->spending_category }}</td>
                            <td>{{ number_format($spending->spending_amount, 2) }}</td>
                            <td>{{ $spending->tax_included ? 'Yes' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@include('Includes.footer')
@include('Includes.footerscripts')
@include('Includes.footerbar')
