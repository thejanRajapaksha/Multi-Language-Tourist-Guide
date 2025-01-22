@include('Includes.header')
<style>
    /* Custom Styles for the Login Form */
    .custom-card {
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        background: linear-gradient(135deg, #ffffff, #f9f9f9);
        width: 100%;
        max-width: 420px; /* Adjusted to control width */
        height: auto; /* Height adjusted dynamically */
    }

    .custom-card-header {
        background: linear-gradient(135deg, #2927B9, #1e1c9b);
        color: #fff;
        font-size: 20px;
        text-align: center;
        padding: 12px;
        border-bottom: 1px solid #ddd;
        box-shadow: inset 0 -2px 4px rgba(0, 0, 0, 0.1);
    }

    .custom-card-body {
        padding: 20px;
    }

    .form-label {
        font-size: 16px;
        color: #333;
        font-weight: 600;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-control:focus {
        border-color: #2927B9;
        box-shadow: 0 0 8px rgba(41, 39, 185, 0.3);
    }

    .invalid-feedback {
        color: #e74c3c;
        font-size: 13px;
        margin-top: 5px;
    }

    .btn-submit {
        background-color: #2927B9;
        color: #fff;
        text-transform: uppercase;
        padding: 8px 20px;
        border-radius: 6px;
        border: none;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 15px;
    }

    .btn-submit:hover {
        background-color: #1e1c9b;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .btn-link {
        color: #2927B9;
        font-size: 14px;
        text-decoration: none;
        margin-left: 10px;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    /* Additional Styles for Layout */
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        max-width: 900px;
        margin: auto;
    }

    .login-image {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.05);
    }
</style>

@include('Includes.top-navbar')

<div class="container mt-5">
    <div class="login-container">

        @if (session('error'))
            <div class="alert alert-danger">
                {!! session('error') !!}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card custom-card">
            <div class="card-header custom-card-header">{{ __('Login') }}</div>
            <div class="card-body custom-card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button type="submit" class="btn btn-submit">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@include('Includes.footer')
@include('Includes.footerscripts')
@include('Includes.footerbar')
