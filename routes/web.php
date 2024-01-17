<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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

Route::get('/test', function (Request $request) {
    return request()->ip(); 
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('main.index');

Route::middleware(['auth','checkip','checkuser'])->prefix('admin')->group(function () {

    Route::get('/', [App\Http\Controllers\HomeController::class, 'dashboard']);

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/prueba/{cedula}', [App\Http\Controllers\ActivosController::class, 'searchPropiedad']);

    Route::get('/busqueda', [App\Http\Controllers\BusquedaController::class, 'busqueda'])->name('busqueda');
    Route::post('/busqueda', [App\Http\Controllers\BusquedaController::class, 'buscarTipo'])->name('buscar');
    Route::post('/busqueda/familia', [App\Http\Controllers\BusquedaController::class, 'busquedaFamilia'])->name('buscar.familia');


    Route::post('/busqueda-laboral', [App\Http\Controllers\BusquedaController::class, 'fichaLaboralCedulaNew'])->name('buscar.laboral');
    Route::post('/busqueda-vehiculos', [App\Http\Controllers\BusquedaController::class, 'AutosPropiedades'])->name('buscar.vehiculos');
    //  Route::post('/busqueda-propiedades', [App\Http\Controllers\BusquedaController::class, 'property'])->name('buscar.propiedades');
    Route::post('/busqueda-contacto', [App\Http\Controllers\ContactoController::class, 'InforamcionDeContacto'])->name('buscar.contacto');
    Route::post('company/contact',[App\Http\Controllers\ContactoController::class, 'ContactoCompany'])->name('company.contact');


    // Route::get('/test-busqueda', [App\Http\Controllers\BusquedaController::class, 'busquedaCedula'])->name('test.buscar');

    Route::post('/laboral-historico', [App\Http\Controllers\BusquedaController::class, 'laboralHistorico'])->name('consulta.laboral-historico');
    Route::post('/familia-arbol', [App\Http\Controllers\BusquedaController::class, 'Familia'])->name('consulta.arbol');

    Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil');
    Route::post('/change-password', [App\Http\Controllers\PerfilController::class, 'updatePassword'])->name('update-password');


    // Route::prefix('admin')->group(function () {
        
    // });

    Route::get('/usuarios', [App\Http\Controllers\AdminController::class, 'index'])->name('user.list');
    Route::get('/usuarios/{id}', [App\Http\Controllers\AdminController::class, 'show'])->name('user.show');
    Route::post('/usuarios', [App\Http\Controllers\AdminController::class, 'store'])->name('user.save');
    Route::put('/usuario/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('user.update');
    Route::delete('/usuario/{id}', [App\Http\Controllers\AdminController::class, 'delete'])->name('user.delete');

    Route::post('/usuario/modal', [App\Http\Controllers\AdminController::class, 'edit'])->name('user.modal-edit');
    Route::post('/usuario/otro', [App\Http\Controllers\AdminController::class, 'addUser'])->name('user.modal-otro');

    Route::post('/favorites', [App\Http\Controllers\FavoritoController::class, 'store'])->name('store.favorites');

    Route::prefix('reportes')->group(function () {
        Route::get('/', [App\Http\Controllers\ReporteController::class, 'index'])->name('reporte.index');
        Route::get('/api', [App\Http\Controllers\ReporteController::class, 'ReportesApi'])->name('reporte.api');

    });


});

// Route::get('/roles',function(){

//     $u = App\Models\User::first();

//     $role = Role::create(['name' => 'admin']);

//     $u->assignRole($role);

//     return 'ok';

// });


