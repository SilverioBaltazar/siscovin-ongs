@extends('sicinar.principal')

@section('title','Registro de requisitos asistenciales')

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
                <small>IAPS - Registro de requisitos asistenciales </small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header"><h3 class="box-title">Registrar requisitos asistenciales</h3></div> 
                        {!! Form::open(['route' => 'AltaNuevoReqa', 'method' => 'POST','id' => 'nuevoReqa', 'enctype' => 'multipart/form-data']) !!}

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
                                    <label >Archivo de padrón de beneficiarios en formato Excel </label>
                                    <input type="hidden" name="doc_id1" id="doc_id1" value="5">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d1" id="iap_d1" placeholder="Subir archivo de padrón de beneficiarios en formato Excel">
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id1" id="formato_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo a subir</option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Total de hombres </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_007" id="preg_007" placeholder="99999" required>
                                </div>                                                          
                                <div class="col-xs-4 form-group">
                                    <label >Total de mujeres </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_008" id="preg_008" placeholder="99999" required>
                                </div>   
                            </div>                                    
                            <div class="row">                                                                       
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id1" id="per_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id1" id="num_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo1" id="iap_edo1" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div>                            

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de Plantilla de personal en formato Excel </label>
                                    <input type="hidden" name="doc_id2" id="doc_id2" value="6">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d2" id="iap_d2" placeholder="Subir archivo de Plantilla de personal en formato Excel">
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id2" id="formato_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo a subir</option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                         
                            </div>    
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal remunerado </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_009" id="preg_009" placeholder="99999" required>
                                </div>                                                          
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal voluntario </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_010" id="preg_010" placeholder="99999" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal administrativo </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_011" id="preg_011" placeholder="99999" required>
                                </div>                                   
                            </div>
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal operativo </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_012" id="preg_012" placeholder="99999" required>
                                </div>                                                          
                                <div class="col-xs-4 form-group">
                                    <label >Monto en $ persos mexicanos del personal administrativo </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="preg_013" id="preg_013" placeholder="999999999999.99" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Monto en $ persos mexicanos del personal operativo </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="preg_014" id="preg_014" placeholder="999999999999.99" required>
                                </div>                                   
                            </div>                                                                     
                            <div class="row">                                                                       
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id2" id="per_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id2" id="num_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo2" id="iap_edo2" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div>                            

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de detección de necesidades en formato excel </label>
                                    <input type="hidden" name="doc_id3" id="doc_id3" value="2">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d3" id="iap_d3" placeholder="Subir archivo de detección de necesidades en formato excel">
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id3" id="formato_id3" required>
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
                                    <select class="form-control m-bot15" name="per_id3" id="per_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id3" id="num_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo3" id="iap_edo3" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div>                         

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de Programa de trabajo en formato Excel </label>
                                    <input type="hidden" name="doc_id4" id="doc_id4" value="7">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d4" id="iap_d4" placeholder="Subir archivo de Programa de trabajo en formato Excel">
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id4" id="formato_id4" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo a subir</option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>         
                            </div> 

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Total de actividades programadas </label>
                                    <input type="text" class="form-control" name="preg_015" id="preg_015" placeholder="Total de actividades programadas" required>
                                </div>                                   
                            </div>                                                                                                 
                            <div class="row">                                                                       
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id4" id="per_id4" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id4" id="num_id4" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo4" id="iap_edo4" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de informe de labores en formato excel </label>
                                    <input type="hidden" name="doc_id5" id="doc_id5" value="11">
                                    <input type="file" class="text-md-center" style="color:red" name="iap_d5" id="iap_d5" placeholder="Subir archivo de informe de labores en formato excel">
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo a subir </label>
                                    <select class="form-control m-bot15" name="formato_id5" id="formato_id5" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo a subir</option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>         
                            </div> 
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Total de actividades cumplidas  </label>
                                    <input type="text" class="form-control" name="preg_016" id="preg_016" placeholder="Total de actividades cumplidas" required>
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Total de actividades no cumplidas  </label>
                                    <input type="text" class="form-control" name="preg_017" id="preg_017" placeholder="Total de actividades no cumplidas" required>
                                </div>   
                            </div>              

                            <div class="row">                                                                       
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id5" id="per_id5" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad de entrega</option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id5" id="num_id5" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo de entrega</option>
                                        @foreach($regnumeros as $numero)
                                            <option value="{{$numero->num_id}}">{{$numero->num_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                   
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo5" id="iap_edo5" required>
                                        <option value="S">         Si</option>
                                        <option value="N" selected>No</option>
                                    </select>
                                </div>                                                                  
                            </div>                         

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar requisitos asistenciales ',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verReqa')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\reqasistenciaRequest','#nuevoReqa') !!}
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
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ634567890,.;:-_<>!%()=?¡¿/*+";
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