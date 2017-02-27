<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;
use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use View;
use Carbon\Carbon;
use Auth;
/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
      $idusuario = Auth::user()->id;
      $idperfil = Auth::user()->id_perfil;

      if ($idperfil==1 or $idperfil==2) {
        $prioridad=DB::table('app_requerimientos')->get();
        $fechahoy = Carbon::now();
        $dias_anho=($fechahoy->dayOfYear)*24;
        $horasdia=($fechahoy->hour);

        foreach ($prioridad as $value) {
          $fechareq=$value->fecha_limite_requerimiento;
          $fechareq=Carbon::parse($fechareq);
          $dias_req=($fechareq->dayOfYear)*24;
          $horasreq=($fechareq->hour);
          $horas_faltantes=($dias_req+$horasreq)-($dias_anho+$horasdia);
          if ($horas_faltantes > 48) {
            DB::table('app_requerimientos')->where('id_requerimiento',$value->id_requerimiento)->update(['tiempo_para_entrega'=>$horas_faltantes,'prioridad_requerimiento'=>3]);
          }elseif ($horas_faltantes <= 48 & $horas_faltantes >24 ) {
            DB::table('app_requerimientos')->where('id_requerimiento',$value->id_requerimiento)->
            update(['tiempo_para_entrega'=>$horas_faltantes,'prioridad_requerimiento'=>2]);
          }elseif ($horas_faltantes <= 24) {
            DB::table('app_requerimientos')->where('id_requerimiento',$value->id_requerimiento)->
            update(['tiempo_para_entrega'=>$horas_faltantes,'prioridad_requerimiento'=>1]);
          }


        }
          $requerimientos=DB::table('app_requerimientos')->orderBy('fecha_limite_requerimiento','asc')->get();
          return View::make("home")->with(array('requerimientos'=>$requerimientos));

      }else {
        $prioridad=DB::table('app_requerimientos')->where('id_usuario',$idusuario)->get();
        $fechahoy = Carbon::now();
        $dias_anho=($fechahoy->dayOfYear)*24;
        $horasdia=($fechahoy->hour);

        foreach ($prioridad as $value) {
          $fechareq=$value->fecha_limite_requerimiento;
          $fechareq=Carbon::parse($fechareq);
          $dias_req=($fechareq->dayOfYear)*24;
          $horasreq=($fechareq->hour);
          $horas_faltantes=($dias_req+$horasreq)-($dias_anho+$horasdia);
          if ($horas_faltantes > 48) {
            DB::table('app_requerimientos')->where('id_requerimiento',$value->id_requerimiento)->where('id_usuario',$idusuario)->
            update(['tiempo_para_entrega'=>$horas_faltantes,'prioridad_requerimiento'=>3]);
          }elseif ($horas_faltantes <= 48 & $horas_faltantes >24 ) {
            DB::table('app_requerimientos')->where('id_requerimiento',$value->id_requerimiento)->where('id_usuario',$idusuario)->
            update(['tiempo_para_entrega'=>$horas_faltantes,'prioridad_requerimiento'=>2]);
          }elseif ($horas_faltantes <= 24) {
            DB::table('app_requerimientos')->where('id_requerimiento',$value->id_requerimiento)->where('id_usuario',$idusuario)->
            update(['tiempo_para_entrega'=>$horas_faltantes,'prioridad_requerimiento'=>1]);
          }


        }
          $requerimientos=DB::table('app_requerimientos')->where('id_usuario',$idusuario)->
          orderBy('fecha_limite_requerimiento','asc')->get();
          return View::make("home")->with(array('requerimientos'=>$requerimientos));
      }

    }



    public function realizarpedido()
    {
        $fechahoy = Carbon::now();
       $fechahoy=$fechahoy->format('l jS \\of F Y h:i:s A');
        $clientes =DB::table('app_clientes')->get();
        $productos=DB::table('app_productos')->get();
        return View::make("pedido-form")->with(array('clientes'=>$clientes,'productos'=>$productos,'fechahoy'=>$fechahoy));
    }

}
