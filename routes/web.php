<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FairController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/lists', [FairController::class, 'lists'])->name('list-overview');
Route::get('/lists/add', [FairController::class, 'addListForm'])->name('list-add-form');
Route::post('/lists/add', [FairController::class, 'addList'])->name('list-add');
Route::get('/groups/{list_id}', [FairController::class, 'groups'])->name('groups-overview');
Route::get('/groups/{list_id}/add', [FairController::class, 'addGroupForm'])->name('group-add-form');
Route::post('/groups/{list_id}/add', [FairController::class, 'addGroup'])->name('group-add');
Route::get('/objects/{group_id}', [FairController::class, 'objects'])->name('objects-overview');
Route::get('/objects/{group_id}/add', [FairController::class, 'addObjectForm'])->name('object-add-form');
Route::post('/objects/{group_id}/add', [FairController::class, 'addObject'])->name('object-add');
Route::get('/batches/{list_id}', [FairController::class, 'batches'])->name('batches-overview');
Route::post('/batches/{version}', [FairController::class, 'startBatchProcessing'])->name('start-batch');
Route::get('/assessments/{batch_id}', [FairController::class, 'assessments'])->name('assessments-overview');
Route::get('/assessment/{assessment_id}', [FairController::class, 'assessment'])->name('assessment-overview');
Route::get('/datacite', [FairController::class, 'datacite'])->name('datacite-overview');
Route::post('/datacite', [FairController::class, 'updateDatacite'])->name('update-datacite');
Route::post('/datacite-query', [FairController::class, 'queryDatacite'])->name('query-datacite');
Route::get('/exports', [FairController::class, 'exports'])->name('exports-overview');
Route::post('/exports-table', [FairController::class, 'exportTable'])->name('export-table');
Route::get('/stats', [FairController::class, 'stats'])->name('stats-overview');