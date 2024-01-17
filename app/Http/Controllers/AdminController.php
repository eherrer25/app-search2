<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function index(Request $request){

        // dd($request->all());

        $status = $request->status ? ($request->status == 'inactivo' ? 0 : 1): 1;

        $user = Auth::user();

        if($user->hasRole('Empresa')){
            return redirect()->route('user.show',$user->id);
            $users = User::where('type', 1)->where('status',$status)->where('company',$user->company);
        }else{
            $users = User::where('type', 1)->where('status',$status);
        }

        if($request->nombre){
           $users = $users->where('name','LIKE',"%$request->nombre%")->paginate(15);
        }else{
           $users = $users->paginate(15);
        }

        $data= $request->all();
        
        return view('admin.index',compact('users','data'));

    }

    public function show($id)
    {
        $admin = User::findOrFail($id);
        // dd($admin);
        return view('admin.show', [
            'admin' => $admin
        ]);
    }

    public function edit(Request $request)
    {
        $user = User::findOrFail($request->id);

        return view('admin.modal-edit', [
            'user' => $user
        ]);
    }

    public function addUser(Request $request)
    {
        $user = User::findOrFail($request->id);

        return view('admin.modal-otro', [
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {

        $user = User::create([
            'name' => $request['name'],
            'company' => $request['company'],
            // 'occupation' => $request['occupation'],
            'occupation' => 'o',
            'email' => $request['email'],
            // 'status' => 1,
            'type' => $request->type,
            'password' => Hash::make($request['password']),

        ]);

        return redirect()->route('user.list')->with('success','Se guardó correctamente');

    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $data = $request->all();
        if(!$data['password']){
            unset($data['password']);
        }else{
            $data['password'] = Hash::make($data['password']);
        }

        if(isset($data['habilitado']) && $user->habilitado == 'no'){
            $data['fecha_cont'] = Carbon::now()->format('Y-m-d');
            // $data['habilitado'] = 'si';
        }

        if(!isset($data['habilitado'])){
            $data['habilitado'] = 'no';
        }

        // if($user->cont == $data['cont']){
        //     unset($data['cont']);
        // }

        $user->update($data);

        return redirect()->route('user.list')->with('success', 'Se actualizó correctamente');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('user.list')->with('success', 'Se eliminó correctamente');
    }

    public function forceDelete($id)
    {
        User::where('id', $id)->withTrashed()->forceDelete();

        return redirect()->route('users.index', ['status' => 'archived'])
        ->withSuccess(__('User force deleted successfully.'));
    }

    public function restore($id)
    {
        User::where('id', $id)->withTrashed()->restore();

        return redirect()->route('users.index', ['status' => 'archived'])
        ->withSuccess(__('User restored successfully.'));
    }
}
