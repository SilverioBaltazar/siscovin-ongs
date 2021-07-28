@extends('sicinar.principal')

@section('title','Editar requisitos Jurídicos')

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
                <small> 2. Requisitos Jurídicos - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarJur',$regjuridico->osc_id], 'method' => 'PUT', 'id' => 'actualizarJur', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-8 form-group">
                                    <input type="hidden" name="periodo_id" id="periodo_id" value="{{$regjuridico->periodo_id}}">                                 
                                    <input type="hidden" name="osc_id" id="osc_id" value="{{$regjuridico->osc_id}}">
                                    <label style="color:green; text-align:left;">OSC &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regosc as $osc)
                                        @if($osc->osc_id == $regjuridico->osc_id)
                                            <label style="color:green;">{{$regjuridico->osc_id.' '.$osc->osc_desc}}</label>
                                            @break
                                        @endif 
                                    @endforeach
                                </div>                                                                                                                            
                                <div class="col-xs-2 form-group">
                                    <label style="color:green; text-align:right;">Folio sistema<br>{{$regjuridico->osc_folio}}</label>
                                </div>                                             
                            </div>

                            <div class="row">               
                                <div class="col-xs-6 form-group">
                                    @if(!empty($regjuridico->osc_d12)&&(!is_null($regjuridico->osc_d12)))
                                        <label >Archivo digital: Acta constitutiva en formato PDF </label><br>
                                        <a href="/images/{{$regjuridico->osc_d12}}" class="btn btn-danger" title="Acta Constitutiva"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regjuridico->osc_d12}}
                                        <input type="hidden" name="doc_id12" id="doc_id12" value="17">
                                    @else
                                        <label >Archivo digital: Acta constitutiva en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id12" id="doc_id12" value="17">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo  </label>
                                    <select class="form-control m-bot15" name="formato_id12" id="formato_id12" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regjuridico->formato_id12)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                                    
                                </div>                                    
                            </div>

                            <div class="row">               
                                <div class="col-xs-6 form-group">
                                    @if(!empty($regjuridico->osc_d13)&&(!is_null($regjuridico->osc_d13)))
                                        <label >Archivo digital: Documento de registro en el IFREM en formato PDF </label><br>
                                        <a href="/images/{{$regjuridico->osc_d13}}" class="btn btn-danger" title="documento de registro en el IFREM"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regjuridico->osc_d13}}
                                        <input type="hidden" name="doc_id13" id="doc_id13" value="18">
                                    @else
                                        <label >Archivo digital: Documento de registro en el IFREM en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id13" id="doc_id13" value="18">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo </label>
                                    <select class="form-control m-bot15" name="formato_id13" id="formato_id13" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato de archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regjuridico->formato_id13)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                                    
                                </div>                                    
                            </div>

                            <div class="row">               
                                <div class="col-xs-6 form-group">
                                    @if(!empty($regjuridico->osc_d14)&&(!is_null($regjuridico->osc_d14)))
                                        <label >Archivo digital: Currículum  en formato PDF </label><br>
                                        <a href="/images/{{$regjuridico->osc_d14}}" class="btn btn-danger" title="documento de currículum"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regjuridico->osc_d14}}
                                        <input type="hidden" name="doc_id14" id="doc_id14" value="9">
                                    @else
                                        <label >Archivo digital: Currículum en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id14" id="doc_id14" value="9">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo </label>
                                    <select class="form-control m-bot15" name="formato_id14" id="formato_id14" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
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
                                <div class="col-xs-6 form-group">
                                    @if(!empty($regjuridico->osc_d15)&&(!is_null($regjuridico->osc_d15)))
                                        <label >Archivo digital: Documento de última protocolización en formato PDF </label><br>
                                        <a href="/images/{{$regjuridico->osc_d15}}" class="btn btn-danger" title="Documento de última protocolización en formato PDF"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regjuridico->osc_d15}}
                                        <input type="hidden" name="doc_id15" id="doc_id15" value="19">
                                    @else
                                        <label >Archivo digital: Documento de última protocolización en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id15" id="doc_id15" value="19">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo </label>
                                    <select class="form-control m-bot15" name="formato_id15" id="formato_id15" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regjuridico->formato_id15)
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
                                    <a href="{{route('verJur')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\reqjuridicoRequest','#actualizarJur') !!}
@endsection

@section('javascrpt')
@endsection
