<?php

use Illuminate\Support\Facades\Route;

use App\Models\Escort;
use App\Http\Controllers\EscortController;
use App\Http\Controllers\EstablishmentController;


Route::get('/', function (\Illuminate\Http\Request $request) {
    $city = $request->input('city');
    $search = $request->input('q');

    $diamondQuery = \App\Models\Publication::where('is_active', true)
        ->whereHas('escort', function ($query) {
            $query->where('level', 'diamante')->where('is_active', true);
        });

    $silverQuery = \App\Models\Publication::where('is_active', true)
        ->whereHas('escort', function ($query) {
            $query->where('level', 'plata')->where('is_active', true);
        });

    $generalQuery = \App\Models\Publication::where('is_active', true)
        ->whereHas('escort', function ($query) {
            $query->whereIn('level', ['general', 'standard', ''])->orWhereNull('level')->where('is_active', true);
        });

    if ($city) {
        $diamondQuery->where('city', $city);
        $silverQuery->where('city', $city);
        $generalQuery->where('city', $city);
    }

    $province = $request->input('province');
    $district = $request->input('district');

    if ($province) {
        $diamondQuery->where('province', $province);
        $silverQuery->where('province', $province);
        $generalQuery->where('province', $province);
    }

    if ($district) {
        $diamondQuery->where('district', $district);
        $silverQuery->where('district', $district);
        $generalQuery->where('district', $district);
    }

    if ($search) {
        $searchTerm = '%' . strtolower($search) . '%';
        $searchClosure = function($q) use ($searchTerm) {
            $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
              ->orWhereRaw('LOWER(city) LIKE ?', [$searchTerm])
              ->orWhereHas('escort', function($q2) use ($searchTerm) {
                  $q2->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                     ->orWhereRaw('LOWER(description) LIKE ?', [$searchTerm]);
              });
        };
        $diamondQuery->where($searchClosure);
        $silverQuery->where($searchClosure);
        $generalQuery->where($searchClosure);
    }

    $gender = $request->input('gender');
    $currency = $request->input('currency');
    $categories = $request->input('category');
    $services = $request->input('services');
    $attendsIn = $request->input('attends_in');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');

    if ($minPrice !== null && $maxPrice !== null) {
        $priceClosure = function($q) use ($minPrice, $maxPrice) {
            $q->whereBetween('price', [(float)$minPrice, (float)$maxPrice]);
        };
        $diamondQuery->whereHas('escort', $priceClosure);
        $silverQuery->whereHas('escort', $priceClosure);
        $generalQuery->whereHas('escort', $priceClosure);
    }

    if ($gender) {
        $genderClosure = function($q) use ($gender) {
            $q->where('gender', $gender);
        };
        $diamondQuery->whereHas('escort', $genderClosure);
        $silverQuery->whereHas('escort', $genderClosure);
        $generalQuery->whereHas('escort', $genderClosure);
    }

    if ($currency) {
        $currencyClosure = function($q) use ($currency) {
            $q->where('currency', $currency);
        };
        $diamondQuery->whereHas('escort', $currencyClosure);
        $silverQuery->whereHas('escort', $currencyClosure);
        $generalQuery->whereHas('escort', $currencyClosure);
    }

    if (!empty($categories) && is_array($categories)) {
        $categoryClosure = function($q) use ($categories) {
            $q->whereIn('category', $categories);
        };
        $diamondQuery->whereHas('escort', $categoryClosure);
        $silverQuery->whereHas('escort', $categoryClosure);
        $generalQuery->whereHas('escort', $categoryClosure);
    }

    if (!empty($services) && is_array($services)) {
        $servicesClosure = function($q) use ($services) {
            foreach ($services as $service) {
                $q->whereJsonContains('services', $service);
            }
        };
        $diamondQuery->whereHas('escort', $servicesClosure);
        $silverQuery->whereHas('escort', $servicesClosure);
        $generalQuery->whereHas('escort', $servicesClosure);
    }

    if (!empty($attendsIn) && is_array($attendsIn)) {
        $attendsInClosure = function($q) use ($attendsIn) {
            foreach ($attendsIn as $attend) {
                $q->whereJsonContains('attends_in', $attend);
            }
        };
        $diamondQuery->whereHas('escort', $attendsInClosure);
        $silverQuery->whereHas('escort', $attendsInClosure);
        $generalQuery->whereHas('escort', $attendsInClosure);
    }

    $diamondPublications = $diamondQuery->with(['escort.reviews'])->latest('updated_at')->get();
    $silverPublications = $silverQuery->with(['escort.reviews'])->latest('updated_at')->get();
    $generalPublications = $generalQuery->with(['escort.reviews'])->latest('updated_at')->get();

    return view('welcome', compact('diamondPublications', 'silverPublications', 'generalPublications', 'city'));
});

Route::get('/porque-elegirnos', function () {
    $featuredEscorts = Escort::where('level', 'diamante')->where('is_active', true)->with('reviews')->inRandomOrder()->limit(8)->get();
    return view('why-choose-us', compact('featuredEscorts'));
})->name('why-choose-us');

Route::get('/escorts', [EscortController::class, 'index'])->name('escorts.index');
Route::post('/escorts/{escort}/whatsapp-click', [EscortController::class, 'trackWhatsappClick'])->name('escorts.whatsapp-click');

Route::get('/profile/{id}', [EscortController::class, 'show'])->name('profile.show');
Route::get('/publicacion/{id}', [App\Http\Controllers\PublicationController::class, 'show'])->name('publications.show');

Route::get('/noticias', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/noticias/{slug}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');





Route::get('/registrarme', function () {
    return view('register');
})->name('register');

Route::get('/login', function () {
    return view('login'); 
})->name('login');

Route::post('/web-login', [App\Http\Controllers\AuthController::class, 'webLogin']);
Route::post('/web-logout', [App\Http\Controllers\AuthController::class, 'webLogout'])->name('logout');

// Password Reset
Route::get('/olvidar-contrasena', [App\Http\Controllers\PasswordResetController::class, 'showForgotForm'])->name('password.request');
Route::post('/olvidar-contrasena', [App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/restablecer-contrasena/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/restablecer-contrasena', [App\Http\Controllers\PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::get('/mi-cuenta', function () {
    return view('user.dashboard');
})->middleware(['auth'])->name('user.dashboard');

Route::post('/favorites/{escort}', [EscortController::class, 'toggleFavorite'])
    ->middleware(['auth'])
    ->name('favorites.toggle');

Route::put('/user/profile', [App\Http\Controllers\UserProfileController::class, 'update'])->middleware(['auth'])->name('user.profile.update');
Route::delete('/user/account', [App\Http\Controllers\UserProfileController::class, 'destroy'])->middleware(['auth'])->name('user.account.destroy');

Route::put('/user/reviews/{review}', [App\Http\Controllers\UserReviewController::class, 'update'])->middleware(['auth'])->name('user.reviews.update');
Route::delete('/user/reviews/{review}', [App\Http\Controllers\UserReviewController::class, 'destroy'])->middleware(['auth'])->name('user.reviews.destroy');

Route::post('/escorts/{escort}/reviews', [EscortController::class, 'storeReview'])->name('reviews.store');

// Dashboard route handled by Filament
// Route::get('/dashboard', function () {
//     if (auth()->user()->isAdmin()) {
//         return redirect('/admin');
//     }
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('/establecimientos', [EstablishmentController::class, 'index'])->name('establishments.index');
Route::get('/establecimiento/{id}', [EstablishmentController::class, 'show'])->name('establishments.show');
Route::post('/establecimiento/{establishment}/reviews', [EstablishmentController::class, 'storeReview'])->middleware(['auth'])->name('establishment.reviews.store');

Route::get('/contacto', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contacto', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

use App\Http\Controllers\PayPalSubscriptionController;

Route::middleware(['auth'])->group(function () {
    Route::get('/paypal/subscribe/{plan_id}', [PayPalSubscriptionController::class, 'createSubscription'])->name('paypal.subscribe');
});

Route::get('/paypal/success', [PayPalSubscriptionController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalSubscriptionController::class, 'cancel'])->name('paypal.cancel');
Route::post('/paypal/webhook', [PayPalSubscriptionController::class, 'webhook'])->name('paypal.webhook');

// Rutas de Rastreo de Visitantes (CRM)
use App\Http\Controllers\VisitorTrackingController;
Route::post('/visitor/track', [VisitorTrackingController::class, 'track'])->name('visitor.track');
Route::post('/visitor/heartbeat', [VisitorTrackingController::class, 'heartbeat'])->name('visitor.heartbeat');
Route::post('/visitor/track-click', [VisitorTrackingController::class, 'trackClick'])->name('visitor.track-click');
Route::post('/visitor/save-whatsapp', [VisitorTrackingController::class, 'saveWhatsApp'])->name('visitor.save-whatsapp');

Route::view('/terminos-y-condiciones', 'legal.terms')->name('legal.terms');
Route::view('/politica-de-privacidad', 'legal.privacy')->name('legal.privacy');