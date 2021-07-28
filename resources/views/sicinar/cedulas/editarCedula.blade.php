@extends('sicinar.principal')

@section('title','Editar Cédula de detección de necesidades')

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
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Menú
                <small> Requisitos asistenciales     </small>                
                <small> Cedula - editar cédula </small>           
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarCedula',$regcedula->cedula_folio], 'method' => 'PUT', 'id' => 'actualizarCedula', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo fiscal </label><br>
                                    <td style="text-align:left; vertical-align: middle;">   
                                        @foreach($regperiodos as $periodo)
                                            @if($periodo->periodo_id == $regcedula->periodo_id)
                                                {{$periodo->periodo_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>                                    
                                </div>                                
                                <div class="col-xs-4 form-group">
                                    <label >IAP </label><br>
                                    <td style="text-align:left; vertical-align: middle;">   
                                        @foreach($regiap as $iap)
                                            @if($iap->iap_id == $regcedula->iap_id)
                                                {{$iap->iap_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>                                     
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Folio asignado </label><br>{{$regcedula->cedula_folio}}
                                </div>    
                            </div>

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de elaboración - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de elaboración </option>
                                        @foreach($reganios as $anio)
                                            @if($anio->periodo_id == $regcedula->periodo_id1)
                                                <option value="{{$anio->periodo_id}}" selected>{{$anio->periodo_desc}}</option>
                                            @else                                        
                                               <option value="{{$periodo->anio_id}}">{{$anio->periodo_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de elaboración </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $regcedula->mes_id1)
                                                <option value="{{$mes->mes_id}}" selected>{{$mes->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="col-xs-4 form-group">
                                    <label >Día </label>
                                    <select class="form-control m-bot15" name="dia_id1" id="dia_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar día de elaboración </option>
                                        @foreach($regdias as $dia)
                                            @if($dia->dia_id == $regcedula->dia_id1)
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
                                    <label >Responsable </label>
                                    <input type="text" class="form-control" name="sp_nomb" id="sp_nomb" placeholder="Responsable" value="{{trim($regcedula->sp_nomb)}}" onkeypress="return soloLetras(event)" required>
                                </div>  
                            </div>

                            <div class="row">                                             
                                <div class="col-xs-4 form-group">                        
                                    <label>Estado de la cédula de detección de necesidades activa o Inactiva </label>
                                    <select class="form-control m-bot15" name="cedula_status" id="cedula_status" required>
                                        @if($regcedula->cedula_status == 'S')
                                            <option value="S" selected>Activa  </option>
                                            <option value="N">         Inactiva</option>
                                        @else
                                            <option value="S">         Activa  </option>
                                            <option value="N" selected>Inactiva</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (500 carácteres)</label>
                                    <textarea class="form-control" name="cedula_obs" id="cedula_obs" rows="2" cols="120" placeholder="Observaciones (500 carácteres)" required>{{Trim($regcedula->cedula_obs)}}
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
                                    <a href="{{route('verCedula')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\cedulaRequest','#actualizarCedula') !!}
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

