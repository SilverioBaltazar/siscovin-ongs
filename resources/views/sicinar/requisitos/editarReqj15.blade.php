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
                <small>2. Requisitos Jurídicos - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-14">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarJur15',$regjuridico->osc_id], 'method' => 'PUT', 'id' => 'actualizarJur15', 'enctype' => 'multipart/form-data']) !!}
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
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:yellow;color:red"><b>Nota importante:</b>El archivo digital, NO deberán ser mayores a 1,500 kBytes en tamaño.  </label>
                                </div>   
                            </div>
                            <div class="row">
                                @if (!empty($regjuridico->osc_d15)||!is_null($regjuridico->osc_d15))   
                                    <div class="col-xs-6 form-group">
                                        <label >Documento de última protocolización en formato PDF</label><br>
                                        <label ><a href="/images/{{$regjuridico->osc_d15}}" class="btn btn-danger" title="Documento de última protocolización en formato PDF"><i class="fa fa-file-pdf-o"></i>PDF
                                        </a>&nbsp;&nbsp;&nbsp;{{$regjuridico->osc_d15}}
                                        </label>
                                        <input type="hidden" name="doc_id15" id="doc_id15" value="19">
                                    </div>   
                                    <div class="col-xs-6 form-group">
                                        <label >Actualizar archivo digital de documento de última protocolización en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="osc_d15" id="osc_d15" placeholder="Subir archivo de documento de última protocolización en formato PDF" >
                                    </div>      
                                @else     <!-- se captura archivo 1 -->
                                    <div class="col-xs-6 form-group">
                                        <label >Archivo digital de documento de última protocolización en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="osc_d15" id="osc_d15" placeholder="Subir archivo de documento comprobatorio de situación del inmueble en formato PDF" >
                                        <input type="hidden" name="doc_id15" id="doc_id15" value="19">
                                    </div>                                                
                                @endif  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo  </label>
                                    <select class="form-control m-bot15" name="formato_id15" id="formato_id15" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo</option>
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
                                <div class="col-md-14 offset-md-5">
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
    {!! JsValidator::formRequest('App\Http\Requests\reqjuridicoRequest','#actualizarJur15') !!} 
@endsection

@section('javascrpt')
@endsection