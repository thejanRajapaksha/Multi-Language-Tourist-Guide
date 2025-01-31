@include('Includes.header')
@include('Includes.top-navbar')

<style>
    .carousel-item img {
    height: 250px; /* Control image height */
    object-fit: cover; /* Maintain aspect ratio while fitting into space */
}

h1, h3 {
    color: #2c3e50; /* Darker color for headings */
}

.btn-primary {
    background-color: #007bff; /* Primary button style */
    border: none;
    border-radius: 30px; /* Rounded buttons */
    padding: 10px 20px;
    font-size: 16px;
}
h3 {
    margin-bottom: 10px; /* Space between heading and text */
}

p {
    font-size: 16px; /* Adjust paragraph font size */
}
</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Title for the Place -->
            <h1 class="text-center">{{ $place->place }}</h1>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Display all images of the place in a carousel -->
        <div id="placeImagesCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <!-- Group the images in chunks of 3 per carousel item -->
                @foreach ($place->images->chunk(3) as $index => $imageChunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($imageChunk as $image)
                                <div class="col-md-4">
                                    <img src="{{ asset($image->image_path) }}" class="d-block w-100 rounded" alt="{{ $place->place }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Carousel controls -->
            <a class="carousel-control-prev" href="#placeImagesCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#placeImagesCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- Place details -->
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="fw-bold">Description</h3>
                    <p>{{ $place->description }}</p>
                </div>
                @if($place->activities)
                    <div class="col-md-6">
                        <h3 class="fw-bold">Activities</h3>
                        <ul style="list-style-type: disc !important; padding-left: 20px !important;">
                            @foreach(explode('.', $place->activities) as $activity)
                                @if(trim($activity) != '')
                                    <li style="list-style-position: outside !important;">{{ trim($activity) }}.</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Back button -->
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2 text-center">
            <a href="{{ url()->previous() }}" class="btn btn-primary">Back to Famous Places</a>
        </div>
    </div>
</div>


@include('Includes.footer')
@include('Includes.footerscripts')

<script>
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
</script>

@include('Includes.footerbar')
