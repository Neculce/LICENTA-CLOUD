<?php

use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); #ONLY ALLOW AUTHENTICATED USERS TO ACCES DECLARED ROUTES

Route::middleware('auth')->group(function () { #ONLY ALLOW AUTHENTICATED USERS TO ACCES DECLARED ROUTES
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); # get profile editing view
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); # profile update controller 
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');  # profile delete route
});

Route::middleware('auth')->group(function () { #ONLY ALLOW AUTHENTICATED USERS TO ACCES DECLARED ROUTES
    Route::get('uploads/', [UploadController::class, 'index'])->name('uploads.index'); # get uploads page
    Route::get('uploads/create', [UploadController::class, 'create'])->name('uploads.create'); # upload file form
    Route::post('uploads/store', [UploadController::class, 'store'])->name('uploads.store'); # validate file, store, secure
    Route::get('uploads/download/{uploadedFile}', [UploadController::class, 'download'])->name('uploads.download');
    Route::get('/dashboard', [UploadController::class, 'index'])->name('dashboard'); #render the file upload section 
    #to implement a new route for the deletion of file. Also for the downloading of the files. to be continued.
});


#Route::get(uri: 'filedownload', action: FileDownloadController::class)
 #   ->middleware(middleware:'auth')
  #  ->name(name:'filedownload');

require __DIR__.'/auth.php';
