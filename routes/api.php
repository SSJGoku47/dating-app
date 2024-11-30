<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;


// Mobile API routes

Route::prefix('mobile')->group(function () {

    /**
     * Authentication APIs
     */
    Route::post('/login', [AuthController::class, 'mobileLogin']);
    Route::post('/social-login', [AuthController::class, 'socialLogin']);
    Route::post('/register', [AuthController::class, 'mobileRegister']);
    Route::post('/logout', [AuthController::class, 'mobileLogout']);
    Route::post('/password/send-otp', [AuthController::class, 'sendOtp']);
    Route::post('/password/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/password/reset', [AuthController::class, 'mobilePasswordReset']);

    // Social Login routes
    Route::get('/social_login/{provider}',[AuthController::class, 'redirectToProvider']);
    Route::get('/social_login/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

    /**
     * Protected APIs auth:api middleware
     */
    Route::middleware('auth:api')->group(function () {

        // Profile Management
        Route::post('/profile', [ProfileController::class, 'updateProfile']);
        Route::get('/profile/education-options', [ProfileController::class, 'getEducationOptions']);
        Route::get('/get/ethnicities', [ProfileController::class, 'getEthnicities']);
        Route::post('/profile/ethnicity', [ProfileController::class, 'setUserEthnicity']);
        Route::post('/profile/education', [ProfileController::class, 'setEducation']);
        Route::post('/profile/image/upload', [ProfileController::class, 'uploadProfileImage']);
        Route::get('/profile/avatar-images', [ProfileController::class, 'getAvatarOptions']);
        Route::post('/profile/picture', [ProfileController::class, 'uploadProfilePicture']);
        Route::post('/profile/picture/primary', [ProfileController::class, 'primaryProfilePicture']);
        Route::post('/profile/bio', [ProfileController::class, 'setProfileBio']);

        // Preferences
        Route::get('/get/genders', [ProfileController::class, 'getGenders']);
        Route::post('/preferences/gender', [ProfileController::class, 'setGenderPreference']);
        Route::get('/get/goals', [ProfileController::class, 'getGoals']);
        Route::post('/preferences/goals', [ProfileController::class, 'setGoals']);
        Route::get('/get/hobbies', [ProfileController::class, 'getHobbies']);
        Route::post('/preferences/hobbies', [ProfileController::class, 'setHobbies']);
        Route::get('/get/characteristics', [ProfileController::class, 'getCharacteristics']);
        Route::post('/preferences/characteristics', [ProfileController::class, 'setCharacteristics']);

        // Q&A
        Route::get('/qna/questions', [QnaController::class, 'getQuestions']);
        Route::get('/user/qna/answered', [QnaController::class, 'getAnsweredQuestions']);
        Route::post('/qna/user/answers', [QnaController::class, 'userAnswers']);

        // Matches & Interactions
        Route::get('/user/matches/potentialmatch', [MatchController::class, 'getPotentialMatchProfiles']);
        Route::get('/user/matches/getAll', [MatchController::class, 'getAllProfiles']);
        Route::post('/user/matches/swipe', [MatchController::class, 'swipeProfile']);
        Route::get('/user/matches/status', [MatchController::class, 'getMatchStatus']);
        Route::post('/user/chat/start', [MatchController::class, 'startChat']);
        Route::post('/user/chat/message', [MatchController::class, 'sendMessage']);
        Route::get('/user/chat/history', [MatchController::class, 'getChatHistory']);
        
        // Filters
        Route::get('/user/matches/filters', [MatchController::class, 'profileFilter']);
    });
});

// web routes

Route::middleware('auth:api')->prefix('auth')->group(function () {

    // Get all users 
    Route::get('admin/user/getAll', [DashboardController::class, 'getAllUsers']);
    Route::get('admin/user/get/{id}', [DashboardController::class, 'getUserView']);
    Route::post('admin/user/deactivate/{id}', [DashboardController::class, 'deactivateUser']);
    Route::post('admin/user/delete/{id}', [DashboardController::class, 'deleteUser']);

    // Q&A
    Route::get('admin/get/questions', [QnaController::class, 'index']); 
    Route::post('admin/create/questions', [QnaController::class, 'createQuestion']); 
    Route::get('admin/view/questions/{id}', [QnaController::class, 'getQuestion']); 
    Route::put('admin/update/questions/{id}', [QnaController::class, 'updateQuestion']);  
    Route::delete('admin/delete/questions/{id}', [QnaController::class, 'deleteQuestion']);  
    
    // Admin users
    Route::get('admin/get/{id}', [DashboardController::class, 'getAdmin']);
    Route::post('admin/update/{id}', [DashboardController::class, 'updateAdmin']);



});
