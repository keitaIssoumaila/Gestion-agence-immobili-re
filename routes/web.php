<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminAgenceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;



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

Route::middleware(['auth', 'role:super_admin'])->group(function () {
   
    Route::get('/superadmin/admins', [SuperAdminController::class, 'showAdminsList'])->name('admins-list'); // Afficher la liste des administrateurs
    Route::post('/superadmin/admins', [SuperAdminController::class, 'storeAdmin'])->name('store-admin');    // Créer un administrateur
    Route::put('/superadmin/admins/{id}', [SuperAdminController::class, 'updateAdmin'])->name('update-admin'); // Modifier un administrateur
    Route::patch('/superadmin/admins/{id}/toggle', [SuperAdminController::class, 'toggleAdminActivation'])->name('toggle-user-status');

    // Route facultative pour les statistiques
    Route::get('/superadmin/statistics', [SuperAdminController::class, 'getStatistics'])->name('statistics'); // Obtenir des statistiques
    
    Route::resource('/superadmin/agences', AgenceController::class);
    Route::patch('/superadmin/agence/{id}/toggle-status', [AgenceController::class, 'toggleAgencyStatus'])->name('agences.toggle-status');


    Route::patch('superadmin/toggle-user-status/{id}', [SuperAdminController::class, 'toggleUserStatus'])->name('superadmin.toggleUserStatus');

    Route::get('/impersonate/{userId}', [ImpersonationController::class, 'impersonate'])->name('impersonate');
    Route::get('/stop-impersonate', [ImpersonationController::class, 'stopImpersonation'])->name('stopImpersonate');

});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/adminagence/create-user', [AdminAgenceController::class, 'showCreateUserForm'])->name('adminagence.create-user');
    Route::post('/adminagence/create-user', [AdminAgenceController::class, 'storeUser'])->name('adminagence.store-user');
    
    Route::get('adminagence/users/{id}', [AdminAgenceController::class, 'show'])->name('adminagence.user-details');
    Route::get('adminagence/users/{id}/edit', [AdminAgenceController::class, 'edit'])->name('adminagence.edit-user');
    Route::put('adminagence/users/{id}', [AdminAgenceController::class, 'update'])->name('adminagence.update-user');
    Route::get('/adminagence/users', [AdminAgenceController::class, 'showUsersList'])->name('adminagence.users-list');

     // Nouvelle route pour basculer l'état d'un utilisateur
     Route::get('adminagence/toggle-user-status/{id}', [AdminAgenceController::class, 'toggleUserStatus'])->name('adminagence.toggleUserStatus');


     // Gestion du profil
    Route::get('/profile/edit', [AdminAgenceController::class, 'editProfile'])->name('adminagence.edit-profile');
    Route::put('/profile/update', [AdminAgenceController::class, 'updateProfile'])->name('adminagence.update-profile');
 });

Auth::routes();

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware(['auth', 'role:super_admin' ])->group(function () {
//     // Routes accessibles uniquement aux super administrateurs
//     Route::get('/admin-dashboard', [AdminAgenceController::class, 'index']);
// });

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Routes accessibles uniquement aux administrateurs
    Route::get('/adminagence', [AdminAgenceController::class, 'index']);
});

// Route pour la page "Mon Profil"
Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');

// Route pour la déconnexion
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
});

// Route pour la page d'accueil après connexion
Route::get('/home', function () {
    return view('home'); // Assurez-vous d'avoir une vue home.blade.php
})->name('home');


