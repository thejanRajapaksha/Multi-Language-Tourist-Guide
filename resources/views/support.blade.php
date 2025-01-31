@include('Includes.header')
@include('Includes.top-navbar')

<div class="container col-6 mt-5">
    <h1>Contact Support</h1>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <form action="{{ route('support.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-row mb-3">
                    <label for="days" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter the name" required>
                </div>
            </div>
            <div class="col">
                <div class="form-row mb-3">
                    <label for="days" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter the email" required>
                </div>
            </div>
            <div class="col">
                <div class="form-row mb-3">
                    <label for="days" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter the phone number">
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="days" class="form-label">Message</label>
            <textarea type="text" class="form-control" id="message" name="message" placeholder="Enter the message"></textarea>
        </div>


        <div class="mb-5">
        <button type="submit" class="btn btn-primary float-end">Send</button>
        </div>
    </form>
</div>

@include('Includes.footer')

@include('Includes.footerscripts')
<script>
    // Ensure the iframe takes the full height of the viewport
    function resizeIframe() {
        var iframe = document.getElementById("bookingIframe");
        iframe.style.height = window.innerHeight + "px";
    }

    // Call resize on page load and on window resize
    window.onload = resizeIframe;
    window.onresize = resizeIframe;

    // Scroll-to-top button logic
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
