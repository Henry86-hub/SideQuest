<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

// 1. Public / Guest Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/quests', [PublicController::class, 'questBoard'])->name('public.quests');

// 2. Centralized Dashboard Router
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin() || $user->isOfficer()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('member.dashboard');
})->middleware(['auth'])->name('dashboard');

// 3. Member Dashboard Routes
Route::middleware(['auth', 'role:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::post('/quests/{quest}/claim', [MemberController::class, 'claimQuest'])->name('quests.claim');
    Route::get('/quests/{quest}/submit', [MemberController::class, 'submitQuestForm'])->name('quests.submit.form');
    Route::post('/quests/{quest}/submit', [MemberController::class, 'submitQuest'])->name('quests.submit');
    Route::get('/profile', [MemberController::class, 'editProfile'])->name('profile');
    Route::post('/profile', [MemberController::class, 'updateProfile'])->name('profile.update');
});

// 4. Admin & Officer Routes
Route::middleware(['auth', 'role:admin,officer'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Quest CRUD
    Route::get('/quests/create', [AdminController::class, 'createQuest'])->name('quests.create');
    Route::post('/quests/store', [AdminController::class, 'storeQuest'])->name('quests.store');
    Route::get('/quests/{quest}/edit', [AdminController::class, 'editQuest'])->name('quests.edit');
    Route::put('/quests/{quest}', [AdminController::class, 'updateQuest'])->name('quests.update');
    Route::delete('/quests/{quest}', [AdminController::class, 'deleteQuest'])->name('quests.destroy');
    
    // Submissions
    Route::get('/submissions/{submission}/review', [AdminController::class, 'reviewSubmission'])->name('submissions.review');
    Route::post('/submissions/{submission}/approve', [AdminController::class, 'approveSubmission'])->name('submissions.approve');
    Route::post('/submissions/{submission}/reject', [AdminController::class, 'rejectSubmission'])->name('submissions.reject');
    
    // Members Roster
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::post('/members/{user}/adjust', [AdminController::class, 'adjustMember'])->name('members.adjust');
    
    // Announcements
    Route::get('/announcements/create', [AdminController::class, 'createAnnouncement'])->name('announcements.create');
    Route::post('/announcements/store', [AdminController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::delete('/announcements/{announcement}', [AdminController::class, 'deleteAnnouncement'])->name('announcements.destroy');
});

// 5. Default Profile Edit (Inherited from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
