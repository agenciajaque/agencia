<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use Auth;
use DB;
use File;
use Illuminate\Contracts\Filesystem\Filesystem;
use Redirect;
//use Flysystem;

class StorageController extends Controller
{
    public function process(Request $request){
    $tiempotrabajado=0;
    $fechahoy = Carbon::now();
    $todo=$request->all();
    $idrequerimiento=$todo['id_requerimiento'];
    $comentario_form=$todo['comentario'];
    $estado=$todo['estado_requerimiento'];

    if (isset($todo['aceptar'])) {
      if ($estado==1) {//pendiente
        $estado=2;   //cambia estado a aceptado y en proceso
        $comentario='Aceptado y en proceso';
      }elseif($estado==2) {
        $seguimientos=DB::table('app_seguimientos')->where('id_requerimiento',$idrequerimiento)
        ->where('estado_requerimiento',$estado)->orderBy('fecha_seguimiento','asc')->take(1)->get();
        foreach ($segumientos as $value) {
          $fecha_inicio=$value->fecha_seguimiento;
          $tiempoanterior=$value->tiempotrabajado;
        }
        $estado= 3; //detenido
        $comentario='detenido';
        $fechainicio=Carbon::parse($fecha_inicio);
        $dias_anho=($fechahoy->dayOfYear)*86400;
        $dias_ini=($fechainicio->dayOfYear)*86400;
        $horasdia=($fechahoy->hour)*3600;
        $horasinicio=($fechainicio->hour)*3600;
        $prioridad=($dias_anho+$horasdia)-($dias_ini+$horasinicio);
        $tiempotrabajado=$prioridad/3600;
        $tiempotrabajado=$tiempotrabajado+$tiempoanterior;
    }elseif ($estado==3) {
      $estado=2;//en proceso
      $comentario='retoma la peticion y en proceso';
    }elseif ($estado==4) {
      $estado=5;//aprobado
      $comentario='Aprovado por el area encargada';
    }elseif ($estado==6) {
      $estado=2;
      $comentario='se retoma el pedido por devolucion';
    }elseif ($estado==7) {//si esta en revision y se modifican los respectivos cambios
      $estado=1;
      $comentario='revisado y devuelto a produccion';
    }
  }else {
    if ($estado==1) {//pendiente pero necesita revision
      $estado=7;   //cambia estado a pendiente por revision por el area que envia elpedido
      $comentario='necesita revision por parte del area que requiere el pedido';
    }elseif ($estado==2) {
      $seguimientos=DB::table('app_seguimientos')->where('id_requerimiento',$idrequerimiento)
      ->where('estado_requerimiento',$estado)->orderBy('fecha_seguimiento','asc')->take(1)->get();
      foreach ($seguimientos as $value) {
        $fecha_inicio=$value->fecha_seguimiento;
        $tiempoanterior=$value->tiempo_trabajado;
      }
      $estado=4;//revisar
      $comentario='Terminado, esperando aprovacion del area encargada';
      $fechainicio=Carbon::parse($fecha_inicio);
      $dias_anho=($fechahoy->dayOfYear)*86400;
      $dias_ini=($fechainicio->dayOfYear)*86400;
      $horasdia=($fechahoy->hour)*3600;
      $horasinicio=($fechainicio->hour)*3600;
      $prioridad=($dias_anho+$horasdia)-($dias_ini+$horasinicio);
      $tiempotrabajado=$prioridad/3600;
      $tiempotrabajado=$tiempotrabajado+$tiempoanterior;
  }elseif ($estado==3) {
    $estado=4;//en proceso
    $comentario='finaliza proceso y queda a espera de aprobacion';
}elseif ($estado==4) {
  $estado=6;//devolucion
  $comentario='devuelto por el area encargada';
}
}
if(!empty($comentario_form)){
$comentario=$comentario_form;
}
$idusuario = Auth::user()->id;

DB::table('app_requerimientos')
      ->where('id_requerimiento', $idrequerimiento)
      ->update(['estado_requerimiento' => $estado]);

DB::table('app_seguimientos')->insert([
['id_requerimiento'=>$idrequerimiento,'id_usuario'=> $idusuario, 'fecha_seguimiento'=> $fechahoy,
 'comentario_seguimiento'=> $comentario,
 'estado_requerimiento'=> $estado, 'tiempo_trabajado'=>$tiempotrabajado]
 ]);
return Redirect::action('VistasController@show', $enviar=array('id' => $idrequerimiento));

}


    public function update(Request $request){
      $todo=$request->all();

        $id_requerimiento=$todo['id_requerimiento'];
      $files= $request->file('file');
      $idusuario=$request["id_usuario"];
      //return $files;
      $requerimientos =DB::table('app_requerimientos')->select('link_adjunto_requerimiento')
      ->where('id_requerimiento', $id_requerimiento )->take(1)->get();
      foreach ($requerimientos as $value) {
        $link_=$value->link_adjunto_requerimiento;
      }
      if ($files==[null]) {

      }else {
        foreach ($files as  $file) {
          $i=1;
          $imageFileName = mt_rand(1,2147483647) . '.' . $file->getClientOriginalExtension();
          $s3 = \Storage::disk('s3');
          $filePath = '/'.$id_requerimiento.'/' . $imageFileName;
          $s3->put($filePath, file_get_contents($file), 'public');
          $link_req[]='https://s3-us-west-2.amazonaws.com/agencia-jaque'.$filePath;
        }

        $link_=$link_.",".$link_req[0];
        $contador=count($link_req);
        for ($i=1; $i <$contador; $i++) {
          $link_=$link_.','.$link_req[$i];
        }

      }

      $requerimientos =DB::table('app_requerimientos')->select('estado_requerimiento')
      ->where('id_requerimiento', $id_requerimiento )->take(1)->get();
      foreach ($requerimientos as $value) {
        $estado_requerimiento=$value->estado_requerimiento;
      }
      $cliente =$todo['cliente_id'];
      $nota =$todo['nota_pedido'];
      $producto = $todo['producto_id'];

      $producto=str_replace("{", "", $producto);
      $producto=str_replace("}", "", $producto);
      $cliente=str_replace("{", "", $cliente);
      $cliente=str_replace("}", "", $cliente);
      $f = $request->input("fecha");
      $fechahoy = Carbon::now();
      if(empty($f)){
        $requerimientos =DB::table('app_requerimientos')->select('fecha_limite_requerimiento')
        ->where('id_requerimiento', $id_requerimiento )->take(1)->get();
        foreach ($requerimientos as $value) {
          $fecha_req=$value->fecha_limite_requerimiento;
        }

      }else {
        $fe=str_replace("/", "-", $f);
        $fecha_req=$fe.":30";

      }
      $fechareq=Carbon::parse($fecha_req);
      $dias_anho=($fechahoy->dayOfYear)*86400;
      $dias_req=($fechareq->dayOfYear)*86400;
      $horasdia=($fechahoy->hour)*3600;
      $horasreq=($fechareq->hour)*3600;
      $prioridad=($dias_req+$horasreq)-($dias_anho+$horasdia);
      $tiempoparaentrega=$prioridad/3600;
      if ($prioridad>=172800) {
        $prioridad=3; //PRIORIDAD NORMAL
      }elseif ($prioridad<=86400) {
        $prioridad=1;//'prioridad alta';
      }else {
        $prioridad=2;//'prioridad media';
      }
      if ($cliente="null") {
        $requerimientos =DB::table('app_requerimientos')->select('id_cliente')
        ->where('id_requerimiento', $id_requerimiento )->take(1)->get();
        foreach ($requerimientos as $value) {
          $cliente=$value->id_cliente;
        }
      }
      if ($producto="null") {
        $requerimientos =DB::table('app_requerimientos')->select('id_producto')
        ->where('id_requerimiento', $id_requerimiento )->take(1)->get();
        foreach ($requerimientos as $value) {
          $producto=$value->id_producto;
        }

      }
      if(empty($nota)){
        $requerimientos =DB::table('app_requerimientos')->select('nota_requerimiento')
        ->where('id_requerimiento', $id_requerimiento )->take(1)->get();
        foreach ($requerimientos as $value) {
          $nota=$value->nota_requerimiento;
        }
      }
      DB::table('app_requerimientos')->where('id_requerimiento',$id_requerimiento)->
      update(['id_cliente'=>$cliente,'id_producto'=>$producto,'nota_requerimiento'=>$nota,
      'tiempo_para_entrega'=>$tiempoparaentrega,
      'prioridad_requerimiento'=>$prioridad,'fecha_limite_requerimiento'=>$fecha_req,
    'link_adjunto_requerimiento'=>$link_]);

      DB::table('app_seguimientos')->insert([
      ['id_requerimiento'=>$id_requerimiento,'id_usuario'=> $idusuario, 'fecha_seguimiento'=> $fechahoy
      ,'estado_requerimiento'=> $estado_requerimiento, 'comentario_seguimiento'=>'se edito la peticion',
      'estado_actividad_seguimiento'=>0]
      ]);

return Redirect::action('VistasController@show', $enviar=array('id' => $id_requerimiento));


      }


    public function save(Request $request, Filesystem $filesystem){
      $todo=$request->all();
      $idusuario = Auth::user()->id;
      $todo=$request->all();
      $cliente =$todo['cliente_id'];
      $nota =$todo['nota_pedido'];
      $producto = $todo['producto_id'];
      $producto=str_replace("{", "", $producto);
      $producto=str_replace("}", "", $producto);
      $cliente=str_replace("{", "", $cliente);
      $cliente=str_replace("}", "", $cliente);

      $f = $request->input("fecha");
      $fe=str_replace("/", "-", $f);
      $fecha_req=$fe.":30";
      $fechareq=Carbon::parse($fecha_req);
      $fechahoy = Carbon::now();
      $dias_anho=($fechahoy->dayOfYear)*86400;
      $dias_req=($fechareq->dayOfYear)*86400;
      $horasdia=($fechahoy->hour)*3600;
      $horasreq=($fechareq->hour)*3600;
      $prioridad=($dias_req+$horasreq)-($dias_anho+$horasdia);
      $tiempoparaentrega=$prioridad/3600;
      if ($prioridad>=172800) {
        $prioridad=3; //PRIORIDAD NORMAL
      }elseif ($prioridad<=86400) {
        $prioridad=1;//'prioridad alta';
      }else {
        $prioridad=2;//'prioridad media';
      }
//endprioridad
$requerimientos =DB::table('app_requerimientos')->select('id_requerimiento')->orderBy('id_requerimiento', 'desc')->take(1)->get();
foreach ($requerimientos as $p) {
    $id_req= $p->id_requerimiento;
    $id_req=((int)$id_req)+1;
  }
  if (empty($id_req)){
    $id_req=1;
  }

$files= $request->file('file');

if ($files==[null]) {
  $link_="no se cargo ningun tipo de archivo";
}else {
  foreach ($files as  $file) {
    $i=1;
    $imageFileName = mt_rand(1,2147483647) . '.' . $file->getClientOriginalExtension();
    $s3 = \Storage::disk('s3');
    $filePath = '/'.$id_req.'/' . $imageFileName;
    $s3->put($filePath, file_get_contents($file), 'public');
    $link_req[]='https://s3-us-west-2.amazonaws.com/agencia-jaque'.$filePath;
  }

  $link_=$link_req[0];
  $contador=count($link_req);
  for ($i=1; $i <$contador; $i++) {
    $link_=$link_.','.$link_req[$i];
  }
}
        DB::table('app_requerimientos')->insert([
        ['id_requerimiento'=>$id_req,'id_usuario'=> $idusuario, 'fecha_requerimiento'=> $fechahoy, 'id_cliente'=>$cliente,
         'id_producto'=> $producto, 'fecha_limite_requerimiento'=>$fechareq,
         'link_adjunto_requerimiento'=>$link_,
         'nota_requerimiento'=> $nota, 'prioridad_requerimiento'=>$prioridad,
         'estado_requerimiento'=> 1, 'tiempo_para_entrega'=>$tiempoparaentrega
         ]
]);
DB::table('app_seguimientos')->insert([
['id_requerimiento'=>$id_req,'id_usuario'=> $idusuario, 'fecha_seguimiento'=> $fechahoy
,'estado_requerimiento'=> 1, 'comentario_seguimiento'=>'se crea peticion',
'estado_actividad_seguimiento'=>0]
]);

        return Redirect::action('VistasController@show', $enviar=array('id' => $id_req));

    }

}
