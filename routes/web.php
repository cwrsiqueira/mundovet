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
    return view('welcome');
});

Route::get('/home_plans', function() {
    return view('home_plans');
})->name('home_plans');

Auth::routes();

Route::get('search_client', 'ClientController@search_client')->name('search_client');
Route::get('search_patient', 'PatientController@search_patient')->name('search_patient');
Route::get('selecionarHorariosDisponiveis', 'AgendaController@selecionarHorariosDisponiveis')->name('selecionarHorariosDisponiveis');
Route::get('call_calendar', 'CalendarController@index')->name('call_calendar');

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('company', 'CompanyController');
Route::resource('permission', 'PermissionController');
Route::resource('permission_item', 'Permission_itemController');
Route::resource('profile', 'ProfileController');
Route::resource('user', 'UserController');
Route::resource('client', 'ClientController');
Route::resource('patient', 'PatientController');
Route::resource('exam', 'ExamController');
Route::resource('consult', 'ConsultController');
Route::resource('agenda', 'AgendaController');
Route::resource('calendario', 'CalendarioController');

Route::get('list', 'ClientController@list')->name('client.list');

Route::get('client_list', 'PdfController@client_list')->name('client_list');
Route::get('patient_list', 'PdfController@patient_list')->name('patient_list');

Route::get('delete_fichas', 'ConsultController@delete_fichas')->name('delete_fichas');
Route::get('del_exception', 'CalendarioController@del_exception')->name('del_exception');

// Rotas da Administração do Sistema
Route::get('/system', 'SystemController@index')->name('system');

//Route::fallback('/home', 'HomeController@index');


// ROTAS INTEGRAÇÃO PAGSEGURO
Route::post('pagseguro_autorization', 'PagseguroController@autorization')->name('pagseguro_autorization');
Route::get('pagseguro_payment/{code}', 'PagseguroController@payment')->name('pagseguro_payment');
Route::get('pagseguro_response', 'PagseguroController@response')->name('pagseguro_response');

Route::post('pagseguro_notification', 'PagseguroController@notification')->name('pagseguro_notification');

