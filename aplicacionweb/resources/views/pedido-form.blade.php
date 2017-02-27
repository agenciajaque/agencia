@extends('layouts.app')

@section('htmlheader_title')
<link rel="stylesheet" type="text/css" href="jquery.datetimepicker.css"/ >
<script src="jquery.js"></script>
<script src="jquery.datetimepicker.js"></script>
@endsection


@section('main-content')
<section class="col-lg-5 connectedSortable ui-sortable">

<form role="form" enctype="multipart/form-data" method="POST" action="{{ url('enviar-pedido') }}">
{{ csrf_field() }}
  <div class="form-group">
    <label for="ejemplo_email_1">fecha de requerimiento {{$fechahoy}}</label> </br>
    <label for="ejemplo_email_1">detalles del pedido</label>
    <textarea type="text" class="form-control" rows="3" id="nota_pedido" name="nota_pedido"
           placeholder="ingrese los detalles de su pedido"></textarea >
  </div>


  <div class="form-group">
    <label for="ejemplo_email_1" id="cliente" name="cliente">Cliente</label>
    <select class="form-control" name="cliente_id" id="cliente_id">
      @foreach($clientes as $cliente)
        <option value="{{!! $cliente->id_cliente !!}}">{{$cliente->nombre_cliente}}</option>
      @endforeach
    </select>
  </div>


  <div class="form-group">
<label for="ejemplo_email_1" id="producto" name="producto">producto requerido</label>
    <select class="form-control" name="producto_id" id="producto_id">
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
    <input type="file" id="file[]" name="file[]" multiple>
    <p class="help-block">adjuntados.</p>
  </div>

  <button type="submit" class="btn btn-default">Enviar</button>
</form>
</section>
@endsection
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });
</script>
