<?php

namespace App\Http\Controllers;

use App\Models\QueryReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $apiURL = 'https://enlinea.cuenca.gob.ec/BackendConsultas/api/contribuyentes/0190413861001/predios';
        // // 'pagina=1&nitems=30&filtro=-1&filtro2=-1'
        // $postInput = [
        //     'pagina' => '1',
        //     'nitems' => '30',
        //     'filtro' => '-1',
        //     'filtro2' => '-1'
        // ];

        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', $apiURL, ['query' => $postInput]);

        // $statusCode = $response->getStatusCode();
        // $responseBody = json_decode($response->getBody(), true);

        // dd($responseBody);

        return view('inicio');
    }

    public function dashboard()
    {
        $user = Auth::user();

        // $users =  $user->getUsers()->count();
        
        // if(Auth::user()->hasRole('Administrador|Empresa')){
        //     $users = User::where('status',1)->where('company','!=','DEMO SD')->count();
        // }

        $reportes = $user->reports->sortBy('created_at')->sortDesc()->take(5);

        return view('dashboard', compact('reportes'));
    }
}
