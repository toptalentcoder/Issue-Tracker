<?php

use App\Http\Controllers\IssueController;
use Illuminate\Support\Facades\Route;

Route::apiResource('issues', IssueController::class);