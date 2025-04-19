@include('Includes.header')
<style>
    /* Custom Styles for the Registration Form */
    .custom-card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background: linear-gradient(135deg, #ffffff, #f9f9f9);
        width: 620px; /* Slightly smaller width */
        height: auto; /* Height adjusted dynamically */
        margin: auto;
    }

    .custom-card-header {
        background: linear-gradient(135deg, #2927B9, #1e1c9b);
        color: #fff;
        font-size: 20px; /* Slightly smaller header text */
        text-align: center;
        padding: 12px; /* Adjusted padding */
        border-bottom: 1px solid #ddd;
        box-shadow: inset 0 -2px 4px rgba(0, 0, 0, 0.1);
    }

    .custom-card-body {
        padding: 20px; /* Reduced padding */
    }

    .form-label {
        font-size: 16px; /* Reduced label font size */
        color: #333;
        font-weight: 600;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 6px; /* Reduced border radius */
        padding: 10px; /* Increased padding */
        font-size: 14px; /* Reduced font size */
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #2927B9;
        box-shadow: 0 0 8px rgba(41, 39, 185, 0.3);
    }

    .invalid-feedback {
        color: #e74c3c;
        font-size: 13px; /* Reduced feedback font size */
        margin-top: 5px;
    }

    .btn-submit {
        background-color: #2927B9;
        color: #fff;
        text-transform: uppercase;
        padding: 10px 20px; /* Increased button size */
        border-radius: 6px; /* Reduced border radius */
        border: none;
        font-size: 14px; /* Reduced font size */
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 15px; /* Ensure the button stays separate from inputs */
    }

    .btn-submit:hover {
        background-color: #1e1c9b;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Additional Styles for Layout */
    .custom-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-form {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-row.mb-3 {
        margin-bottom: 16px; /* Increased space between rows */
    }

    /* Adjust the dynamic field sections to be properly aligned */
    .dynamic-fields {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #f9f9f9;
    }
</style>

@include('Includes.top-navbar')

<div class="container mt-5">
    <div class="row custom-container">
        <div class="col-md-6 custom-form">
            <div class="card custom-card">
                <div class="card-header custom-card-header">{{ __('Register') }}</div>

                <div class="card-body custom-card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Common Fields -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- User Type Dropdown at the Top -->
                        <div class="form-group mb-3">
                            <label for="user_type" class="form-label">{{ __('User Type') }}</label>
                            <select id="user_type" class="form-control @error('user_type') is-invalid @enderror" name="user_type" required>
                                <option value="1" {{ old('user_type') == 1 ? 'selected' : '' }}>Tourist</option>
                                <option value="2" {{ old('user_type') == 2 ? 'selected' : '' }}>Business</option>
                            </select>
                            @error('user_type')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <!-- Dynamic Fields for Tourist and Business -->
                        <div id="tourist-fields" class="dynamic-fields" style="display: none;">
                            <div class="form-row mb-3">
                                <label for="passport_number" class="form-label">{{ __('Passport Number') }}</label>
                                <input id="passport_number" type="text" class="form-control" name="passport_number" value="{{ old('passport_number') }}">
                            </div>
                            <div class="form-row mb-3">
                                <label for="nationality" class="form-label">{{ __('Nationality') }}</label>
                                <input id="nationality" type="text" class="form-control" name="nationality" value="{{ old('nationality') }}">
                            </div>
                            <div class="form-row mb-3">
                                <label for="income_method" class="form-label">{{ __('Income Method') }}</label>
                                <select id="income_method" class="form-control" name="income_method">
                                    <option value="job" {{ old('income_method') == 'job' ? 'selected' : '' }}>Job</option>
                                    <option value="business" {{ old('income_method') == 'business' ? 'selected' : '' }}>Business</option>
                                    <option value="investments" {{ old('income_method') == 'investments' ? 'selected' : '' }}>Investments</option>
                                    <option value="other" {{ old('income_method') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-row mb-3">
                                <label for="income_amount" class="form-label">{{ __('Income Amount (Monthly)') }}</label>
                                <input id="income_amount" type="number" class="form-control" name="income_amount" value="{{ old('income_amount') }}">
                            </div>
                            <div class="form-row mb-3">
                                <label for="currency_used" class="form-label">{{ __('Currency Used') }}</label>
                                <input id="currency_used" type="text" class="form-control" name="currency_used" value="{{ old('currency_used') }}">
                            </div>
                            <div class="form-row mb-3">
                                <label for="planned_length_of_stay" class="form-label">{{ __('Planned Length of Stay') }}</label>
                                <input id="planned_length_of_stay" type="text" class="form-control" name="planned_length_of_stay" value="{{ old('planned_length_of_stay') }}">
                            </div>
                        </div>

                        <div id="business-fields" class="dynamic-fields" style="display: none;">
                            <div class="form-row mb-3">
                                <label for="business_type" class="form-label">{{ __('Business Type') }}</label>
                                <select id="business_type" class="form-control" name="business_type">
                                    <option value="hotel" {{ old('business_type') == 'hotel' ? 'selected' : '' }}>Hotel</option>
                                    <option value="restaurant" {{ old('business_type') == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                                    <option value="tour_operator" {{ old('business_type') == 'tour_operator' ? 'selected' : '' }}>Tour Operator</option>
                                    <option value="shop" {{ old('business_type') == 'shop' ? 'selected' : '' }}>Shop</option>
                                    <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="form-row mb-3">
                                <label for="business_registration_number" class="form-label">{{ __('Business Registration Number') }}</label>
                                <input id="business_registration_number" type="text" class="form-control" name="business_registration_number" value="{{ old('business_registration_number') }}">
                            </div>
                            <div class="form-row mb-3">
                                <label for="business_location" class="form-label">{{ __('Business Location') }}</label>
                                <input id="business_location" type="text" class="form-control" name="business_location" value="{{ old('business_location') }}">
                            </div>
                            <div class="form-row mb-3">
                                <label for="tax_identification_number" class="form-label">{{ __('Tax Identification Number (TIN)') }}</label>
                                <input id="tax_identification_number" type="text" class="form-control" name="tax_identification_number" value="{{ old('tax_identification_number') }}">
                            </div>
                        </div>
                        <input type="hidden" id="status" value=1>

                        <div class="form-group mb-0 text-center">
                            <button type="submit" class="btn btn-submit">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('Includes.footer')

<script>
    // Handle the dynamic field visibility based on user type selection
    document.getElementById('user_type').addEventListener('change', function() {
        var userType = this.value;
        if (userType == 1) {
            document.getElementById('tourist-fields').style.display = 'block';
            document.getElementById('business-fields').style.display = 'none';
            document.getElementById('business_type').value = '';
        } else if (userType == 2) {
            document.getElementById('business-fields').style.display = 'block';
            document.getElementById('tourist-fields').style.display = 'none';
        }
    });

    // Trigger the change event to show the appropriate fields
    document.getElementById('user_type').dispatchEvent(new Event('change'));
</script>
