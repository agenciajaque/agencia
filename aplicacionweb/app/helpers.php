<?php
function validarUsuario($id)
{
  $usuario = DB::table('users')->select('name')->where('id',$id)->take(1)->get();
    foreach ($usuario as $value) {
      $user=$value->name;
    }
return $user;
}

function validarFecha($fecha, $tiempo)
{
  if ($tiempo<=12) {
    $show=substr($fecha,11);
  }else {
    $show=substr($fecha,0, 10);
  }
  return $show;
}

function validarCliente($id_cliente)
{
  $cliente = DB::table('app_clientes')->select('nombre_cliente')->where('id_cliente',$id_cliente)->take(1)->get();
    foreach ($cliente as $value) {
      $client=$value->nombre_cliente;
    }
return $client;
}

function validarProducto($id_producto)
{
  $productos = DB::table('app_productos')->select('nombre_producto')->where('id_producto',$id_producto)->take(1)->get();
    foreach ($productos as $value) {
      $producto=$value->nombre_producto;
    }
return $producto;
}



function validarLista($valor_lista, $tipo_lista)
{
  $estados = DB::table('app_listas')->select('item_lista')->where('id_tipo_lista',$tipo_lista)->
  where('valor_lista',$valor_lista)->get();
    foreach ($estados as $value) {
      if ($value->valor_lista=$valor_lista) {
        $estado=$value->item_lista;
      break;
      }
    }
return $estado;
}

function validarColor($prioridad){
if ($prioridad==1) {
  echo  "danger";
}elseif($prioridad==2) {
echo  "warning";
}elseif ($prioridad==3) {
echo "success";
}
}
function validarHoras($horas){
  if($horas>24){
    $show=(int)($horas/24);
    return $show." dias";
  }else {
    return $horas." horas";
  }
}
function ValidarAccion($estado, $usuario)
{
  $idusuario = Auth::user()->id;

  $perfil = Auth::user()->id_perfil;

  if ($idusuario==$usuario) {
    if ($estado==7 ) {
      echo'<button type="submit" class="btn btn-default" name="aceptar" id="aceptar">Reenviar peticion</button>';
    }else {
      echo "<h4>En produccion</h4>";
    }
  }
  if ($estado==1 & $perfil==2 ) {
    echo '<button type="submit" class="btn btn-default" style="margin:5px;" name="aceptar" id="aceptar">Aceptar e iniciar</button>
    <button type="submit" class="btn btn-default" style="margin:5px;" name="revision" id="revision">Enviar a revision</button>';
  }elseif ($estado==2 & $perfil==2) {
echo '<button type="submit" class="btn btn-default" style="margin:5px;" name="aceptar" id="aceptar">parar</button>
<button type="submit" class="btn btn-default" name="terminar" id="terminar">Terminar</button>';
  }
  elseif($estado==3 && $perfil==2) {
    echo '<button type="submit" class="btn btn-default" style="margin:5px;" name="aceptar" id="aceptar">Retomar</button><br>
    <button type="submit" style="margin:5px;" class="btn btn-default">Terminar</button>';
  }elseif ($estado==4 && $perfil==3 ) {
    echo '<button type="submit"  style="margin:5px;" class="btn btn-default" name="aceptar" id="aceptar">Aprobar</button><br>
    <button type="submit"  style="margin:5px;" class="btn btn-default" name="devolver" id="devolver" >devolver a produccion</button>';
  }elseif ($estado==5) {
    echo "aprobado y terminado";
  }elseif ($estado==6 && $perfil==2 ) {
    echo '<button type="submit" style="margin:5px;"  class="btn btn-default" name="aceptar" id="aceptar">Aceptar e inciar</button><br>
    <button type="submit" style="margin:5px;"  class="btn btn-default" name="devolver" id="devolver">Devolver trabajo</button>';
  }
}
function validarlogeado($id){
    $idusuario = Auth::user()->id;
    if ($id==$idusuario) {
      return "block";
    }
    else {
      return "none";
    }
}
function validarNivel(){

  $perfil = Auth::user()->id_perfil;

    if ($perfil==2) {
      return "block";
    }
    else {
      return "none";
    }
  }
