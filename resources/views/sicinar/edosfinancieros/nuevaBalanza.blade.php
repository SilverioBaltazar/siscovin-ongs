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
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Menú
                <small>Requisitos Admon. - Edos. Finacieros - Nuevo </small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => 'AltaNuevaBalanza', 'method' => 'POST','id' => 'nuevaBalanza', 'enctype' => 'multipart/form-data']) !!}
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
                                <div class="col-xs-3 form-group">
                                    <label >Semestre a reportar  </label>
                                    <select class="form-control m-bot15" name="num_id" id="num_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar semestre</option>
                                        @foreach($regnumeros as $numeros)
                                           <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                        @endforeach
                                    </select>                                  
                                </div>                                    
                                <div class="col-xs-4 form-group">
                                    <label >OSC </label>
                                    <select class="form-control m-bot15" name="osc_id" id="osc_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar OSC</option>
                                        @foreach($regosc as $osc)
                                            <option value="{{$osc->osc_id}}">{{$osc->osc_id.' '.$osc->osc_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                     
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:yellow;color:red"><b>Nota importante:</b>&nbsp;&nbsp;El archivo digital, NO deberá ser mayor a 1,500 kBytes en tamaño.  </label>
                                </div>   
                            </div> 
                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Archivo de edo. financiero y Balanza de comprobación en formato PDF </label>
                                    <input type="file" class="text-md-center" style="color:red" name="edofinan_foto1" id="edofinan_foto1" placeholder="Subir Archivo de edo. financiero y Balanza de comprobación en formato PDF">
                                </div>   
                                <div class="col-xs-3 form-group">
                                    <label >Formato del archivo que se reporta </label>
                                    <select class="form-control m-bot15" name="formato_id" id="formato_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato </option>
                                        @foreach($regformatos as $formato)
                                            <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                        @endforeach
                                    </select>                                                    
                                </div>                                    
                            </div>

                            <div class="row">               
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:blue;color:white"><b>&nbsp;&nbsp;I n g r e s o s &nbsp;&nbsp;</b></label>
                                </div>                                                                      
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Donativos recibidos en efectivo ($) </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="ids_dreef" id="ids_dreef" placeholder="999999999999.99" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Donativos recibidos en especie ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="ids_drees" id="ids_drees" placeholder="999999999999.99" required>
                                </div>                                                                    
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Cuotas de recuperación ($) </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="ids_crecup" id="ids_crecup" placeholder="999999999999.99" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Apoyos gubernamentales ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="ids_agub" id="ids_agub" placeholder="999999999999.99" required>
                                </div>                                                                    
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Los demas ingresos ($) </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="ids_lding" id="ids_lding" placeholder="999999999999.99" required>
                                </div>  
                            </div>                            

                            <div class="row">               
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:blue;color:white"><b>&nbsp;&nbsp;E g r e s o s&nbsp;&nbsp;</b></label>
                                </div>                                                                      
                            </div>

                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Costos asistenciales ($) </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="eds_ca" id="eds_ca" placeholder="999999999999.99" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Gastos de administración ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="eds_ga" id="eds_ga" placeholder="999999999999.99" required>
                                </div>                                                                    
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    <label >Gastos financieros ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="eds_cf" id="eds_cf" placeholder="999999999999.99" required>
                                </div>              
                                <div class="col-xs-4 form-group">
                                    <label >Remanente del semestre ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="reman_sem" id="reman_sem" placeholder="999999999999.99" required>
                                </div>                                                                    
                            </div>                            

                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Activos circulantes ($) </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="act_circ" id="act_circ" placeholder="999999999999.99" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Activos NO circulantes - Bienes ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="act_nocirc" id="act_nocirc" placeholder="999999999999.99" required>
                                </div>                                                                    
                                <div class="col-xs-4 form-group">
                                    <label >Activos NO circulantes - Inmuebles ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="act_nocircinm" id="act_nocircinm" placeholder="999999999999.99" required>
                                </div>                                
                            </div>

                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Pasivos a corto plazo ($) </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="pas_acp" id="pas_acp" placeholder="999999999999.99" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Pasivos a largo plazo ($)  </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="pas_alp" id="pas_alp" placeholder="999999999999.99" required>
                                </div>                                                                    
                            </div>                            

                            <div class="row">               
                                  <div class="col-xs-4 form-group">
                                    <label >Patrimonio ($) </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="patrimonio" id="patrimonio" placeholder="999999999999.99" required>
                                </div>                                                          
                            </div>      

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de registro - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de registro </option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de registro </option>
                                        @foreach($regmeses as $mes)
                                            <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="col-xs-4 form-group">
                                    <label >Día </label>
                                    <select class="form-control m-bot15" name="dia_id1" id="dia_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar día de registro </option>
                                        @foreach($regdias as $dia)
                                            <option value="{{$dia->dia_id}}">{{$dia->dia_desc}} </option>
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>

                            <div class="row">                               
                                <div class="col-md-12 offset-md-5">
                                    <label >Observaciones (4,000 caracteres)</label>
                                    <textarea class="form-control" name="edofinan_obs" id="edofinan_obs" rows="2" cols="120" placeholder="Observaciones relevantes (4,000 carácteres)" required>
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
    {!! JsValidator::formRequest('App\Http\Requests\balanzaRequest','#nuevaBalanza') !!}
@endsection

@section('javascrpt')
@endsection
