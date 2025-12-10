<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

use App\Http\Controllers\Public\NewsController;

Route::get('/', [NewsController::class, 'home'])->name('home');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::middleware(['auth:web', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::middleware(['role:admin|pr'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
        Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class);
        Route::resource('themes', \App\Http\Controllers\Admin\ThemeController::class);
        Route::resource('intro-pages', \App\Http\Controllers\Admin\IntroPageController::class);
        Route::resource('popups', \App\Http\Controllers\Admin\PopupController::class);
        Route::resource('sitemap-categories', \App\Http\Controllers\Admin\SitemapCategoryController::class);
        Route::resource('sitemaps', \App\Http\Controllers\Admin\SitemapController::class);
        Route::post('translate', [\App\Http\Controllers\Admin\TranslationController::class, 'translate'])->name('translate');
    });
});

Route::get('/doctors', [\App\Http\Controllers\Public\DoctorController::class, 'index'])->name('doctors.index');
Route::get('/search/suggest', [\App\Http\Controllers\Public\SearchController::class, 'suggest'])->name('search.suggest');

// Menu Placeholders
Route::get('/hospital-info', function () {
    return Inertia::render('ComingSoon', ['title' => 'Hospital Information']);
})->name('hospital.info');
Route::get('/services', function () {
    return Inertia::render('ComingSoon', ['title' => 'Public Services']);
})->name('services');
Route::get('/departments', function () {
    return Inertia::render('ComingSoon', ['title' => 'Hospital Departments']);
})->name('departments');
Route::get('/research', function () {
    return Inertia::render('ComingSoon', ['title' => 'Research & Academic']);
})->name('research');
Route::get('/facilities', function () {
    return Inertia::render('ComingSoon', ['title' => 'Facilities']);
})->name('facilities');
Route::get('/donation', function () {
    return Inertia::render('ComingSoon', ['title' => 'Donation Fund']);
})->name('donation');
Route::get('/careers', function () {
    return Inertia::render('ComingSoon', ['title' => 'Careers']);
})->name('careers');
Route::get('/procurement', function () {
    return Inertia::render('ComingSoon', ['title' => 'Procurement']);
})->name('procurement');
Route::get('/suggestions', function () {
    return Inertia::render('ComingSoon', ['title' => 'Suggestions']);
})->name('suggestions');
Route::get('/pr', function () {
    return Inertia::render('ComingSoon', ['title' => 'Public Relations']);
})->name('pr');
Route::get('/map', function () {
    return Inertia::render('ComingSoon', ['title' => 'Map']);
})->name('map');

Route::get('/sitemap', [\App\Http\Controllers\Public\SitemapController::class, 'index'])->name('sitemap');

require __DIR__ . '/settings.php';
