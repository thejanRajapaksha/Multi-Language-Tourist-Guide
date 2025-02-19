<style>
    .navbar {
        position: relative;
        background-image: url('{{ asset('images/nvbar-bg2.jpg') }}');
        background-size: cover;
        background-position: center;
        height: 350px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .navbar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 0;
    }

    .container-fluid {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 0 1rem;
        position: relative;
        z-index: 1;
    }

    .navbar-brand {
        margin-left: 50px;
        position: absolute;
        left: 0;
    }

    .navbar-brand img {
        width: 150px;
        height: 150px;
        margin-left: 40px;
    }

    .nav {
        display: flex;
        justify-content: center;
        list-style: none;
        margin: 0 auto;
        padding: 0;
        align-items: center;
        z-index: 1;
    }

    .nav li {
        padding: 0;
        margin: 0 10px;
        font-size: 22px;
        text-transform: uppercase;
        color: #fff;
        border-radius: 40px;
        position: relative;
        line-height: 100px;
    }

    .nav li a {
        color: #ffffff;
        text-decoration: none;
        padding: 5px 15px; /* Reduced padding for smaller hover area */
        border-radius: 10px;
        display: block;
        line-height: normal; /* Allows padding to define height */
    }

    .nav li a:hover {
        background-color: #2927B9;
        color: #ffffff;
        padding: 5px 15px; /* Ensure hover padding matches normal padding */
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #333;
        min-width: 300px;
        top: 100%;
        left: 0;
        border-radius: 10px;
        z-index: 1;
    }

    .dropdown-content li {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 10px;
    }

    .dropdown-content li a {
        padding: 10px 20px;
        color: #ffffff;
        border-radius: 10px;
    }

    .dropdown-content li a:hover {
        background-color: #2927B9;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover a.dropbtn {
        background-color: #2927B9;
    }
</style>

<nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <div class="navbar-brand">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('images/header/favicon2.png') }}" alt="Logo" />
            </a>
        </div>
        <ul class="nav nav-pills">
            <li class="active"><a class="nav-link" href="{{ route('welcome') }}">Home</a></li>
            <li><a class="nav-link" href="{{ route('translator.form') }}">Translator</a></li>
            <li><a class="nav-link" href="{{ route('locator') }}">Locator</a></li>
            <li><a class="nav-link" href="{{ route('emergency-assistant') }}">Emergency Assistant</a></li>
            

            @guest
                @if (Route::has('login'))
                    <li>
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-person-circle"></i></a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li>
                        <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-vcard"></i></a>
                    </li>
                @endif
            @else
                <li class="dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                    </ul>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>


