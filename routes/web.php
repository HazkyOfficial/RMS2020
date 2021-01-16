<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyController;

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

// Route::get('/', function () {
//     return view('Dashboard');
// });


/*
|--------------------------------------------------------------------------
| Navigation Part
|--------------------------------------------------------------------------
*/
Route::get('/',[MyController::class, 'HomePage']);
Route::get('/Contact',[MyController::class, 'Contact']);
//Form List
Route::get('/Class',[MyController::class, 'ClassForm']);
Route::get('/Users',[MyController::class, 'Users']);
Route::get('/Student',[MyController::class, 'Student']);
Route::get('/Subject',[MyController::class, 'Subject']);



Route::get('/result',[MyController::class, 'result']);
Route::get('/admin',[MyController::class, 'admin']);
Route::get('/about',[MyController::class, 'about']);


//Data Connection============================================
Route::post('addclass',[MyController::class,'addclass']);
Route::post('editclass',[MyController::class,'editclass']);
Route::get('delete/{c}',[MyController::class,'delete'])->name('delete'); //{c} = Passing variable