@extends('sicinar.principal')

@section('title','Editar requisitos admon.')

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
                <small>4. Requisitos contables      </small>
                <small>4.2 Otros requisitos - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarReqc',$regcontable->osc_folio], 'method' => 'PUT', 'id' => 'actualizarReqc', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">                            
                                <div class="col-xs-4 form-group">
                                    <input type="hidden" name="periodo_id" id="periodo_id" value="{{$regcontable->periodo_id}}">                                
                                    <label>Periodo fiscal </label><br>
                                    <label style="color:green;">{{$regcontable->periodo_id}}  </label>
                                </div>                                   
                                <div class="col-xs-4 form-group">
                                    <input type="hidden" name="osc_id" id="osc_id" value="{{$regcontable->osc_id}}">
                                    <label>OSC &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regosc as $osc)
                                        @if($osc->osc_id == $regcontable->osc_id)
                                            <label style="color:green;">{{$regcontable->osc_id.' '.$osc->osc_desc}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label>Folio </label><br> 
                                    <label style="color:green;">{{$regcontable->osc_folio}}</label>
                                </div>                                                                                     
                            </div>
           
                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    @if(!empty($regcontable->osc_d1)||(!is_null($regcontable->osc_d1)))
                                        <label >Archivo de presupuesto anual en formato PDF </label><br>
                                        <a href="/images/{{$regcontable->osc_d1}}" class="btn btn-danger" title="documento de presupuesto anual"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regcontable->osc_d1}}
                                        <input type="hidden" name="doc_id1" id="doc_id1" value="16">
                                    @else
                                        <label >Archivo de presupuesto anual en formato PDF</label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id1" id="doc_id1" value="16">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo </label>
                                    <select class="form-control m-bot15" name="formato_id1" id="formato_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato de archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regcontable->formato_id1)
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
                                    @if(!empty($regcontable->osc_d2)||(!is_null($regcontable->osc_d2)))
                                        <label >Archivo de constancia de autorización para recibir donativos en formato PDF </label><br>
                                        <a href="/images/{{$regcontable->osc_d2}}" class="btn btn-danger" title="constancia de autorización para recibir donativos"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regcontable->osc_d2}}
                                        <input type="hidden" name="doc_id2" id="doc_id2" value="14">
                                    @else
                                        <label >Archivo de constancia de autorización para recibir donativos en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id2" id="doc_id2" value="14">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo  </label>
                                    <select class="form-control m-bot15" name="formato_id2" id="formato_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regcontable->formato_id2)
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
                                    @if(!empty($regcontable->osc_d3)||(!is_null($regcontable->osc_d3)))
                                        <label >Archivo de declaración anual en formato PDF </label><br>
                                        <a href="/images/{{$regcontable->osc_d3}}" class="btn btn-danger" title="declaración anual"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regcontable->osc_d3}}
                                        <input type="hidden" name="doc_id3" id="doc_id3" value="13">
                                    @else
                                        <label >Archivo de declaración anual en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id3" id="doc_id3" value="13">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo </label>
                                    <select class="form-control m-bot15" name="formato_id3" id="formato_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regcontable->formato_id3)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
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
                                    <a href="{{route('verReqc')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar
                                    </a>
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
    {!! JsValidator::formRequest('App\Http\Requests\reqcontablesRequest','#actualizarReqc') !!}
@endsection

@section('javascrpt')
@endsection
