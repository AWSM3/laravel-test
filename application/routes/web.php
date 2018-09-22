<?php
declare(strict_types=1);

/** @uses */
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('mailing')->group(function() {
    Route::name('list-mailing-tasks')->get('list', 'Mailing\ListMailingTasks');
    Route::name('show-mailing-form')->get('form', 'Mailing\ShowMailingForm');
    Route::name('process-mailing')->post('processing', 'Mailing\ProcessMailing');
});

Route::redirect('/', 'mailing/list');