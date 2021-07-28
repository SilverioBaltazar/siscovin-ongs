@extends('sicinar.principal')

@section('title','Editar curso')

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
    <!DOCTYPE html>
    <html lang="es">
    <div class="content-wrapper">
        <section class="content-header">
            <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
            <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
            <h1>
                Menú
                <small>4. Requisitos contables              </small>
                <small>4.1 Inventario activos fijos - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarInventario',$reginventario->id], 'method' => 'PUT', 'id' => 'actualizarInventario', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">                       

                            <div class="row"> 
                                <div class="col-xs-4 form-group">
                                    <input type="hidden" name="periodo_id" id="periodo_id" value="{{$reginventario->periodo_id}}">                                 
                                    <input type="hidden" name="osc_id"     id="osc_id"     value="{{$reginventario->osc_id}}">
                                    <input type="hidden" name="activo_id"  id="activo_id"  value="{{$reginventario->activo_id}}">                                 
                                    <input type="hidden" name="id"         id="id"         value="{{$reginventario->id}}">

                                    <label style="color:green; text-align:left;">Periodo fiscal &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regperiodos as $periodo)
                                        @if($periodo->periodo_id == $reginventario->periodo_id)
                                            <label style="color:green;">{{$periodo->periodo_id}}</label>
                                            @break
                                        @endif 
                                    @endforeach
                                </div>                                 
                                <div class="col-xs-8 form-group">
                                    <label style="color:green; text-align:left;">osc &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regosc as $osc)
                                        @if($osc->osc_id == $reginventario->osc_id)
                                            <label style="color:green;">{{$reginventario->osc_id.' '.$osc->osc_desc}}</label>
                                            @break
                                        @endif 
                                    @endforeach
                                </div>                                                        
                            </div> 
                            <div class="row">
                                <div class="col-xs-4 form-group" style="text-align:left; vertical-align: middle;color:green;">
                                    <label>Código, clave o id. del activo fijo <br> {{$reginventario->activo_id}}</label>
                                </div>                                             
                                <div class="col-xs-8 form-group" style="text-align:left; vertical-align: middle;color:green;">
                                    <label>Id. sistema <br>{{$reginventario->id}}</label>
                                </div>                            
                            </div>


                            <div class="row">
                                <div class="col-xs-8 form-group">
                                    <label >Descripción del activo fijo  </label>
                                    <input type="text" class="form-control" name="activo_desc" id="activo_desc" placeholder="Digitar descripción del activo fijo" value="{{Trim($reginventario->activo_desc)}}"  required>
                                </div>                                                             
                            </div>   

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Factura, recibo de donativo o no. de escritura pública  </label>
                                    <input type="text" class="form-control" name="inventario_doc" id="inventario_doc" placeholder="Digitar factura, recibo de donativo o no. de escritura pública" value="{{Trim($reginventario->inventario_doc)}}" required>
                                </div>               
                                <div class="col-xs-3 form-group">
                                    <label >Valor del activo fijo $ </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="activo_valor" id="activo_valor" placeholder="999999999999.99" value="{{Trim($reginventario->activo_valor)}}"  required>
                                </div>                                                                
                            </div>                          


                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de adquisición de activo fijo - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de adquisición del activo </option>
                                        @foreach($reganios as $anio)
                                            @if($anio->periodo_id == $reginventario->periodo_id1)
                                                <option value="{{$anio->periodo_id}}" selected>{{$anio->periodo_desc}}</option>
                                            @else                                        
                                               <option value="{{$anio->periodo_id}}">{{$anio->periodo_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-2 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de inicio </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $reginventario->mes_id1)
                                                <option value="{{$mes->mes_id}}" selected>{{$mes->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="col-xs-2 form-group">
                                    <label >Día </label>
                                    <select class="form-control m-bot15" name="dia_id1" id="dia_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar día de inicio </option>
                                        @foreach($regdias as $dia)
                                            @if($dia->dia_id == $reginventario->dia_id1)
                                                <option value="{{$dia->dia_id}}" selected>{{$dia->dia_desc}}</option>
                                            @else                                        
                                               <option value="{{$dia->dia_id}}">{{$dia->dia_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Condición actual del activo fijo </label>
                                    <select class="form-control m-bot15" name="condicion_id" id="condicion_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar condición </option>
                                        @foreach($regcondicion as $condicion)
                                            @if($condicion->condicion_id == $reginventario->condicion_id)
                                                <option value="{{$condicion->condicion_id}}" selected>{{$condicion->condicion_desc}}</option>
                                            @else                                        
                                               <option value="{{$condicion->condicion_id}}">{{$condicion->condicion_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                           
                                <div class="col-xs-4 form-group">                        
                                    <label>Estado del activo fijo  </label>
                                    <select class="form-control m-bot15" name="inventario_status" id="inventario_status" required>
                                        @if($reginventario->inventario_status == 'S')
                                            <option value="S" selected>Activo  </option>
                                            <option value="N">         Inactivo</option>
                                        @else
                                            <option value="S">         Activo  </option>
                                            <option value="N" selected>Inactivo</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (4,000 carácteres)</label>
                                    <textarea class="form-control" name="inventario_obs" id="inventario_obs" rows="2" cols="120" placeholder="Observaciones" required>{{Trim($reginventario->inventario_obs)}}
                                    </textarea>
                                </div>                                
                            </div>

                            <div class="row">
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Guardar',['class' => 'btn btn-success btn-flat pull-right']) !!}
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
    {!! JsValidator::formRequest('App\Http\Requests\inventarioRequest','#actualizarInventario') !!}
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

    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
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
    function soloAlfaSE(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";
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

<script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        startDate: '-29y',
        endDate: '-18y',
        startView: 2,
        maxViewMode: 2,
        clearBtn: true,        
        language: "es",
        autoclose: true
    });
</script>

@endsection
