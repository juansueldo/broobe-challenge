<?php

use App\Http\Controllers\MetricController;
use Illuminate\Support\Facades\Route;



//Route::get('/', function(){ return view('index');})->name('index');
Route::get('/', [MetricController::class, 'index'])->name('home');
Route::post('/get-metrics', [MetricController::class, 'getMetrics'])->name('metrics');
Route::post('/save-metrics', [MetricController::class, 'saveMetrics'])->name('save');
Route::get('/history', [MetricController::class, 'historyMetrics'])->name('history');