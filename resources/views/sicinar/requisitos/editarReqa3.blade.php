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
                        {!! Form::open(['route' => ['actualizarReqa3',$regasistencia->iap_id], 'method' => 'PUT', 'id' => 'actualizarReqa3', 'enctype' => 'multipart/form-data']) !!}
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
                                @if (!empty($regasistencia->iap_d3)||!is_null($regasistencia->iap_d3))   
                                    <div class="col-xs-4 form-group">
                                        <label >Detección de necesidades en formato Excel</label><br>
                                        <label ><a href="/images/{{$regasistencia->iap_d3}}" class="btn btn-success" title="Detección de necesidades en formato Excel"><i class="fa fa-file-excel-o"></i>Excel
                                        </a>&nbsp;&nbsp;&nbsp;{{$regasistencia->iap_d3}}
                                        </label>
                                        <input type="hidden" name="doc_id3" id="doc_id3" value="2">
                                    </div>   
                                    <div class="col-xs-4 form-group">
                                        <label >Actualizar archivo de Detección de necesidades en formato Excel</label>
                                        <input type="file" class="text-md-center" style="color:red" name="iap_d3" id="iap_d3" placeholder="Subir archivo de Detección de necesidades en formato Excel" >
                                    </div>      
                                @else     <!-- se captura archivo 1 -->
                                    <div class="col-xs-4 form-group">
                                        <label >Archivo de Detección de necesidades en formato Excel</label>
                                        <input type="file" class="text-md-center" style="color:red" name="iap_d3" id="iap_d3" placeholder="Subir archivo de Detección de necesidades en formato Excel" >
                                        <input type="hidden" name="doc_id3" id="doc_id3" value="2">
                                    </div>                                                
                                @endif 
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo que se subio </label>
                                    <select class="form-control m-bot15" name="formato_id3" id="formato_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo</option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regasistencia->formato_id3)
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
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id3" id="per_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodicidad de cumplimiento </option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            @if($periodicidad->per_id == $regasistencia->per_id3)
                                                <option value="{{$periodicidad->per_id}}" selected>{{$periodicidad->per_desc}}</option>
                                            @else 
                                               <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id3" id="num_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo de entrega</option>
                                        @foreach($regnumeros as $numeros)
                                            @if($numeros->num_id == $regasistencia->num_id3)
                                                <option value="{{$numeros->num_id}}" selected>{{$numeros->num_desc}}</option>
                                            @else 
                                               <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo3" id="iap_edo3" required>
                                        @if($regasistencia->iap_edo3 == 'S')
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
    {!! JsValidator::formRequest('App\Http\Requests\reqasistenciaRequest','#actualizarReca3') !!}
@endsection

@section('javascrpt')
@endsection
