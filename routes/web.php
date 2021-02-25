<?php

use App\Http\Controllers\rotasController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/enderecos',[rotasController::class, 'index']);
Route::post('/enderecos/store',[rotasController::class, 'store']);
Route::get('/enderecos/calcula',[rotasController::class, 'mapa']);
