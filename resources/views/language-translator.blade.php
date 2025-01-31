@include('Includes.header')
@include('Includes.top-navbar')

<div class="container translator-container mt-5">
    <h1 class="about_taital text-center mb-5">Language Translation</h1>
    <div class="row">
        <div class="col-md-6">
            <!-- Translation Form -->
            <form action="{{ route('translator.translate') }}" method="POST" class="translator-form">
                @csrf
                <div class="form-group mb-3">
                    <label for="text" class="form-label">Text to Translate:</label>
                    <textarea name="text" id="text" rows="5" class="form-control" placeholder="Enter text to translate..." required></textarea>
                </div>
                <div class="form-group mb-4">
                    <label for="language" class="form-label">Target Language:</label>
                    <!-- Select2 dropdown for selecting language -->
                    <select name="language" id="language" class="form-control">
                        <option value="af">Afrikaans</option>
                        <option value="sq">Albanian</option>
                        <option value="ar">Arabic</option>
                        <option value="hy">Armenian</option>
                        <option value="bn">Bengali</option>
                        <option value="bs">Bosnian</option>
                        <option value="ca">Catalan</option>
                        <option value="hr">Croatian</option>
                        <option value="cs">Czech</option>
                        <option value="da">Danish</option>
                        <option value="nl">Dutch</option>
                        <option value="en">English</option>
                        <option value="eo">Esperanto</option>
                        <option value="et">Estonian</option>
                        <option value="fi">Finnish</option>
                        <option value="fr">French</option>
                        <option value="de">German</option>
                        <option value="el">Greek</option>
                        <option value="gu">Gujarati</option>
                        <option value="he">Hebrew</option>
                        <option value="hi">Hindi</option>
                        <option value="hu">Hungarian</option>
                        <option value="is">Icelandic</option>
                        <option value="id">Indonesian</option>
                        <option value="it">Italian</option>
                        <option value="ja">Japanese</option>
                        <option value="jw">Javanese</option>
                        <option value="kn">Kannada</option>
                        <option value="km">Khmer</option>
                        <option value="ko">Korean</option>
                        <option value="la">Latin</option>
                        <option value="lv">Latvian</option>
                        <option value="lt">Lithuanian</option>
                        <option value="mk">Macedonian</option>
                        <option value="ml">Malayalam</option>
                        <option value="mr">Marathi</option>
                        <option value="my">Myanmar (Burmese)</option>
                        <option value="ne">Nepali</option>
                        <option value="no">Norwegian</option>
                        <option value="or">Odia</option>
                        <option value="ps">Pashto</option>
                        <option value="fa">Persian</option>
                        <option value="pl">Polish</option>
                        <option value="pt">Portuguese</option>
                        <option value="pa">Punjabi</option>
                        <option value="ro">Romanian</option>
                        <option value="ru">Russian</option>
                        <option value="sr">Serbian</option>
                        <option value="si">Sinhala</option>
                        <option value="sk">Slovak</option>
                        <option value="sl">Slovenian</option>
                        <option value="es">Spanish</option>
                        <option value="su">Sundanese</option>
                        <option value="sw">Swahili</option>
                        <option value="sv">Swedish</option>
                        <option value="ta">Tamil</option>
                        <option value="te">Telugu</option>
                        <option value="th">Thai</option>
                        <option value="tr">Turkish</option>
                        <option value="uk">Ukrainian</option>
                        <option value="ur">Urdu</option>
                        <option value="vi">Vietnamese</option>
                        <option value="cy">Welsh</option>
                        <option value="xh">Xhosa</option>
                        <option value="yi">Yiddish</option>
                        <option value="yo">Yoruba</option>
                        <option value="zu">Zulu</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100">Translate</button>
            </form>
        </div>

        <div class="col-md-6 mt-5 mt-md-0">
            <!-- Display Translated Text -->
            @if(isset($translatedText))
            <div class="translated-text-container p-4 shadow-sm rounded bg-white">
                <h2 class="translated-title">Translated Text:</h2>
                <p class="translated-text">{{ $translatedText }}</p>
            </div>
            @endif
        </div>
    </div>
</div>

<button id="scrollToTopBtn" class="scroll-to-top" onclick="scrollToTopFunction()">
        <i class="bi bi-arrow-up-circle-fill"></i>
    </button>

@include('Includes.footer')
@include('Includes.footerscripts')

<script>
    $(document).ready(function() {
        // Initialize Select2 for the language dropdown
        $('#language').select2({
            placeholder: 'Select a language',
            width: '100%'
        });
    });
</script>

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
