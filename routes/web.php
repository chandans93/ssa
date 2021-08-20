<?php

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
    return view('front.Homepage');
});
Route::get('enquiry', function () {
    return view('front.EnquiryForm');
});
Route::get('enquiry/submit', function () {
    return view('EnquiryForm');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::post('/Enquiry/submit', array('as' => '.Enquiry.submit', 'uses' => 'EnquiryController@formsubmit'));


require __DIR__.'/auth.php';
