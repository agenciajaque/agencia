@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
<div class="container spark-screen">
	<div class="row">
<section class="col-lg-7 col-md-offset-0" >
  <div class="panel panel-default">
    	@foreach($requerimiento as $requerimiento)
    <div class="panel-heading">informacion del requerimiento</div>
    <div class="panel-body">
		<div class="table-responsive">
		<table class="table">
			<tr>
				<td>ID de la orden :</td>
				<td>{{$requerimiento->id_requerimiento}}</td>
			</tr>
			<tr>
				<td>Realizado por :</td>
				<td>{{validarUsuario($requerimiento->id_usuario)}}</td>
			</tr>
			<tr>
				<td>Estado:</td>
				<td>{{validarLista($requerimiento->estado_requerimiento, 1)}}</td>
			</tr>
			<tr>
				<td>  Fecha de entrega :</td>
				<td>{{$requerimiento->fecha_limite_requerimiento}}</td>
			</tr>
			<tr>
				<td>se envio el dia :</td>
				<td>{{$requerimiento->fecha_requerimiento}}</td>
			</tr>
			<tr>
				<td>Nota :</td>
				<td>{{$requerimiento->nota_requerimiento}}</td>
			</tr>
			<tr>
				<td>Cliente :</td>
			<td>{{validarCliente($requerimiento->id_cliente)}}</td>
			</tr>
			<tr>
				<td>Producto : </td>
				<td>{{validarProducto($requerimiento->id_producto)}}</td>

			</tr>
			<tr>
				<td>Link de archivos</td>
				<td>
					<?php
					$link=$requerimiento->link_adjunto_requerimiento;
					$links=explode(",",$link);
					$contador=count($links);
						for ($i=0; $i <$contador ; $i++) {
							echo " <a target='_blank' href='".$links[$i]."'><img  src='".$links[$i]."' alt='' width='55'>".$links[$i]."</a></br>";
						}
		 			?>
		 		</td>
			</tr>
		</table>
	</div>
	<form role="form" enctype="multipart/form-data" method="POST" action="{{ url('show/process') }}">
  {{ csrf_field() }}

  <input type="hidden" name="id_requerimiento" value="{{$requerimiento->id_requerimiento}}">
  <input type="hidden" name="estado_requerimiento" value="{{$requerimiento->estado_requerimiento}}">
	<label for="ejemplo_email_1">detalles del pedido</label>
	<textarea type="text" class="form-control" rows="3" id="comentario" name="comentario"
				 placeholder="ingrese la razon por la que devuelve el pedido."></textarea >
	@if (!(Auth::user()->id_perfil==2))
	{{validarAccion($requerimiento->estado_requerimiento, $requerimiento->id_usuario)}}
	@endif


  </form>
</div>




  </div>

</section>
<section class="col-lg-3" style="display:{{validarNivel()}};">
  <div class="panel panel-default">

  <div class="panel-heading">Detalle de la devolucion o seguimiento</div>
  <div class="panel-body">
		<form role="form" enctype="multipart/form-data" method="POST" action="{{ url('show/process') }}">
	  {{ csrf_field() }}
		<div class="alert alert-info alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>¡Nota! </strong> <p class="help-block warning">si tiene una anotacion que hacer, escribala en el siguiente recuadro, de lo contrario, omita el recuadro de detalles</p>
		</div>
		<label for="ejemplo_email_1">detalles del pedido</label>
    <textarea type="text" class="form-control" rows="3" id="comentario" name="comentario"
           placeholder="ingrese la razon por la que devuelve el pedido."></textarea >

	  <input type="hidden" name="id_requerimiento" value="{{$requerimiento->id_requerimiento}}">
	  <input type="hidden" name="estado_requerimiento" value="{{$requerimiento->estado_requerimiento}}"><br>
	{{validarAccion($requerimiento->estado_requerimiento, $requerimiento->id_usuario)}}

	  </form>

	</div>

</div>
</section>

  @endforeach
<section class="col-lg-4" style="display:{{validarlogeado($requerimiento->id_usuario)}};">
  <div class="panel panel-default">

  <div class="panel-heading">Actualizar pedido</div>
  <div class="panel-body">
  <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('show/update') }}">
  {{ csrf_field() }}

  <input type="hidden" name="id_requerimiento" value="{{$requerimiento->id_requerimiento}}">
  <input type="hidden" name="id_usuario" value="{{$requerimiento->id_usuario}}">


  <div class="form-group">
<div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>¡Nota! </strong> <p class="help-block warning">solo modifique los datos que desea actualizar</p>
</div>
    <label for="ejemplo_email_1">detalles del pedido</label>
    <textarea type="text" class="form-control" rows="3" id="nota_pedido" name="nota_pedido"
           placeholder="ingrese los detalles de su pedido"></textarea >
  </div>



  <div class="form-group">
    <label for="ejemplo_email_1" id="cliente" name="cliente">Cliente</label>
    <select class="form-control" name="cliente_id" id="cliente_id" >
      <option value="null">seleccione el cliente</option>
      @foreach($clientes as $cliente)
        <option value="{{!! $cliente->id_cliente !!}}">{{$cliente->nombre_cliente}}</option>
      @endforeach
    </select>
  </div>


  <div class="form-group">
<label for="ejemplo_email_1" id="producto" name="producto">producto requerido</label>
<select class="form-control" name="producto_id" id="producto_id" >
  <option value="null">seleccione el producto</option>
  @foreach($productos as $producto)
    <option value="{{!! $producto->id_producto !!}}">{{$producto->nombre_producto}}</option>
  @endforeach
</select>

  </div>
  <div class="form-group">
  <label for="ejemplo_email_1">Fecha limite de entrega</label>
  <input id="datetimepicker" type="datetime-local" name="fecha" >
  </div>

  <div class="form-group">
    <label for="ejemplo_archivo_1">Adjuntar un archivo</label>
    <input type="file" id="file[]" name="file[]" multiple value="cero">

  </div>

  <button type="submit" class="btn btn-default">Enviar</button>


  </form>
</div>
</div>
</section>
<div class="container spark-screen">
	<div class="row">
@endsection
