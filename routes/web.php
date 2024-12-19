<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'account'], function() {
    // Redirect authenticated users away from login and register pages
    Route::middleware([RedirectIfAuthenticated::class])->group(function () {
        Route::get('login', [LoginController::class, 'index'])->name('account.login');
        Route::get('register', [LoginController::class, 'register'])->name('account.register');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
        Route::post('Processregister', [LoginController::class, 'Processregister'])->name('account.Processregister');
        Route::get('register-trainer', [LoginController::class, 'registerTrainer'])->name('register-trainer');
        Route::post('register-trainer', [LoginController::class, 'processTrainerRegistration'])->name('account.processTrainerRegister');


    });

    // Authenticated users
    Route::middleware([AuthenticateMiddleware::class])->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');
        // Profile
        Route::get('profile', [ProfileController::class, 'profile'])->name('account.profile');
        Route::put('account/update', [ProfileController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('verify-phone', [ProfileController::class, 'verifyPhonePage'])->name('phone.verification');
        Route::post('profile/verify-phone', [ProfileController::class, 'verifyPhone'])->name('profile.verifyPhone');
        Route::post('account/change-password', [ProfileController::class, 'changePassword'])->name('account.changePassword');

        // Home
        Route::get('/user-home', [HomeController::class, 'index'])->name('account.home');

        // Messages 
        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('chat/{trainerId}/{userId}', [MessageController::class, 'fetchMessages'])->name('chat.index');
        Route::post('chat/{trainerId}/{userId}', [MessageController::class, 'sendMessage'])->name('chat.send');
        // Trainer
        Route::get('home-trainer/info', [TrainerController::class, 'create'])->name('homeTrainer');
        Route::get('/trainer/image/{filename}', [TrainerController::class, 'showImage'])->name('trainer.image');
        Route::post('home-trainer/store', [TrainerController::class, 'store'])->name('account.storeTrainer');
        Route::get('home-sessions', [TrainerController::class, 'show'])->name('account.sessions');
        Route::get('home', [TrainerController::class, 'home'])->name('home.trainers');
        Route::get('applications', [TrainerController::class, 'showApplications'])->name('applications.show');
        Route::get('home-trainer/course', [TrainerController::class, 'course'])->name('courseTrainer');
        Route::post('application/approve/{application}', [TrainerController::class, 'approve'])->name('application.approve');
        Route::post('application/reject/{application}', [TrainerController::class, 'reject'])->name('application.reject');
        // Cosurse 
        Route::get('trainer/courses/create', [CourseController::class, 'create'])->name('courseTrainer.create');
        Route::post('trainer/courses', [CourseController::class, 'store'])->name('courseTrainer.store');
        Route::get('trainer/courses', [CourseController::class, 'getApprovedCoursesForTrainer'])->name('trainer.approvedCourses');
        Route::get('courses/{course}', [CourseController::class, 'show'])->name('course.details');

        // Sessions
        Route::get('trainer/session/create', [SessionController::class, 'create'])->name('session.create');
        Route::post('trainer/session/store', [SessionController::class, 'store'])->name('session.store');
        Route::get('trainer/sessions', [SessionController::class, 'showSessions'])->name('session.show');
        Route::get('sessions', [SessionController::class, 'showAvailableSessions'])->name('sessions.index');
        Route::post('sessions/apply/{session}', [SessionController::class, 'applyForSession'])->name('session.apply');
        Route::patch('/sessions/{session}/end', [SessionController::class, 'endSession'])->name('session.end');
        Route::get('sessions/{sessionId}/review', [ReviewController::class, 'create'])->name('review.create');

        // Store the review after the user submits it
        Route::post('sessions/{sessionId}/review', [ReviewController::class, 'store'])->name('review.store');
        
    // Admin-only access to dashboard
    Route::middleware([CheckAdmin::class])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('pending-courses', [DashboardController::class, 'pendingCourses'])->name('admin.pending-courses');
        Route::post('course/approve/{course}', [CourseController::class, 'approve'])->name('admin.approve');
        Route::post('course/reject/{course}', [CourseController::class, 'reject'])->name('admin.reject');
        Route::get('trainer/details/{trainer}', [DashboardController::class, 'viewTrainerDetails'])->name('admin.trainer.details');
        Route::get('pending-sessions', [DashboardController::class, 'showPendingSessions'])->name('admin.pending-sessions');
        Route::post('session/approve/{session}', [SessionController::class, 'approve'])->name('admin.sessions.accept');
        Route::post('session/reject/{session}', [SessionController::class, 'reject'])->name('admin.sessions.reject');
        Route::get('/admin/sessions/{session}/details', [DashboardController::class, 'showSessionDetails'])->name('admin.sessions.details');
        Route::get('/admin/users', [DashboardController::class, 'showUsers'])->name('admin.users');

    });
        
    });
});
