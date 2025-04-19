<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Http\Controllers\TripController;
use App\Http\Controllers\SpendingController;
// use App\Http\Controllers\TranslationController;
// use App\Http\Controllers\HotelController;
// use App\Http\Controllers\ReviewController;
// use App\Http\Controllers\JournalController;
// use App\Http\Controllers\ViewJournalController;
// use App\Http\Controllers\PlaceController;
// use App\Http\Controllers\SupportController;
use App\Models\Places;
use App\Models\Review;
use App\Models\SiteCustomization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    $famousplace = Places::with('images')
    ->where('status', 1)
    ->orderBy('created_at', 'desc') // Sort by created_at in descending order
    ->get();
    $reviews = Review::where('status', 1)->get();
    $site = SiteCustomization::where('status', 1)->get();
    $notificationCount = $famousplace->count(); // Count new notifications

    $welcomeMessage = null;
    if (Auth::check()) {
        if (!Session::has('welcome_shown')) {
            $welcomeMessage = 'Welcome back, ' . Auth::user()->name . '!';
            Session::put('welcome_shown', true);
        }
    } else {
        $welcomeMessage = 'Please log in to see notifications.';
    }

    return view('welcome', [
        'famousplace' => $famousplace,
        'reviews' => $reviews,
        'site' => $site,
        'welcomeMessage' => $welcomeMessage,
        'notificationCount' => $notificationCount,
    ]);
})->name('welcome');

Route::post('/mark-notifications-read', [NotificationController::class, 'markAsRead']);

Route::get('/place/{id}', [PlaceController::class, 'show'])->name('place');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/trip-plan', function () {
    return view('trip-plan');
})->name('trip.plan');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/emergency-assistant', function () {
    return view('emergency-assistant');
})->name('emergency-assistant');

Route::get('/locator', function () {
    return view('locator');
})->name('locator');

Route::get('/journal/{id}', [ViewJournalController::class, 'showProfile'])->name('journal.detail')->middleware('auth');
Route::get('/journal-detail/{id}', [ViewJournalController::class, 'showProfile'])->name('journal-detail');
Route::get('/gallery/{id}', [ViewJournalController::class, 'showGallery'])->name('gallery');


Route::get('/create-journal', function () {
    return view('create-journal');
})->name('create-journal');

Route::get('/booking', function () {
    return view('booking');
})->name('booking');
Route::get('/booking', [HotelController::class, 'index']);

Route::get('/plan-your-trip', [TripController::class, 'showForm'])->name('trip.form');
Route::post('/plan-your-trip', [TripController::class, 'processForm'])->name('trip.process');

Route::get('/language-translator', [TranslationController::class, 'showForm'])->name('translator.form');
Route::post('/language-translator', [TranslationController::class, 'translate'])->name('translator.translate');


Route::get('/booking', [HotelController::class, 'index'])->name('booking');

Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');
Route::post('/support', [SupportController::class, 'store'])->name('support.store');


Route::get('/journals/create', [JournalController::class, 'create'])->middleware('auth')->name('journals.create');
Route::post('/journals', [JournalController::class, 'store'])->middleware('auth')->name('journals.store');
Route::get('/view-journal', [JournalController::class, 'index'])->name('view-journal');

Route::get('/spending', [SpendingController::class, 'index'])->name('spending.index')->middleware('auth');
Route::post('/spending/store', [SpendingController::class, 'store'])->name('spending.store')->middleware('auth');
