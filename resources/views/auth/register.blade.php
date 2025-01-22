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
        padding: 8px; /* Reduced padding */
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
        padding: 8px 20px; /* Reduced button size */
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

    .custom-image {
        flex: 1;
        text-align: center;
    }

    .custom-image img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
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

                        <div class="row">
                            <div class="col">
                                <div class="form-row mb-3">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-row mb-3">
                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-row mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-row mb-3">
                                    <label for="password-confirm"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
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
@include('Includes.footerscripts')
@include('Includes.footerbar')
