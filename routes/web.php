<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\PagesController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\TranslationController;
use App\Http\Controllers\Dashboard\SectionsController;
use App\Http\Controllers\Dashboard\ServicesController;
use App\Http\Controllers\Dashboard\InquiriesController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\SlidersController;
use App\Http\Controllers\Dashboard\CompaniesController;
use App\Http\Controllers\Dashboard\StatisticsController;
use App\Http\Controllers\Dashboard\NewsController;
use App\Http\Controllers\Dashboard\CertificatesController;
use App\Http\Controllers\Dashboard\PoliciesController;
use App\Http\Controllers\Dashboard\ProjectsController;
use App\Http\Controllers\Dashboard\SurfaceTreatmentsController;
use App\Http\Controllers\Dashboard\TreatmentFeaturesController;
use App\Http\Controllers\Dashboard\ClientsController;
use App\Http\Controllers\Dashboard\FinishesController;
use App\Http\Controllers\Dashboard\PatternsController;
use App\Http\Controllers\Dashboard\ColorsController;
use App\Http\Controllers\Dashboard\SizesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProductsBySizeController;
use App\Http\Controllers\Web\NavigationController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {
    Route::get('/', function () {
        $urlWithAnchor = '/admin/login';
        return Redirect::to($urlWithAnchor)->with('url', $urlWithAnchor);
    });
    Auth::routes();
    Route::group(['middleware' => 'auth'], function () {
        Route::get('home', [HomeController::class, 'home'])->name('home');
        Route::get('pages/{slug}', [PagesController::class, 'edit']);
        Route::put('pages/{slug}', [PagesController::class, 'update'])->name('pages.update');
        Route::get('sections/{slug}', [SectionsController::class, 'edit'])->name('sections.edit');
        Route::put('sections/{slug}', [SectionsController::class, 'update'])->name('sections.update');
        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::patch('profile/{id}', [UserController::class, 'updateProfile'])->name('profile.update');

        Route::resource('categories', CategoriesController::class);
        Route::resource('news', NewsController::class);
        Route::resource('sliders', SlidersController::class);
        Route::resource('certificates', CertificatesController::class);
        Route::resource('companies', CompaniesController::class);
        Route::resource('statistics', StatisticsController::class);
        Route::resource('policies', PoliciesController::class);
        Route::resource('services', ServicesController::class);
        Route::resource('projects', ProjectsController::class);
        Route::get('projects-gallery', [ProjectsController::class, 'gallery'])->name('projects.gallery');
        Route::post('projects-gallery', [ProjectsController::class, 'saveGallery'])->name('gallery');
        Route::delete('/delete-image/{id}', [ProjectsController::class, 'deleteImage'])->name('delete-image');

        Route::resource('treatments', SurfaceTreatmentsController::class);
        Route::resource('treatment-features', TreatmentFeaturesController::class);
        Route::resource('clients', ClientsController::class);
        Route::resource('finishes', FinishesController::class);
        Route::resource('colors', ColorsController::class);
        Route::resource('patterns', PatternsController::class);
        Route::resource('sizes', SizesController::class);
        Route::resource('products', ProductsController::class);
        Route::delete('/delete-product-image/{id}', [ProductsController::class, 'deleteImage'])->name('delete-image');
        Route::resource('products-by-size', ProductsBySizeController::class);
        Route::resource('settings', SettingsController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('inquiries', InquiriesController::class);
        Route::resource('translation',TranslationController::class);
    });
});

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::get('/', [NavigationController::class, 'home']);
    Route::get('/download-brochure/{fileid}/{filename}', function ($fileid, $filename) {
        $path = public_path('media/' . $fileid . '/' . $filename);
        if (file_exists($path)) {
            return response()->download($path);
        } else {
            abort(404, $path);
        }
    })->name('download.brochure');
    Route::get('search', [ NavigationController::class, 'search'])->name('search');
    Route::get('/download-catalogue/{id}', [ NavigationController::class, 'download_catalogue'])->name('download.catalogue');
    Route::get('products/by-size', [NavigationController::class, 'productsBySize'])->name('products.by-size');
    Route::get('products/by-category/{slug}', [NavigationController::class, 'products'])->name('products.by-category');
    Route::get('products/{slug}', [NavigationController::class, 'productDetails'])->name('products.details');
    Route::get('/download-product-file/{file}', [ NavigationController::class, 'download_product_file'])->name('download.product.file');
    Route::get('about-us', [NavigationController::class, 'aboutUs'])->name('aboutUs');
    Route::get('services', [NavigationController::class, 'services'])->name('services');
    Route::get('projects', [NavigationController::class, 'projects'])->name('projects');
    Route::get('gallery-load-more', [NavigationController::class, 'galleryLoadMore'])->name('gallery.load-more');
    Route::get('treatments', [NavigationController::class, 'treatments'])->name('treatments');
    Route::get('clients', [NavigationController::class, 'clients'])->name('clients');
    Route::get('blogs', [NavigationController::class, 'news'])->name('blogs');
    Route::get('blogs/{slug}', [NavigationController::class, 'newsDetails'])->name('blog-details');
    Route::post('/update-last-read', [NavigationController::class, 'updateLastRead'])->name('update.blogs.last_read');
    Route::get('contact-us', [NavigationController::class, 'contactUs'])->name('contactUs');
    Route::post('contact-us', [NavigationController::class, 'submitForm'])->name('submitForm');
    Route::get('inquiry', [NavigationController::class, 'inquiry'])->name('inquiry');
    Route::post('inquiry', [NavigationController::class, 'submitForm'])->name('inquirySubmitForm');
    Route::get('tailor-made-design', [NavigationController::class, 'tailorMade'])->name('tailorMadeDesign');
    Route::post('tailor-made-inquiry', [NavigationController::class, 'submitForm'])->name('tailorMadeSubmitForm');
    Route::get('thank-you', [NavigationController::class, 'thankYou'])->name('thank-you');
    Route::get('privacy-policy', [NavigationController::class, 'privacyPolicy'])->name('privacy');
    Route::get('terms-and-conditions', [NavigationController::class, 'termsAndConditions'])->name('terms');

});

