@extends('sicinar.principal')

@section('title','Registro de aportación monetaria')

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
                <small>IAPS - Aportaciones monetarias</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Registrar aportación monetaria</h3></div> 
                        {!! Form::open(['route' => 'AltaNuevaApor', 'method' => 'POST','id' => 'nuevaApor', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >IAP </label>
                                    <select class="form-control m-bot15" name="iap_id" id="iap_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar IAP</option>
                                        @foreach($regiap as $iap)
                                            <option value="{{$iap->iap_id}}">{{$iap->iap_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                 
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Periodo fiscal </label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo fiscal</option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id" id="mes_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes</option>
                                        @foreach($regmeses as $mes)
                                            <option value="{{$mes->mes_id}}">{{$mes->mes_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                                 
                            </div>                            

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Concepto  </label>
                                    <input type="text" class="form-control" name="apor_concepto" id="apor_concepto" placeholder="Digitar concepto de la paotración monetaria" onkeypress="return soloAlfa(event)" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >$ Monto </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="apor_monto" id="apor_monto" placeholder="Monto de la aportación en pesos mexicanos" required>
                                </div>  
                            </div>                            

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Institución bancaria </label>
                                    <select class="form-control m-bot15" name="banco_id" id="banco_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Institución bancaria</option>
                                        @foreach($regbancos as $banco)
                                            <option value="{{$banco->banco_id}}">{{$banco->banco_desc}}
                                            </option>
                                        @endforeach
                                    </select>                                    
                                </div>       
                                <div class="col-xs-4 form-group">
                                    <label >Número de cheque y/o ficha de depósito </label>
                                    <input type="text" class="form-control" name="apor_nocheque" id="apor_nocheque" placeholder="Número de cheque" required>
                                </div>           
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de Comprobante de depósito en formato PDF </label>
                                    <input type="file" class="text-md-center" style="color:red" name="apor_compdepo" id="apor_compdepo" placeholder="Subir archivo de Comprobante de depósito en formato PDF">
                                </div>   
                            </div>        

                            <div class="row">                               
                                <div class="col-xs-4 form-group">
                                    <label >Personal que entrega la aportación monetaria </label>
                                    <input type="text" class="form-control" name="apor_entrega" id="apor_entrega" placeholder="* Persona que entrega la aportación monetaria" required>
                                </div>                                
                                <div class="col-xs-4 form-group">
                                    <label >Personal que recibe la aportación monetaria </label>
                                    <input type="text" class="form-control" name="apor_recibe" id="apor_recibe" placeholder="* Persona que recibe la aportación monetaria" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar la aportación monetaria ',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verApor')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\aportacionesRequest','#nuevaApor') !!}
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
@endsection