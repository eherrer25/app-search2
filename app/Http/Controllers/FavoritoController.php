<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{
    //

    public function store(Request $request)
    {
        // dd($request->all());

        $favorito = Favorite::where('contact',$request->contact)->where('user_id', Auth::user()->id)->first();
        if($favorito){
            $favorito->status = $request->status;
            $favorito->save();
        }else{
            $request['user_id'] = Auth::user()->id;
            $favorito = Favorite::create($request->all());
        }

        $color = 'secondary';
        if ($favorito->status == '0') {
            $color = 'success';
        } elseif ($favorito->status == '1') {
            $color = 'warning';
        } elseif ($favorito->status == '2') {
            $color = 'danger';
        }

        // return redirect()->back()->with('success','Guardado correctamente.');

        return response()->json(['data'=> $favorito,'color'=>$color],200);
    }
}
