<?php

use App\Http\Controllers\Web\IssueWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IssueWebController::class, 'index'])->name('issues.index');
Route::get('/issues/create', [IssueWebController::class, 'create'])->name('issues.create');
Route::post('/issues', [IssueWebController::class, 'store'])->name('issues.store');
Route::get('/issues/{issue}', [IssueWebController::class, 'show'])->name('issues.show');
Route::get('/issues/{issue}/edit', [IssueWebController::class, 'edit'])->name('issues.edit');
Route::put('/issues/{issue}', [IssueWebController::class, 'update'])->name('issues.update');
Route::delete('/issues/{issue}', [IssueWebController::class, 'destroy'])->name('issues.destroy');