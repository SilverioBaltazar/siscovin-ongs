@extends('sicinar.principal')

@section('title','Editar requisitos asistenciales')

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
                <small> Instituciones Privadas (IAPS) - requisitos asistenciales - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Editar requisitos asistenciales</h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarReqa2',$regasistencia->iap_id], 'method' => 'PUT', 'id' => 'actualizarReqa2', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label>IAP &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regiap as $iap)
                                        @if($iap->iap_id == $regasistencia->iap_id)
                                            <label style="color:green;">{{$regasistencia->iap_id.' '.$iap->iap_desc}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label>Periodo fiscal de los requisitos a cumplir</label>
                                    @foreach($regperiodos as $periodo)
                                        @if($periodo->periodo_id == $regasistencia->periodo_id)
                                            <label style="color:green;">{{$periodo->periodo_desc}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </div>                                                                     
                            </div>

                            <div class="row">
                                @if (!empty($regasistencia->iap_d2)||!is_null($regasistencia->iap_d2))   
                                    <div class="col-xs-4 form-group">
                                        <label >Plantilla de personal en formato Excel</label><br>
                                        <label ><a href="/images/{{$regasistencia->iap_d2}}" class="btn btn-success" title="Plantilla de personal en formato Excel"><i class="fa fa-file-excel-o"></i>Excel
                                        </a>&nbsp;&nbsp;&nbsp;{{$regasistencia->iap_d2}}
                                        </label>
                                        <input type="hidden" name="doc_id2" id="doc_id2" value="6">
                                    </div>   
                                    <div class="col-xs-4 form-group">
                                        <label >Actualizar archivo de Plantilla de personal en formato Excel</label>
                                        <input type="file" class="text-md-center" style="color:red" name="iap_d2" id="iap_d2" placeholder="Subir archivo de Plantilla de personal en formato Excel" >
                                    </div>      
                                @else     <!-- se captura archivo 1 -->
                                    <div class="col-xs-4 form-group">
                                        <label >Archivo de Plantilla de personal en formato Excel</label>
                                        <input type="file" class="text-md-center" style="color:red" name="iap_d2" id="iap_d2" placeholder="Subir archivo de Plantilla de personal en formato Excel" >
                                        <input type="hidden" name="doc_id2" id="doc_id2" value="6">
                                    </div>                                                
                                @endif 
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo que se subio </label>
                                    <select class="form-control m-bot15" name="formato_id2" id="formato_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo</option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regasistencia->formato_id2)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                                    
                                </div>                                  
                            </div>

                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal remunerado </label>
                                    <input type="text" class="form-control" name="preg_009" id="preg_009" placeholder="Total de personal remunerado" value="{{$regasistencia->preg_009}}" required>
                                </div>                                                                        
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal voluntario </label>
                                    <input type="text" class="form-control" name="preg_010" id="preg_010" placeholder="Total de personal voluntario" value="{{$regasistencia->preg_010}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal administrativo </label>
                                    <input type="text" class="form-control" name="preg_011" id="preg_011" placeholder="Total de personal administrativo" value="{{$regasistencia->preg_011}}" required>
                                </div>                                  
                            </div>               
                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal operativo </label>
                                    <input type="text" class="form-control" name="preg_012" id="preg_012" placeholder="Total de personal operativo" value="{{$regasistencia->preg_012}}" required>
                                </div>                                                                        
                                <div class="col-xs-4 form-group">
                                    <label >Monto total en $ persos mexicanos del personal administrativo </label>
                                    <input type="text" class="form-control" name="preg_013" id="preg_013" placeholder="Monto total en $ persos mexicanos del personal administrativo" value="{{$regasistencia->preg_013}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Monto total en $ persos mexicanos del personal operativo </label>
                                    <input type="text" class="form-control" name="preg_014" id="preg_014" placeholder="Monto total en $ persos mexicanos del personal operativo" value="{{$regasistencia->preg_014}}" required>
                                </div>                                  
                            </div>             
                            <div class="row">                                                                 
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id2" id="per_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodicidad de cumplimiento </option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            @if($periodicidad->per_id == $regasistencia->per_id2)
                                                <option value="{{$periodicidad->per_id}}" selected>{{$periodicidad->per_desc}}</option>
                                            @else 
                                               <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id2" id="num_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo de entrega</option>
                                        @foreach($regnumeros as $numeros)
                                            @if($numeros->num_id == $regasistencia->num_id2)
                                                <option value="{{$numeros->num_id}}" selected>{{$numeros->num_desc}}</option>
                                            @else 
                                               <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo2" id="iap_edo2" required>
                                        @if($regasistencia->iap_edo2 == 'S')
                                            <option value="S" selected>Si</option>
                                            <option value="N">         No</option>
                                        @else
                                            <option value="S">         Si</option>
                                            <option value="N" selected>No</option>
                                        @endif
                                    </select>
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
    {!! JsValidator::formRequest('App\Http\Requests\reqasistenciaRequest','#actualizarReca2') !!}
@endsection

@section('javascrpt')
@endsection
