@include('Includes.header')
<style>
/* Notification styles */
.alert-new {
    background-color: #ffeeba; /* Light yellow for new notifications */
    color: #856404; /* Dark color for text */
}

.alert-read {
    background-color: #f8f9fa; /* Light gray for read notifications */
    color: #6c757d; /* Darker gray color for text */
}

.notification-popup {
    position: absolute;
    right: 10px; /* Adjust as needed */
    top: 60px; /* Adjust as needed */
    background-color: white;
    border: 1px solid #ccc;
    z-index: 1000; /* Ensure it appears above other elements */
    padding: 10px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
    display: none; /* Initially hidden */
}

.notification-popup .alert {
    margin-bottom: 10px;
}

</style>
<div class="index-page">
    <div class="overlay"></div>
    <!-- header section start -->
    <div class="header_section">
        <div class="header_main">
            <div class="mobile_menu">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                           
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link " href="blog.html"><i class="bi bi-bell-fill"></i></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="blog.html">Register</a>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('welcome') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('booking') }}">Map</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('translator.form') }}">Translator</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('emergency-assistant') }}">Emergency Assistant</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Travel Journal
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('create-journal') }}">Create Journal</a>
                                    <a class="dropdown-item" href="{{ route('view-journal') }}">View Journal</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="container-fluid">
            <div class="menu_main_login text-end">
                <ul>
                    <li><div id="google_translate_element"></div></li>
                </ul>
                <ul>
                    <!-- Notification Icon -->
                    <!-- Notification Icon with Count Badge -->
                    <li class="mt-1">
                        <a href="#" id="notificationIcon">
                            <i class="bi bi-bell-fill"></i>
                            <!-- Badge for New Notifications Count -->
                            <span id="notificationCount" class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                {{ $notificationCount }}
                            </span>                            
                        </a>
                    </li>


                    <!-- Notification Modal -->
                <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                @if($welcomeMessage)
                                    <div class="alert alert-info">{{ $welcomeMessage }}</div>
                                @endif

                                
                            </div>
                        </div>
                    </div>
                </div>                    
      
                    <!-- Authentication Links -->             
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-person-circle"></i></a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-vcard"></i></a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-content">
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a></li>
                        </ul>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @endguest
                    <!-- Four Dot Icon -->
                    <li class="four-dots">
                        <a href="#" id="review-toggle"><i class="bi bi-grid-fill"></i></a>
                    </li>
                </ul>
            </div>

            <!-- Review Form -->

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        

            <div id="review-form" class="review-form">
                <button type="button" id="close-form" class="close-button">&times;</button>
                <div class="logo">
                    <img class="" src="{{ asset('images/header/favicon.png') }}" style="width: 50%;" />
                </div>
                <h1 class="about_taital">Your Valuable Feedback</h1>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Your Phone Number" required>
                    </div>
                    <div class="form-group">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>

            
                <div class="menu_main">
                    <ul>
                        <li class="active"><a class="nav-link" href="{{ route('welcome') }}">Home</a></li>
                        <li><a href="{{ route('locator') }}">Locator</a></li>
                        <li><a href="{{ route('translator.form') }}">Translator</a></li>
                        <li><a href="{{ route('emergency-assistant') }}">Emergency Assistant</a></li>
                        <li><a href="{{ route('spending.index') }}">Create Spending</a></li>
                    </ul>
                </div>

                <!-- Google Translate Script -->
                <script type="text/javascript">
                    function googleTranslateElementInit() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            includedLanguages: 'en,si,ta,fr,de,es,zh',
                            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                            autoDisplay: false
                        }, 'google_translate_element');
                    }
                </script>
                <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

            </div>
        </div>
        <!-- banner section start -->
        <div class="banner_section layout_padding">
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                @foreach ($site as $index => $sites)
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <h3 class="banner_taital">{{ $sites->main_topic }}</h3>
                            <p class="banner_text">{{ $sites->sub_topic }}</p>   
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <h3 class="banner_taital">{{ $sites->main_topic2 }}</h3>
                            <p class="banner_text">{{ $sites->sub_topic2 }}
                            </p>
                            
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="container">
                            <h3 class="banner_taital">{{ $sites->main_topic3 }}</h3>
                            <p class="banner_text">{{ $sites->sub_topic3 }}</p>
                                
                        </div>
                    </div>
                </div>
                @endforeach    
            </div>
        </div>
        <!-- banner section end -->
    </div>
    <!-- header section end -->
    <main class="main">

        <!-- about section start -->
        <div class="about_section layout_padding">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="about_taital_main">
                            <h1 class="about_taital">About Multi Language Tourist Guide...</h1>
                            <p class="about_text">Travelling is becoming more prevalent as a hobby
                                nowadays. A lot of people
                                are leading a
                                busy life with the work life. Therefore, it is becoming a trend to travel to reduce work
                                pressure.
                                As travelling becoming more prevalent, modern technology will be led the future of
                                travelling
                                by enhancing different technologies into this industry. Therefore, young generation
                                tending
                                to
                                use different apps related to these factors. So that, the different necessities of the
                                young
                                generation must be identified to provide a proper solution for this matter. <br><br>
                                As a solution for this matter, MLTG: Multi Language Tourist Guide will be developed
                                to
                                enhance the travel experience of the young generation. It will be a great platform to
                                enhance
                                the travelling. MLTG is a web-based application and the travel experience of the users
                                will be
                                improved by using the MLTG web application.</p>
                        </div>
                    </div>
                    <div class="col-md-6 padding_right_0">
                        <div class="mt-5">
                            @foreach ($site as $index => $sites)
                                <video class="about_video" width="800" height="450" controls autoplay loop muted>
                                <source src="{{ asset('images/Short_video.mp4') }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endforeach                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about section end -->
        <!-- services section start -->
        <div class="services_section layout_padding mb-5">
            <div class="container">
                <h1 class="services_taital text-center">Famous Places to Visit</h1>
                <p class="services_text text-justify text-center">
                    Explore some of the most iconic and breathtaking destinations around the world. 
                    From ancient temples to majestic natural wonders, discover the beauty and history that make these places truly special.
                </p>

                <div id="servicesCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($famousplace->chunk(3) as $index => $placeChunk)  <!-- Grouping places in chunks of 3 -->
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="row mt-5">
                                    @foreach ($placeChunk as $place)
                                    <div class="col-md-4 position-relative">
                                        <!-- Show the first image of each place if available -->
                                        @if($place->images->first())
                                            <img src="{{ asset($place->images->first()->image_path) }}" class="services_img h-50 w-100" alt="{{ $place->place }}">
                                        @else
                                            <img src="{{ asset('images/default-placeholder.png') }}" class="services_img h-50 w-100" alt="No Image">
                                        @endif
                                        <div class="text-center">
                                            <h3 class="fw-bold">{{ $place->place }}</h3>
                                            <p>{{ Str::limit($place->description, 450) }}<br><a class="text-primary fw-bold text-lg" href="{{ route('place', $place->id) }}">Read more...</a></p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Carousel controls -->
                    <a class="carousel-control-prev" href="#servicesCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#servicesCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>




        <!-- services section end -->

        <!-- video section start -->
        <div class="video_section layout_padding">
            <div>
                <h1 class="client_taital">Visit Sri Lanka</h1>
            </div>
            <div class="video_container">
                @foreach ($site as $index => $sites)
                <video class="video_player" controls autoplay loop muted>
                <source src="{{ asset('images/Long_video.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                @endforeach   
                <div class="video_overlay"></div>
            </div> 
        </div>
        <!-- video section end -->

        <!-- client section start -->
        <div class="client_section layout_padding">
            <div class="container">
                <h1 class="client_taital text-center">Traveller's Experience</h1>
                <div class="client_section_2">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($reviews as $index => $review)
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($reviews as $index => $review)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="client_main d-flex align-items-center">
                                        <div class="box_left flex-grow-1">
                                            <p class="lorem_text"><img src="{{ asset('images/header/hero/quick-icon.png') }}" class="mb-3" alt="Quick Icon" width="4%"> {{ $review->message }}</p>
                                        </div>
                                        <div class="box_right text-center">
                                            <div class="client_taital_left">
                                                <div class="client_img">
                                                    <img src="{{ asset('images/header/hero/review.png') }}" alt="Client Image" class="rounded-circle">
                                                </div>
                                                <div class="quick_icon">
                                                    <img src="{{ asset('images/header/hero/quick-icon.png') }}" alt="Quick Icon">
                                                </div>
                                            </div>
                                            <div class="client_taital_right">
                                                <h4 class="client_name">{{ $review->name }}</h4>
                                                <p class="customer_text">Traveller</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <button id="scrollToTopBtn" class="scroll-to-top" onclick="scrollToTopFunction()">
        <i class="bi bi-arrow-up-circle-fill"></i>
    </button>

</div>
@include('Includes.footer')
@include('Includes.footerscripts')

<script>
document.getElementById('notificationIcon').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent default anchor behavior

    // Show the modal
    var myModal = new bootstrap.Modal(document.getElementById('notificationModal'));
    myModal.show();

    // Make an AJAX request to mark notifications as read
    fetch('/mark-notifications-read', { 
        method: 'POST', 
        headers: { 
            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
        }
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response if needed
    });

    // Hide the notification count badge if you have one
    const notificationCountElement = document.getElementById('notificationCount');
    if (notificationCountElement) {
        notificationCountElement.style.display = 'none';
    }
});

// Show or hide the button when scrolling
window.onscroll = function () {
    var scrollToTopBtn = document.getElementById("scrollToTopBtn");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopBtn.style.display = "block"; // Show the button
    } else {
        scrollToTopBtn.style.display = "none"; // Hide the button
    }
};

// Scroll to top function
function scrollToTopFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
}

document.getElementById('review-toggle').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('review-form').classList.toggle('show');
});

document.getElementById('close-form').addEventListener('click', function() {
    document.getElementById('review-form').classList.remove('show');
});

window.addEventListener('click', function(e) {
    const form = document.getElementById('review-form');
    if (!form.contains(e.target) && !document.getElementById('review-toggle').contains(e.target)) {
        form.classList.remove('show');
    }
});
</script>

@include('Includes.footerbar')
