@extends('sicinar.principal')

@section('title','Registro de requisitos juridicos')

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
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Menú
                <small>IAPS - Registro de requisitos jurídicos </small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Registrar requisitos jurídicos</h3></div> 
                        {!! Form::open(['route' => 'AltaNuevaIapj', 'method' => 'POST','id' => 'nuevaIapj', 'enctype' => 'multipart/form-data']) !!}

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
                                <div class="col-xs-4 form-group">
                                    <label >Periodo fiscal de los requisitos a cumplir</label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo fiscal</option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                              
                            </div>     

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de acta constitutiva en formato PDF </label>
                                    <input type="hidden" name="doc_id12" id="doc_id12" value="17">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d12" id="iap_d12" placeholder="Subir archivo de Acta constitutiva en formato PDF">
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id12" id="formato_id12" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo a subir</option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>
                            <div class="row">                                                                       
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id12" id="per_id12" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id12" id="num_id12" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo12" id="iap_edo12" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div>                            

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de Documento de registro en el IFREM en formato PDF </label>
                                    <input type="hidden" name="doc_id13" id="doc_id13" value="18">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d13" id="iap_d13" placeholder="Subir archivo de Documento de registro en el IFREM en formato PDF">
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id13" id="formato_id13" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo a subir</option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                         
                            </div>             
                            <div class="row">                                                                       
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id13" id="per_id13" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id13" id="num_id13" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo13" id="iap_edo13" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div>                            

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de Documento de situación del inmueble en formato PDF </label>
                                    <input type="hidden" name="doc_id14" id="doc_id14" value="9">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d14" id="iap_d14" placeholder="Subir archivo de Documento de situación del inmueble en formato PDF">
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id14" id="formato_id14" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo a subir</option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>         
                            </div> 
                            <div class="row">                                                                       
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id14" id="per_id14" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id14" id="num_id14" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo14" id="iap_edo14" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div> 

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de documento de ultima protocolización en formato PDF </label>
                                    <input type="hidden" name="doc_id15" id="doc_id15" value="19">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d15" id="iap_d15" placeholder="Subir archivo de documento de ultima protocolización en formato PDF">
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id15" id="formato_id15" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo a subir</option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>         
                            </div> 
                            <div class="row">                                                                       
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id15" id="per_id15" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id15" id="num_id15" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo15" id="iap_edo15" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div>                                                     

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar requisitos jurídicos ',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verIapj')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\iapsjuridicoRequest','#nuevaIapj') !!}
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