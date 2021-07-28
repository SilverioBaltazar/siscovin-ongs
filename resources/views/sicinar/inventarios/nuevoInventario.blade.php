@extends('sicinar.principal')

@section('title','Registro de activo fijo')

@section('links')
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('nombre')
    {{$nombre}}
@endsection

@section('usuario')
    {{$usuario}}
@endsection

@section('content')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Menú
                <small>4. Requisitos contables - 4.1 Inventario activos fijos - Registrar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => 'AltaNuevoInventario', 'method' => 'POST','id' => 'nuevoInventario', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">                                
                                <div class="col-xs-3 form-group">
                                    <label >Periodo fiscal </label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo fiscal</option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                                <div class="col-xs-8 form-group">
                                    <label >OSC </label>
                                    <select class="form-control m-bot15" name="osc_id" id="osc_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar OSC</option>
                                        @foreach($regosc as $osc)
                                            <option value="{{$osc->osc_id}}">{{$osc->osc_desc.' '.$osc->osc_id}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                 
                            </div>                            

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Código, clave o id. del activo fijo  (25 caracteres)</label>
                                    <input type="text" class="form-control" name="activo_id" id="activo_id" placeholder="Código, clave o id del activo fijo" required>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-xs-8 form-group">
                                    <label >Descripción  </label>
                                    <input type="text" class="form-control" name="activo_desc" id="activo_desc" placeholder="Descripción del activo fijo" required>
                                </div>                                                             
                            </div>   

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Factura, recibo de donativo o no. de escritura pública  </label>
                                    <input type="text" class="form-control" name="inventario_doc" id="inventario_doc" placeholder="Factura, recibo de donativo o no. de escritura pública" required>
                                </div>               
                                <div class="col-xs-2 form-group">
                                    <label >Valor del activo fijo $  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="activo_valor" id="activo_valor" placeholder="999999999999.99"  required>
                                </div>                                                                
                            </div>                                                        

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de adquisición - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de inicio </option>
                                        @foreach($reganios as $anio)
                                            <option value="{{$anio->periodo_id}}">{{$anio->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-2 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de inicio </option>
                                        @foreach($regmeses as $mes)
                                            <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="col-xs-2 form-group">
                                    <label >Día </label>
                                    <select class="form-control m-bot15" name="dia_id1" id="dia_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar día de inicio </option>
                                        @foreach($regdias as $dia)
                                            <option value="{{$dia->dia_id}}">{{$dia->dia_desc}} </option>
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Condición actual del activo fijo </label>
                                    <select class="form-control m-bot15" name="condicion_id" id="condicion_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar condición del activo fijo</option>
                                        @foreach($regcondicion as $condicion)
                                            <option value="{{$condicion->condicion_id}}">{{$condicion->condicion_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>                            

                            <div class="row">                               
                                <div class="col-md-12 offset-md-5">
                                    <label >Observaciones </label>
                                    <textarea class="form-control" name="inventario_obs" id="inventario_obs" rows="2" cols="120" placeholder="Observaciones relevantes (4,000 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar el activo fijo',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verInventarios')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
                                </div>                                
                            </div>                            

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\inventarioRequest','#nuevoInventario') !!}
@endsection

@section('javascrpt')
<script>
    function soloNumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "1234567890";
       especiales = "8-37-39-46";
       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }    

  function soloAlfa(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ.";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    function general(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890,.;:-_<>!%()=?¡¿/*+";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
</script>
@endsection