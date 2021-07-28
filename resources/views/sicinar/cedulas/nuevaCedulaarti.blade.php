@extends('sicinar.principal')

@section('title','Listado de nuevos artículos en la cédula')

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
    <meta charset="utf-8">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Menú
                <small> Requisitos asistenciales</small>                
                <small> Cédula - Lista de artículos - Nueva </small>                
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">

                    {!! Form::open(['route' => 'AltaNuevaCedulaarti', 'method' => 'POST','id' => 'nuevaCedulaarti', 'enctype' => 'multipart/form-data']) !!}
                    <div class="box box-success">
                        
                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <tr>
                                @foreach($regcedula as $cedula)
                                    <td style="color:green;text-align:left; vertical-align: middle;">   
                                        <input type="hidden" id="cedula_folio" name="cedula_folio" value="{{$cedula->cedula_folio}}">  
                                        <label>Folio: </label>{{$cedula->cedula_folio}}
                                    </td>                                                                 
                                    <td style="color:green;text-align:left; vertical-align: middle;">   
                                        <input type="hidden" id="periodo_id" name="periodo_id" value="{{$cedula->periodo_id}}">
                                        <label>Periodo fiscal: </label>{{$cedula->periodo_id}}                                        
                                    </td>
                                    <td style="color:green;text-align:center; vertical-align: middle;"> 
                                        <input type="hidden" id="iap_id" name="iap_id" value="{{$cedula->iap_id}}">  
                                        <label>IAP: </label>
                                        @foreach($regiap as $iap)
                                            @if($iap->iap_id == $cedula->iap_id)
                                                {{$iap->iap_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="text-align:right; vertical-align: middle;">   
                                        <label>Responsable: </label>{{$cedula->sp_nomb}}
                                    </td>                                     
                                </tr>      
                                @endforeach     
                            </table>                                       
                        </div>
                    </div>

                    <table id="tabla1" class="table table-hover table-striped">
                        <tr>
                            <th style="color:green;text-align:left; vertical-align: middle;">#            </th>
                            <th style="color:green;text-align:left; vertical-align: middle;">Articulo     </th>
                            <th style="color:green;text-align:left; vertical-align: middle;">Cantidad     </th>
                            <th style="color:green;text-align:left; vertical-align: middle;">Tipo artículo</th>
                        </tr>
                        @foreach($regarticulos as $arti)
                            <tr>
                                <td>
                                    <input type="hidden" id="articulo_id[]" name="articulo_id[]" value="{{$arti->articulo_id}}">  
                                    <b style="color: orange;font-size:11px;">{{$arti->articulo_id}}</b>
                                </td>
                                <td>
                                    <label style="color:gray;font-size:11px;">{{trim($arti->articulo_desc)}}</label>
                                </td>
                                <td style="color:yellow;font-size:11px;"> 
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="articulo_cantidad[]" placeholder="Cantidad">
                                </td>  
                                <td>
                                    <b style="color: orange;font-size:11px;">
                                    @foreach($regtipos as $tipo)
                                        @if($tipo->tipo_id == $arti->tipo_id)
                                            {{$tipo->tipo_desc}}
                                            @break
                                        @endif
                                    @endforeach
                                    </b>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="row">
                            <div class="col-md-12 offset-md-5">
                                {!! Form::submit('Dar de alta',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                @foreach($regcedula as $cedula)
                                    <a href="{{route('verCedulaarti',array($cedula->periodo_id,$cedula->cedula_folio))}}" role="button" id="cancelar" class="btn btn-danger">Cancelar
                                    </a>
                                    @break
                                @endforeach                                       
                            </div>                                
                    </div>        

                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\cedulaarticuloRequest','#nuevaCedulaarti') !!}
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
