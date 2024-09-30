<?php
use App\Http\Controllers\AdminInscriptionController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('inscription',[FormController::class, 'index']);
Route::post('validation',[FormController::class,'store'])->name('form.store');

Route::get('/admin/inscriptions-en-attente', [AdminInscriptionController::class, 'showPending'])->name('admin.inscriptions_en_attente');
Route::put('/admin/inscriptions/update-multiple', [AdminInscriptionController::class, 'updateMultiple'])->name('admin.inscriptions.updateMultiple');
Route::delete('/admin/inscriptions/delete-multiple', [AdminInscriptionController::class, 'deleteMultiple'])->name('admin.inscriptions.deleteMultiple');

