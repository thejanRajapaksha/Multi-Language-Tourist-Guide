@include('Includes.header')
@include('Includes.top-navbar')

<style>
    .gallery-container {
    text-align: center;
    padding: 50px 100px;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.gallery-item {
    position: relative;
    overflow: hidden;
}

.gallery-item img {
    width: 500px;
    height: auto;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.scroll-to-top {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 50%;
    display: none;
    cursor: pointer;
}

.scroll-to-top i {
    font-size: 24px;
}

</style>

<div class="gallery-container">
    <h1>{{ $journal->title }} Gallery</h1>
    <div class="gallery-grid">
        <!-- Example gallery images -->
        @foreach ($galleryImages->chunk(3) as $index => $images)
        @foreach ($images as $image)
        <div class="gallery-item">
            <img src="{{ asset($image->image_path) }}" alt="Image 1">
        </div>
        @endforeach
        @endforeach

    </div>

    <button id="scrollToTopBtn" class="scroll-to-top" onclick="scrollToTopFunction()">
        <i class="bi bi-arrow-up-circle-fill"></i>
    </button>
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
