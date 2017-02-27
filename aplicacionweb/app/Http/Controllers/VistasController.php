<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon;
use App\Http\Requests;
use Auth;
use Session;
use View;
use DB;

class VistasController extends Controller
{
    public function show(Request $request)
    {
      $fechahoy = Carbon::now();
      $fechahoy=$fechahoy->format('l jS \\of F Y h:i:s A');
      $clientes =DB::table('app_clientes')->get();
      $productos=DB::table('app_productos')->get();
      $requerimientos=$_GET['id'];
      $requerimiento = DB::table('app_requerimientos')->where('id_requerimiento', $requerimientos)->take(1)->get();
      foreach ($requerimiento as  $value) {
        $use=$value->id_usuario;
      }

      $user=Auth::user()->id;
      if($use = $user ){
      return View::make("show")->with(array('requerimiento'=>$requerimiento,'clientes'=>$clientes,'productos'=>$productos,'fechahoy'=>$fechahoy));
    }else{
      Session::flash('flash_message', 'Mensaje de prueba');

    }

      }

    }
