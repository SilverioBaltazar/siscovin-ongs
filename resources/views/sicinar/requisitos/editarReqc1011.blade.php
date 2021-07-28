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
                <small> Requisitos admon. - Otros requisitos - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarReqc1011',$regcontable->osc_folio], 'method' => 'PUT', 'id' => 'actualizarReqc1011', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row"> 
                                <div class="col-xs-4 form-group">
                                    <input type="hidden" name="periodo_id" id="periodo_id" value="{{$regcontable->periodo_id}}">                                
                                    <label>Periodo fiscal <br>
                                        {{$regcontable->periodo_id}}
                                    </label>
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
                                    <label>Folio <br> {{$regcontable->osc_folio}}</label>
                                </div>                                                                                                                                    
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:yellow;color:red"><b>Nota importante:</b>&nbsp;&nbsp;El archivo digital, NO deberá ser mayor a 1,500 kBytes en tamaño.  </label>
                                </div>   
                            </div>  
                            <div class="row">
                                @if (!empty($regcontable->osc_d1011)||!is_null($regcontable->osc_d1011))   
                                    <div class="col-xs-4 form-group">
                                        <label >Noviembre Cuotas 5 al millar en formato PDF</label><br>
                                        <label ><a href="/images/{{$regcontable->osc_d1011}}" class="btn btn-danger" title="Noviembre Cuotas 5 al millar en formato PDF"><i class="fa fa-file-pdf-o"></i>PDF
                                        </a>&nbsp;&nbsp;&nbsp;{{$regcontable->osc_d1011}}
                                        </label>
                                        <input type="hidden" name="doc_id1011" id="doc_id1011" value="15">
                                    </div>   
                                    <div class="col-xs-4 form-group">
                                        <label >Noviembre Cuotas 5 al millar en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="osc_d1011" id="osc_d1011" placeholder="Subir archivo de Noviembre Cuotas 5 al millar en formato PDF" >
                                    </div>      
                                @else     <!-- se captura archivo 1 -->
                                    <div class="col-xs-4 form-group">
                                        <label >Noviembre archivo de Cuotas 5 al millar en formato Excel</label>
                                        <input type="file" class="text-md-center" style="color:red" name="osc_d1011" id="osc_d1011" placeholder="Subir archivo de Noviembre Cuotas 5 al millar en formato PDF" >
                                        <input type="hidden" name="doc_id1011" id="doc_id1011" value="15">
                                    </div>                                                
                                @endif 
                            </div>

                            <div class="row">        
                                <div class="col-xs-2 form-group">
                                    <label >Noviembre $ aportación  </label>
                                    <input type="number" min="0" max="999999999999.99" step=".01" class="form-control" name="preg_1011" id="preg_1011" placeholder="999999999999.99" value="{{$regcontable->preg_1011}}" required>
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
                                    <a href="{{route('verReqc')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\reqcontablesRequest','#actualizarRec1011') !!}
@endsection

@section('javascrpt')
@endsection
