@extends('sicinar.principal')

@section('title','Editar Requisitos Jurídicos')

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
                <small> Instituciones Privadas (IAPS) - Requisitos Jurídicos - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-14">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Editar Requisitos Jurídicos</h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarIapj14',$regjuridico->iap_id], 'method' => 'PUT', 'id' => 'actualizarIapj14', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label>IAP &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regiap as $iap)
                                        @if($iap->iap_id == $regjuridico->iap_id)
                                            <label style="color:green;">{{$regjuridico->iap_id.' '.$iap->iap_desc}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label>Periodo fiscal de los requisitos a cumplir</label>
                                    @foreach($regperiodos as $periodo)
                                        @if($periodo->periodo_id == $regjuridico->periodo_id)
                                            <label style="color:green;">{{$periodo->periodo_desc}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </div>                                                                     
                            </div>

                            <div class="row">
                                @if (!empty($regjuridico->iap_d14)||!is_null($regjuridico->iap_d14))   
                                    <div class="col-xs-4 form-group">
                                        <label >Documento comprobatorio de situación del inmueble en formato PDF</label><br>
                                        <label ><a href="/images/{{$regjuridico->iap_d14}}" class="btn btn-danger" title="Documento comprobatorio de situación del inmueble en formato PDF"><i class="fa fa-file-pdf-o"></i>PDF
                                        </a>&nbsp;&nbsp;&nbsp;{{$regjuridico->iap_d14}}
                                        </label>
                                        <input type="hidden" name="doc_id14" id="doc_id14" value="17">
                                    </div>   
                                    <div class="col-xs-4 form-group">
                                        <label >Actualizar archivo de Documento comprobatorio de situación del inmueble en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="iap_d14" id="iap_d14" placeholder="Subir archivo de Documento comprobatorio de situación del inmueble en formato PDF" >
                                    </div>      
                                @else     <!-- se captura archivo 1 -->
                                    <div class="col-xs-4 form-group">
                                        <label >Archivo de Documento comprobatorio de situación del inmueble en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="iap_d14" id="iap_d14" placeholder="Subir archivo de Documento comprobatorio de situación del inmueble en formato PDF" >
                                        <input type="hidden" name="doc_id14" id="doc_id14" value="17">
                                    </div>                                                
                                @endif 
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo que se subio </label>
                                    <select class="form-control m-bot15" name="formato_id14" id="formato_id14" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo</option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regjuridico->formato_id14)
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
                                    <select class="form-control m-bot15" name="per_id14" id="per_id14" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodicidad de cumplimiento </option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            @if($periodicidad->per_id == $regjuridico->per_id14)
                                                <option value="{{$periodicidad->per_id}}" selected>{{$periodicidad->per_desc}}</option>
                                            @else 
                                               <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id14" id="num_id14" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo de entrega</option>
                                        @foreach($regnumeros as $numeros)
                                            @if($numeros->num_id == $regjuridico->num_id14)
                                                <option value="{{$numeros->num_id}}" selected>{{$numeros->num_desc}}</option>
                                            @else 
                                               <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo14" id="iap_edo14" required>
                                        @if($regjuridico->iap_edo14 == 'S')
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
                                <div class="col-md-14 offset-md-5">
                                    {!! Form::submit('Guardar',['class' => 'btn btn-success btn-flat pull-right']) !!}
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
    {!! JsValidator::formRequest('App\Http\Requests\iapsjuridicoRequest','#actualizarIapj14') !!}
@endsection

@section('javascrpt')
@endsection