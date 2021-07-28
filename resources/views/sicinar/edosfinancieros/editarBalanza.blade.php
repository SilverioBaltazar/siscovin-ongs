@extends('sicinar.principal')

@section('title','Editar Edo. financiero')

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
                <small>Requisitos Admon. - Edo. Financiero...- Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
 
                        {!! Form::open(['route' => ['actualizarBalanza',$regbalanza->edofinan_folio], 'method' => 'PUT', 'id' => 'actualizarBalanza', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <input type="hidden" name="periodo_id" id="periodo_id" value="{{$regbalanza->periodo_id}}"> 
                                    <label style="color:green; text-align:left;">Periodo fiscal <br>
                                        {{$regbalanza->periodo_id}}
                                    </label>
                                </div>        
                                <div class="col-xs-2 form-group">
                                    <input type="hidden" name="num_id" id="num_id" value="{{$regbalanza->num_id}}">                                 
                                    <label style="color:green; text-align:center;">No. semestre </label><br>
                                    @foreach($regnumeros as $numeros)
                                        @if($numeros->num_id == $regbalanza->num_id)
                                            <label style="color:green;">{{$numeros->num_desc}}</label>
                                            @break 
                                        @endif
                                    @endforeach
                                    </select>  
                                </div>    
                                <div class="col-xs-4 form-group">
                                    <input type="hidden" name="osc_id" id="osc_id" value="{{$regbalanza->osc_id}}">
                                    <label style="color:green; text-align:right;">OSC &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regosc as $osc)
                                        @if($osc->osc_id == $regbalanza->osc_id)
                                            <label style="color:green;">{{$regbalanza->osc_id.' '.$osc->osc_desc}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </div>                                                                                                                            
                                <div class="col-xs-2 form-group">
                                    <label style="color:green; text-align:right;">Folio sistema<br>{{$regbalanza->edofinan_folio}}</label>
                                </div>                                             
                            </div>

                            <div class="row">               
                                  <div class="col-xs-12 form-group">
                                    <label style="background-color:blue;color:white;text-align:center;vertical-align: middle;">&nbsp;&nbsp;&nbsp;I n g r e s o s&nbsp;&nbsp;&nbsp;</label>
                                </div>                                                                      
                            </div>
                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Donativos recibidos en efectivo ($) </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="ids_dreef" id="ids_dreef" placeholder="999999999999.99" value="{{$regbalanza->ids_dreef}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Donativos recibidos en especie ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="ids_drees" id="ids_drees" placeholder="999999999999.99" value="{{$regbalanza->ids_drees}}" required>
                                </div>                                                                    
                            </div>

                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Cuotas de recuperación ($) </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="ids_crecup" id="ids_crecup" placeholder="999999999999.99" value="{{$regbalanza->ids_crecup}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Apoyos gubernamentales ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="ids_agub" id="ids_agub" placeholder="999999999999.99" value="{{$regbalanza->ids_agub}}" required>
                                </div>                                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Los demas ingresos ($) </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="ids_lding" id="ids_lding" placeholder="999999999999.99" value="{{$regbalanza->ids_lding}}" required>
                                </div>  
                            </div>                            

                            <div class="row">               
                                  <div class="col-xs-12 form-group">
                                    <label style="background-color:blue;color:white;text-align:center;vertical-align: middle;">&nbsp;&nbsp;&nbsp;E g r e s o s&nbsp;&nbsp;&nbsp;</label>
                                </div>                                                                      
                            </div>

                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Costos asistenciales ($) </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="eds_ca" id="eds_ca" placeholder="999999999999.99" value="{{$regbalanza->eds_ca}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Gastos de administración ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="eds_ga" id="eds_ga" placeholder="999999999999.99" value="{{$regbalanza->eds_ga}}" required>
                                </div>                                                                    
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Gastos financieros ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="eds_cf" id="eds_cf" placeholder="999999999999.99" value="{{$regbalanza->eds_cf}}" required>
                                </div>                                             
                                <div class="col-xs-4 form-group">
                                    <label >Remanente del semestre ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="reman_sem" id="reman_sem" placeholder="999999999999.99" value="{{$regbalanza->reman_sem}}" required>
                                </div>                                                                    
                            </div>                            

                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Activos circulantes ($) </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="act_circ" id="act_circ" placeholder="999999999999.99" value="{{$regbalanza->act_circ}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Activos NO circulantes - Bienes ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="act_nocirc" id="act_nocirc" placeholder="999999999999.99" value="{{$regbalanza->act_nocirc}}" required>
                                </div>    
                                <div class="col-xs-4 form-group">
                                    <label >Activos NO circulantes - Inmuebles ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="act_nocircinm" id="act_nocircinm" placeholder="999999999999.99" value="{{$regbalanza->act_nocircinm}}" required>
                                </div>                                                                                                            
                            </div>

                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Pasivos a corto plazo ($) </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="pas_acp" id="pas_acp" placeholder="999999999999.99" value="{{$regbalanza->pas_acp}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Pasivos a largo plazo ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="pas_alp" id="pas_alp" placeholder="999999999999.99" value="{{$regbalanza->pas_alp}}" required>
                                </div>                                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Patrimonio ($) </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="patrimonio" id="patrimonio" placeholder="999999999999.99" value="{{$regbalanza->patrimonio}}" required>
                                </div>                                                          
                            </div>      


                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de registro - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de registro </option>
                                        @foreach($regperiodos as $periodo)
                                            @if($periodo->periodo_id == $regbalanza->periodo_id1)
                                                <option value="{{$periodo->periodo_id}}" selected>{{$periodo->periodo_desc}}</option>
                                            @else                                        
                                               <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de registro </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $regbalanza->mes_id1)
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
                                        <option selected="true" disabled="disabled">Seleccionar día de registro </option>
                                        @foreach($regdias as $dia)
                                            @if($dia->dia_id == $regbalanza->dia_id1)
                                                <option value="{{$dia->dia_id}}" selected>{{$dia->dia_desc}}</option>
                                            @else                                        
                                               <option value="{{$dia->dia_id}}">{{$dia->dia_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (4,000 carácteres)</label>
                                    <textarea class="form-control" name="edofinan_obs" id="edofinan_obs" rows="2" cols="120" placeholder="Observaciones (4,000 carácteres)" required>{{Trim($regbalanza->edofinan_obs)}}
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
                                    <a href="{{route('verBalanza')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\balanzaRequest','#actualizarBalanza') !!}
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
