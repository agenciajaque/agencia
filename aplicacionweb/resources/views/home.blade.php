@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')

	<div class="container spark-screen">
		<div class="row">
			<div class="col-md-10 col-md-offset-0">
				<div class="panel panel-default">
					<div class="panel-heading">bienvenido</div>
					<table class="table table-condensed table-striped">
						<thead>
							<tr>
								<th class="col-sm-2">Solicitado por</th>
								<th class="col-sm-1">Cliente</th>
								<th class="col-sm-2">F. de entrega</th>
								<th class="col-sm-3">Producto</th>
								<th class="col-sm-1">Estado</th>
								<th class="col-sm-1">T. entrega</th>
								<th class="col-sm-1">Prioridad</th>
								<th class="col-sm-2">Mas</th>
								<th></th>

							</tr>
						</thead>
						<tbody>
							@foreach($requerimientos as $requerimiento)
							<tr>
								<td>{{validarUsuario($requerimiento->id_usuario)}}</td>
								<td>{{validarCliente($requerimiento->id_cliente)}}</td>
								<td>{{validarFecha($requerimiento->fecha_limite_requerimiento, $requerimiento->tiempo_para_entrega)}}</td>
								<td>{{validarProducto($requerimiento->id_producto)}}</td>
								<td>{{validarLista($requerimiento->estado_requerimiento,1)}}</td>
								<td>{{validarHoras($requerimiento->tiempo_para_entrega)}}</td>
								<td><span class="label label-{{validarColor($requerimiento->prioridad_requerimiento)}}">{{validarLista($requerimiento->prioridad_requerimiento,2)}}</span></td>
								<td><a href="/show?id={{$requerimiento->id_requerimiento}}">ver</a>
								</td>
							</tr>
								@endforeach



						</tbody>
					</table>
					<div class="panel-body">
					<button type="button" class="btn btn-primary" onclick=" location.href='/realizar-pedido' ">Realizar pedido</button>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
