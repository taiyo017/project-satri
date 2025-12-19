<?php

use App\Http\Controllers\CareerApplicationController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\CareerController as FrontendCareerController;
use App\Http\Controllers\Frontend\CourseController as FrontendCourseController;
use App\Http\Controllers\GalleryCategoryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectionFieldController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\TwoFactorLoginController;
use App\Http\Controllers\Auth\VerifyEmailController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('frontend.page.show', 'home');
})->name('frontend.home');
Route::post('/contact-submit', [ContactController::class, 'submit'])
    ->name('contact.submit')->middleware('throttle:3, 60');;

Route::middleware('auth')->group(function () {

    Route::resource('dashboard', DashboardController::class)
        ->only(['index'])
        ->names([
            'index' => 'dashboard'
        ]);


    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update');

    //Pages
    Route::resource('pages', PageController::class);

    // Sections Routes
    Route::post('pages/{page}/sections', [SectionController::class, 'store'])
        ->name('pages.sections.store');

    Route::put('sections/{section}', [SectionController::class, 'update'])
        ->name('sections.update');

    Route::delete('sections/{section}', [SectionController::class, 'destroy'])
        ->name('sections.destroy');

    Route::post('sections/{section}/reorder', [SectionController::class, 'reorder'])
        ->name('sections.reorder');

    // Section Fields Routes
    Route::put('sections/{section}/fields/{field}', [SectionFieldController::class, 'update'])
        ->name('sections.fields.update');

    Route::post('sections/fields/{field}/upload', [SectionFieldController::class, 'upload'])
        ->name('sections.fields.upload');

    Route::post('sections/{section}/fields/repeater', [SectionFieldController::class, 'addRepeaterItem'])
        ->name('sections.fields.repeater.add');

    Route::delete('sections/fields/{field}/repeater/{itemId}', [SectionFieldController::class, 'deleteRepeaterItem'])
        ->name('sections.fields.repeater.delete');

    //Services
    Route::resource('services', ServiceController::class);

    //Projects
    Route::resource('projects', ProjectController::class);

    //Team Members
    Route::resource('team-members', TeamMemberController::class);

    //FAQs
    Route::resource('faqs', FaqController::class)->except('show');

    // Contact List
    Route::get('/contacts', [ContactController::class, 'index'])
        ->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])
        ->name('contacts.show');
    Route::post('/contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])
        ->name('contacts.markRead');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])
        ->name('contacts.destroy');
    Route::get('/contacts/export', [ContactController::class, 'export'])
        ->name('contacts.export');
    Route::get('/contacts/{contact}/reply', [ContactController::class, 'reply'])
        ->name('contacts.reply');
    Route::post('/contacts/{contact}/reply', [ContactController::class, 'reply'])
        ->name('contacts.reply.send');

    //Courses
    Route::resource('course-categories', CourseCategoryController::class);
    Route::resource('courses', CourseController::class);

    //Careers
    Route::resource('careers', CareerController::class);
    Route::get('careers/{career}/applications', [CareerController::class, 'applications'])->name('careers.applications');

    // Optional: mark application as read
    Route::post('applications/{application}/mark-read', [CareerController::class, 'markApplicationRead'])->name('applications.markRead');

    // Optional: forward email to applicant
    Route::post('careers/{application}/forward-email', [CareerController::class, 'forwardEmail'])->name('applications.forwardEmail');
    Route::get('careers/{career}/applications/export', [CareerApplicationController::class, 'export'])
        ->name('applications.export');

    // Gallery CRUD

    Route::prefix('galleries')->group(function () {
        // AJAX endpoint to fetch trash items
        Route::get('trash-list', [GalleryController::class, 'trashIndex'])->name('galleries.trash.index');

        // Bulk operations
        Route::delete('bulk-trash', [GalleryController::class, 'bulkTrash'])->name('galleries.bulk-trash');
        Route::delete('empty-trash', [GalleryController::class, 'emptyTrash'])->name('galleries.trash.empty');

        // Single item operations
        Route::delete('{id}/trash', [GalleryController::class, 'trash'])->name('galleries.trash');
        Route::post('{id}/restore', [GalleryController::class, 'restore'])->name('galleries.restore');
        Route::delete('{id}/force-delete', [GalleryController::class, 'forceDelete'])->name('galleries.force-delete');
    });
    Route::resource('galleries', GalleryController::class)->where(['gallery' => '[0-9]+']);

    // Gallery Category CRUD
    Route::resource('gallery-categories', GalleryCategoryController::class);

    //2FA enabling 
    Route::post('/settings/2fa', [ProfileController::class, 'toggleTwoFactor'])->name('settings.2fa');
});


//Login Routes
Route::get('/auth/admin', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
Route::post('/auth/admin', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/two-factor-login', [TwoFactorLoginController::class, 'index'])->name('two-factor.login');
Route::post('/two-factor-login', [TwoFactorLoginController::class, 'store'])->name('two-factor.login.submit');

// Password Reset
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.store');

Route::get('/verify-email', EmailVerificationPromptController::class)->middleware('auth')->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

//Confirmable Password
Route::put('/update-password', [PasswordController::class, 'update'])->middleware('auth')->name('password.update');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth');

//Frontend Routes
Route::get('/{slug}', [FrontendPageController::class, 'show'])->name('frontend.page.show');
Route::get('/career/{slug}', [FrontendCareerController::class, 'show'])->name('career.show');
Route::get('/course/{slug}', [FrontendCourseController::class, 'show'])->name('course.show');
Route::post('/careers/{career}/apply', [CareerApplicationController::class, 'store'])
    ->name('careers.apply')->middleware('throttle:3, 60');;
