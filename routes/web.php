<?php

use App\Models\PackageCategory;

use Illuminate\Support\Facades\Route;;
use Illuminate\Support\Facades\Artisan;
use Spatie\Honeypot\ProtectAgainstSpam;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\OurServiceController;
use App\Http\Controllers\RecentWorkController;
use App\Http\Controllers\PhotographyController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CinematographyController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\HomePageContentController;
use App\Http\Controllers\PackageCategoryController;
use App\Http\Controllers\frontend\WebsiteServiceController;
use App\Http\Controllers\frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\frontend\HomeController as FrontendHomeController;

// =================================
//CACHE CLEARING ROUTE     //=====
// ===============================
Route::get('/cc', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return redirect()->back()->with('success', 'Cache Cleared Successfully!');
})->name('cache.clear');



// ===============================
// FRONTEND ROUTES         //=====
// ===============================

//Pages
Route::prefix('/')->group(function () {
    Route::get('/', [FrontendHomeController::class, 'index'])->name('home');
    Route::get('about', [FrontendHomeController::class, 'about'])->name('about.page');
    Route::get('photography', [FrontendHomeController::class, 'photography'])->name('photography.page');
    Route::get('cinematography', [FrontendHomeController::class, 'cinematography'])->name('cinematography.page');
    Route::get('contact-us', [FrontendHomeController::class, 'contactUs'])->name('contactUs.page');
    Route::post('contact-store', [FrontendHomeController::class, 'contactStore'])->name('contact.store');
    Route::get('all-service', [FrontendHomeController::class, 'topService'])->name('topService.page');
    Route::get('top-service-details/{slug}', [FrontendHomeController::class, 'topServiceDetails'])->name('topService.details');
    Route::get('photography/{slug}', [FrontendHomeController::class, 'photographyDetails'])->name('photography.details');
    Route::get('package', [FrontendHomeController::class, 'package'])->name('package');
    Route::get('term-and-condition', [FrontendHomeController::class, 'term'])->name('term.page');

    Route::get('division/{slug}/package', [FrontendHomeController::class, 'divisionPackage'])->name('division.package');
    Route::get('/package-details', [FrontendHomeController::class, 'packageDetails'])->name('package.details');
    Route::get('frontend-logout', [FrontendAuthController::class, 'frontendLogout'])->name('frontend.logout');


    // Service Routes
    Route::get('/service/page', [WebsiteServiceController::class, 'index'])->name('service.page');
    Route::get('/service/details/{slug}', [WebsiteServiceController::class, 'details'])->name('service.details');
    Route::get('/cat-wise-service/{slug}', [WebsiteServiceController::class, 'CatWiseService'])->name('CatWiseService');
});

Route::prefix('user')->middleware('auth')->group(function () {
    // ===============================
    // USER MANAGEMENT       //====
    // ===============================

    // Route::post('/update-user-password/{id}', [FrontendHomeController::class, 'update'])->name('update.user.password');
    // Route::get('change-profile', [FrontendHomeController::class, 'changeProfile'])->name('change.profile');
    // Route::get('change-web-password', [FrontendHomeController::class, 'changePassword'])->name('change.web.password');
    // Route::post('customerUpdate/{id}', [FrontendHomeController::class, 'customerUpdate'])->name('change.web.customerUpdate');


});
// ===============================
// AUTHENTICATION ROUTES   //=====
// ===============================
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/store', [AuthController::class, 'store'])->name('store');
    Route::post('/update-user-password/{id}', [ChangePasswordController::class, 'update'])->name('update.user.password');
    // Registration Routes
    Route::get('/register', [RegistrationController::class, 'index'])->name('registration');
    Route::post('/registration/store', [RegistrationController::class, 'store'])->name('registration.store')->middleware(ProtectAgainstSpam::class);
});

// ===============================
// BACKEND ROUTES          //=====
// ===============================
Route::prefix('admin')->middleware('auth', 'admin')->group(function () {

    // ===============================
    // DASHBOARD & CUSTOM PAGES // ===
    // ===============================
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/custom/page', [CustomPageController::class, 'index'])->name('custom.page.index');
    Route::get('/custom/page/edit/{id}', [CustomPageController::class, 'edit'])->name('custom.page.edit');
    Route::post('/custom/page/update/{id}', [CustomPageController::class, 'update'])->name('custom.page.update');

  // ===============================
    // TEAM MANAGEMENT       //====
    // ===============================

    Route::prefix('team')->name('team.')->group(function () {
        Route::get('/create', [TeamController::class, 'create'])->name('create');
        Route::post('/store', [TeamController::class, 'store'])->name('store');
        Route::get('/index', [TeamController::class, 'index'])->name('index');
        Route::get('/edit/{slug}', [TeamController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [TeamController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TeamController::class, 'delete'])->name('destroy');

    });



    // ===============================//
    // AUTH & USER MANAGEMENT         //
    // ===============================//
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('list', [UserController::class, 'index'])->name('list');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::get('delete/{id}', [UserController::class, 'delete'])->name('delete');
        Route::put('update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('show/{id}', [UserController::class, 'show'])->name('show');
    });


    // ===============================//
    // CATEGORY MANAGEMENT            //
    // ===============================//

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('index', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::post('save', [CategoryController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('destroy');
        Route::get('show/{slug}', [CategoryController::class, 'show'])->name('show');
    });


    // ===============================//
    // PACKAGE CATEGORY MANAGEMENT     //
    // ===============================//

    Route::prefix('package-category/')->name('package.category.')->group(function () {
        Route::get('index', [PackageCategoryController::class, 'index'])->name('index');
        Route::get('create', [PackageCategoryController::class, 'create'])->name('create');
        Route::post('save', [PackageCategoryController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [PackageCategoryController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [PackageCategoryController::class, 'update'])->name('update');
        Route::DELETE('delete/{id}', [PackageCategoryController::class, 'delete'])->name('destroy');
        // Route::get('show/{slug}', [PackageCategoryController::class, 'show'])->name('show');
    });

    Route::prefix('division')->name('division.')->group(function () {
        Route::get('index', [DivisionController::class, 'index'])->name('index');
        Route::get('create', [DivisionController::class, 'create'])->name('create');
        Route::post('save', [DivisionController::class, 'store'])->name('store');
        Route::get('edit/{id}', [DivisionController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [DivisionController::class, 'update'])->name('update');
        Route::get('delete/{id}', [DivisionController::class, 'delete'])->name('delete');
    });


    Route::prefix('package')->name('package.')->group(function () {
        Route::get('index', [PackageController::class, 'index'])->name('index');
        Route::get('create', [PackageController::class, 'create'])->name('create');
        Route::post('save', [PackageController::class, 'store'])->name('store');
        Route::get('view/{slug}', [PackageController::class, 'view'])->name('view');
        Route::get('edit/{slug}', [PackageController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [PackageController::class, 'update'])->name('update');
        Route::get('delete/{id}', [PackageController::class, 'delete'])->name('delete');
    });




    // ===============================//
    // CONTACT MANAGEMENT          //
    // ===============================//
    Route::prefix('contact')->name('contact.')->group(function () {
        Route::get('index', [ContactController::class, 'index'])->name('index');
        Route::get('show/{id}', [ContactController::class, 'show'])->name('show');
    });






    // ===============================//
    // SETTINGS & PASSWORD MANAGEMENT //
    // ===============================//
    Route::get('/settings', [SettingController::class, 'index'])->name('setting');
    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change.password');
    Route::post('/update-password/{id}', [ChangePasswordController::class, 'update'])->name('update.password');

    // ===============================//
    // PROFILE MANAGEMENT             //
    // ===============================//
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // ===============================//
    // REGISTRATION UPDATE            //
    // ===============================//
    Route::post('/registration/update/{id}', [RegistrationController::class, 'update'])->name('registration.update');

    // ===============================//
    // ROLE & PERMISSION MANAGEMENT   //
    // ===============================//
    Route::get('/roles', [RolePermissionController::class, 'createRole'])->name('roles.permission.create');
    Route::get('/roles/permission/index', [RolePermissionController::class, 'index'])->name('roles.permission.index');
    Route::post('/roles/store', [RolePermissionController::class, 'storeRole'])->name('store.roles');
    Route::post('/permissions/store', [RolePermissionController::class, 'createPermission'])->name('permissions.create');
    Route::post('/roles/assign', [RolePermissionController::class, 'assignRole'])->name('assign.role');
    Route::post('/permissions/assign', [RolePermissionController::class, 'assignPermission'])->name('assign.permission');




    // ===============================//
    //  Home Page Content Management  //
    // ===============================//
    Route::prefix('home')->group(function () {
        Route::get('/page-content', [HomePageContentController::class, 'index'])->name('home.page.index');
        Route::get('/edit', [HomePageContentController::class, 'edit'])->name('home.page.edit');
        Route::post('/update', [HomePageContentController::class, 'update'])->name('home.page.update');
    });



    // ===============================//
    // SLIDER MANAGEMENT               //
    // ===============================//
    Route::prefix('slider/')->name('slider.')->group(function () {
        Route::get('index', [SliderController::class, 'index'])->name('index');
        Route::get('create', [SliderController::class, 'create'])->name('create');
        Route::post('store', [SliderController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [SliderController::class, 'edit'])->name('edit');
        Route::get('delete/{id}', [SliderController::class, 'delete'])->name('delete');
        Route::put('update/{id}', [SliderController::class, 'update'])->name('update');
    });


    // ===============================//
    // OUR SERVICE                    //
    // ===============================//
    Route::prefix('our-service/')->name('service.')->group(function () {
        Route::get('index', [OurServiceController::class, 'index'])->name('index');
        Route::get('create', [OurServiceController::class, 'create'])->name('create');
        Route::post('store', [OurServiceController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [OurServiceController::class, 'edit'])->name('edit');
        Route::get('delete/{id}', [OurServiceController::class, 'delete'])->name('delete');
        Route::put('update/{id}', [OurServiceController::class, 'update'])->name('update');
    });



    // ===============================//
    // OUR TESTIMONIALS               //
    // ===============================//
    Route::prefix('testimonial/')->name('testimonial.')->group(function () {
        Route::get('index', [TestimonialController::class, 'index'])->name('index');
        Route::get('create', [TestimonialController::class, 'create'])->name('create');
        Route::post('store', [TestimonialController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [TestimonialController::class, 'edit'])->name('edit');
        Route::get('delete/{id}', [TestimonialController::class, 'delete'])->name('delete');
        Route::put('update/{id}', [TestimonialController::class, 'update'])->name('update');
    });


    // ===============================//
    // RECENT WORK                     //
    // ===============================//
    Route::prefix('recent-work/')->name('recent-work.')->group(function () {
        Route::get('index', [RecentWorkController::class, 'index'])->name('index');
        Route::get('create', [RecentWorkController::class, 'create'])->name('create');
        Route::post('store', [RecentWorkController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [RecentWorkController::class, 'edit'])->name('edit');
        Route::delete('delete/{id}', [RecentWorkController::class, 'delete'])->name('destroy');
        Route::put('update/{id}', [RecentWorkController::class, 'update'])->name('update');
    });


    // ===============================//
    // PHOTOGRAPHY                    //
    // ===============================//
    Route::prefix('photography/')->name('photography.')->group(function () {
        Route::get('index', [PhotographyController::class, 'index'])->name('index');
        Route::get('create', [PhotographyController::class, 'create'])->name('create');
        Route::post('store', [PhotographyController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [PhotographyController::class, 'edit'])->name('edit');
        Route::get('delete/{id}', [PhotographyController::class, 'delete'])->name('delete');
        Route::put('update/{id}', [PhotographyController::class, 'update'])->name('update');
    });

    // ===============================//
    // CINEMATOGRAPHY                 //
    // ===============================//
    Route::prefix('cinematographies/')->name('cinematographies.')->group(function () {
        Route::get('index', [CinematographyController::class, 'index'])->name('index');
        Route::get('create', [CinematographyController::class, 'create'])->name('create');
        Route::post('store', [CinematographyController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [CinematographyController::class, 'edit'])->name('edit');
        Route::get('delete/{id}', [CinematographyController::class, 'delete'])->name('delete');
        Route::put('update/{id}', [CinematographyController::class, 'update'])->name('update');
    });
});
