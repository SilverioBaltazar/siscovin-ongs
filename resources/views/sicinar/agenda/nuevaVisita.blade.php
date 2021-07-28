@extends('sicinar.principal')

@section('title','Nueva visita de diligencia')

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
                <small> Agenda de diligencias - Nueva visita de diligencia</small>                
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Nueva visita de diligencia</h3></div>
                        {!! Form::open(['route' => 'altaNuevaVisita', 'method' => 'POST','id' => 'altaNuevaVisita', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >IAP</label>
                                    <select class="form-control m-bot15" name="iap_id" id="iap_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar IAP</option>
                                        @foreach($regiap as $iap)
                                            <option value="{{$iap->iap_id}}">{{$iap->iap_desc}}</option>
                                        @endforeach
                                    </select>                                  
                                </div>                                                                    
                                <div class="col-xs-4 form-group">
                                    <label >Domicilio a donde se va a realizar diligencia </label>
                                    <input type="text" class="form-control" name="visita_dom" id="visita_dom" placeholder="Domicilio de la IAP a donde se va a realizar diligencia" required>
                                </div>
                            </div>

                            <div class="row">   
                                <div class="col-xs-4 form-group">
                                    <label >Municipio</label>
                                    <select class="form-control m-bot15" name="municipio2_id" id="municipio2_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar municipio</option>
                                        @foreach($regmunicipio as $municipio)
                                            <option value="{{$municipio->municipioid}}">{{$municipio->entidadfederativa_desc.'-'.$municipio->municipionombre}}
                                            </option>
                                        @endforeach
                                    </select>                                  
                                </div>                                                  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo fiscal </label>
                                    <select class="form-control m-bot15" name="periodo2_id" id="periodo2_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo fiscal</option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>

                            <div class="row">                                   
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes2_id" id="mes2_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes</option>
                                        @foreach($regmeses as $mes)
                                            <option value="{{$mes->mes_id}}">{{$mes->mes_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>       
                                <div class="col-xs-4 form-group">
                                    <label >Dia </label>
                                    <select class="form-control m-bot15" name="dia2_id" id="dia2_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar dia</option>
                                        @foreach($regdias as $dia)
                                            <option value="{{$dia->dia_id}}">{{$dia->dia_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                
                            </div>                            

                            <div class="row">                                        
                                <div class="col-xs-4 form-group">
                                    <label >Hora </label>
                                    <select class="form-control m-bot15" name="hora2_id" id="hora2_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar hora</option>
                                        @foreach($reghoras as $hora)
                                            <option value="{{$hora->hora_id}}">{{$hora->hora_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Minutos </label>
                                    <select class="form-control m-bot15" name="num2_id" id="num2_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar minutos</option>
                                        @foreach($regminutos as $min)
                                            <option value="{{$min->num_id}}">{{$min->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>               
                            </div>                            

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Auditado </label>
                                    <input type="text" class="form-control" name="visita_auditado1" id="visita_auditado1" placeholder="Auditado" required>
                                </div>                                                          
                                <div class="col-xs-4 form-group">
                                    <label >Puesto </label>
                                    <input type="text" class="form-control" name="visita_puesto1" id="visita_puesto1" placeholder="Puesto" required>
                                </div>   
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Se identifica con </label>
                                    <input type="text" class="form-control" name="visita_ident1" id="visita_ident1" placeholder="Se identifica con" required>
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Expedida por </label>
                                    <input type="text" class="form-control" name="visita_exped1" id="visita_exped1" placeholder="Expedida por" required>
                                </div>                                                                                          
                            </div>

                            <div class="row">                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Representante de la IAP </label>
                                    <input type="text" class="form-control" name="visita_auditado2" id="visita_auditado2" placeholder="Representante de la IAP" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Puesto del representante de la IAP </label>
                                    <input type="text" class="form-control" name="visita_puesto2" id="visita_puesto2" placeholder="Puesto del representante de la IAP" required>
                                </div>                                       
                            </div>              

                            <div class="row">                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Se identifica el representante legal con </label>
                                    <input type="text" class="form-control" name="visita_ident2" id="visita_ident2" placeholder="Se identifica el representante legal con" required>
                                </div>                                                          
                                <div class="col-xs-4 form-group">
                                    <label >Expedida por </label>
                                    <input type="text" class="form-control" name="visita_exped2" id="visita_exped2" placeholder="Expedida por" required>
                                </div> 
                            </div>     

                            <div class="row">                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Pesona que atendio la diligencia en la IAP </label>
                                    <input type="text" class="form-control" name="visita_auditado3" id="visita_auditado3" placeholder="Pesona que atendio la diligencia en la IAP" required>
                                </div> 
                            </div>              

                            <div class="row">                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Responsable del JAPEM que realizo la diligencia </label>
                                    <input type="text" class="form-control" name="visita_auditor2" id="visita_auditor2" placeholder="Responsable del JAPEM que realizo la diligencia" required>
                                </div>                                                          
                                <div class="col-xs-4 form-group">
                                    <label >Personal del JAPEM presente en la diligencia</label>
                                    <input type="text" class="form-control" name="visita_auditor1" id="visita_auditor1" placeholder="Personal del JAPEM presente en la diligencia" required>
                                </div> 
                            </div>  

                            <div class="row">                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Testigo 1 </label>
                                    <input type="text" class="form-control" name="visita_testigo1" id="visita_testigo1" placeholder="Testigo 1" required>
                                </div>                                                          
                                <div class="col-xs-4 form-group">
                                    <label >Testigo 2</label>
                                    <input type="text" class="form-control" name="visita_testigo2" id="visita_testigo2" placeholder="Testigo 2" required>
                                </div> 
                            </div>                                 

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Estado de la diligencia (en proceso, cerrada o cancelada </label>
                                    <br>
                                    <input type="radio" name="visita_edo" checked value="0" style="margin-right:8px;">
                                    En proceso
                                    <input type="radio" name="visita_edo" value="1" style="margin-right:8px;">Cerrada
                                    <input type="radio" name="visita_edo" value="2" style="margin-right:8px;">Cancelada                                    
                                </div>  
                            </div>                         

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Criterios de verificación (500 carácteres) </label>
                                    <textarea class="form-control" name="visita_criterios" id="visita_criterios" rows="6" cols="120" placeholder="Criterios de verificación (500 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Visto de la diligencia (500 carácteres)</label>
                                    <textarea class="form-control" name="visita_visto" id="visita_visto" rows="6" cols="120" placeholder="Visto de la diligencia (500 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Recomendaciones (500 carácteres) </label>
                                    <textarea class="form-control" name="visita_recomen" id="visita_recomen" rows="6" cols="120" placeholder="Recomendaciones (500 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Sugerencias (500 carácteres) </label>
                                    <textarea class="form-control" name="visita_sugeren" id="visita_sugeren" rows="6" cols="120" placeholder="Sugerencias (500 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>                                                                                    

                            <div class="row">                                        
                                <div class="col-xs-4 form-group">
                                    <label >Plazo de entrega de duplicado de Acta de visita </label>
                                    <select class="form-control m-bot15" name="num3_id" id="num3_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar plazo de entrega</option>
                                        @foreach($regminutos as $num)
                                            <option value="{{$num->num_id}}">{{$num->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>  
                            </div>                            

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Dar de alta visita de diligencia',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verVisitas')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\visitaRequest','#nuevaVisita') !!}
@endsection

@section('javascrpt')
<script>
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