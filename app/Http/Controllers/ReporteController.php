<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\ApiReport;
use App\Models\QueryReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Excel;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->format('Y-m-d');
        $fecha = null;
        $usuarios = User::select('id','name')->where('status',1)->where('type',1)->orderBy('name')->get();

        if($request->fecha){
            $fecha = $request->fecha;
            $split = explode('-',$request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',trim($split[0]))->format('Y-m-d');
            $end = Carbon::createFromFormat('d/m/Y',trim($split[1]))->format('Y-m-d');
            $fecha = $request->fecha;
        }

        $data = $request->all();
        // $reportes = QueryReport::where('company',$user->company)->whereRaw("DATE(created_at) BETWEEN '$start' AND '$end'");

        if($request->user != null && $request->user != 'todos'){
            $findUser = User::find($request->user);
            $reportes = QueryReport::where('company',$findUser->company)->whereRaw("DATE(created_at) BETWEEN '$start' AND '$end'");
        }else{
            if($user->hasRole('Administrador')){
                $reportes = QueryReport::whereRaw("DATE(created_at) BETWEEN '$start' AND '$end'");
            }else{
                $reportes = QueryReport::where('company',$user->company)->whereRaw("DATE(created_at) BETWEEN '$start' AND '$end'");
            }
            
            $data['user'] = null;
        }

        if($request->export){
            if($request->export == 'excel'){
                $export = $reportes->get();
                $name = 'reporte-'.Carbon::now()->format('Y-m-d').'.xlsx';
                return Excel::download(new ReportExport($export), $name);
            }
        }

        $reportes = $reportes->paginate(10);

        return view('reportes.index',compact('reportes','fecha','data','usuarios'));
    }

    public function ReportesApi(Request $request)
    {
        $user = Auth::user();
        $start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $end = Carbon::now()->format('Y-m-d');
        $fecha = null;
        $usuarios = User::select('id','name')->where('type',1)->whereNotNull('api_token')->get();

        // dd($request->user);

        // dd($usuarios);

        if($request->fecha){
            $fecha = $request->fecha;
            $split = explode('-',$request->fecha);
            $start = Carbon::createFromFormat('d/m/Y',trim($split[0]))->format('Y-m-d');
            $end = Carbon::createFromFormat('d/m/Y',trim($split[1]))->format('Y-m-d');
            $fecha = $request->fecha;
        }

        $data = $request->all();
        
        if($request->user != null && $request->user != 'todos'){
            $reportes = ApiReport::whereRaw("user_id = $request->user AND DATE(created_at) BETWEEN '$start' AND '$end'");
        }else{
            $reportes = ApiReport::whereRaw("DATE(created_at) BETWEEN '$start' AND '$end'");
            $data['user'] = null;
        }

        if($request->export){
            if($request->export == 'excel'){
                $export = $reportes->get();
                $name = 'reporte-'.Carbon::now()->format('Y-m-d').'.xlsx';
                return Excel::download(new ReportExport($export), $name);
            }
        }

        $reportes = $reportes->paginate(10);

        return view('reportes.index',compact('reportes','fecha','data','usuarios'));
    }
}
