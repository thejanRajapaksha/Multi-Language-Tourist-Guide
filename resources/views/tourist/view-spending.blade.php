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
            <table id="spendingTable" class="table table-bordered table-hover">
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

{{-- DataTables CSS and JS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

{{-- Initialize DataTables --}}
<script>
    $(document).ready(function () {
        $('#spendingTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', className: 'btn btn-secondary' },
                { extend: 'csv', className: 'btn btn-primary' },
                { extend: 'excel', className: 'btn btn-success' },
                { extend: 'pdf', className: 'btn btn-danger' },
                { extend: 'print', className: 'btn btn-info' }
            ]
        });
    });
</script>
