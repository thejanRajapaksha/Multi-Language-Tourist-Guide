<style>
    .dropdown-toggle {
        color: #212529 !important;
        background-color: #fff !important;
        border: 1px solid #ced4da;
        text-align: left;
    }

    .dropdown-toggle:hover,
    .dropdown-toggle:focus,
    .dropdown-toggle:active {
        background-color: #e9ecef !important;
        color: #212529 !important;
    }

    .dropdown-menu {
        width: 100% !important;
    }

    .dropdown-item {
        color: #212529;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #000;
    }
</style>

@include('Includes.header')
@include('Includes.top-navbar')

<div class="container col-3 mt-5">
    <h1>Record Tourist Spending</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('spending.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="passport_number" class="form-label">Passport Number</label>
            <input type="text" class="form-control" id="passport_number" name="passport_number" required>
        </div>

        <!-- Business Category -->
        <div class="mb-3">
            <label class="form-label">Business Category</label>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="businessDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Select Business Category
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="businessDropdown">
                    @foreach (['Hotel', 'Restaurant', 'Shop', 'Tourist Attraction'] as $category)
                        <li><a class="dropdown-item" href="#" onclick="selectOption('business_category', '{{ $category }}', 'businessDropdown')">{{ $category }}</a></li>
                    @endforeach
                </ul>
            </div>
            <input type="hidden" name="business_category" id="business_category" required>
        </div>

        <!-- Spending Category -->
        <div class="mb-3">
            <label class="form-label">Spending Category</label>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="spendingDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Select Spending Category
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="spendingDropdown">
                    @foreach (['Accommodation', 'Food', 'Shopping', 'Entertainment'] as $category)
                        <li><a class="dropdown-item" href="#" onclick="selectOption('spending_category', '{{ $category }}', 'spendingDropdown')">{{ $category }}</a></li>
                    @endforeach
                </ul>
            </div>
            <input type="hidden" name="spending_category" id="spending_category" required>
        </div>

        <!-- Spending Amount -->
        <div class="mb-3">
            <label for="spending_amount" class="form-label">Spending Amount (LKR)</label>
            <input type="number" class="form-control" id="spending_amount" name="spending_amount" required>
        </div>

        <!-- Tax Included -->
        <div class="mb-3">
            <label class="form-label">Tax Included?</label>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="taxDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Select Option
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="taxDropdown">
                    <li><a class="dropdown-item" href="#" onclick="selectOption('tax_included', '0', 'taxDropdown', 'Yes')">Yes</a></li>
                    <li><a class="dropdown-item" href="#" onclick="selectOption('tax_included', '1', 'taxDropdown', 'No')">No</a></li>
                </ul>
            </div>
            <input type="hidden" name="tax_included" id="tax_included" required>
        </div>

        <input type="hidden" name="spending_date" value="{{ date('Y-m-d') }}">

        <div class="mb-5">
            <button type="submit" class="btn btn-primary float-end">Submit</button>
        </div>
    </form>
</div>

@include('Includes.footer')
@include('Includes.footerscripts')
@include('Includes.footerbar')

<script>
    function selectOption(inputId, value, buttonId, label = null) {
        document.getElementById(inputId).value = value;
        document.getElementById(buttonId).innerText = label ?? value;
    }
</script>
