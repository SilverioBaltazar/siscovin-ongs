@extends('sicinar.principal')

@section('title','Editar aportación monetaria')

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
                <small> IAPS - Aportaciones monetarias</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Editar registro de aportación monetaria</h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarApor1',$regapor->apor_folio], 'method' => 'PUT', 'id' => 'actualizarApor1', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >IAP:
                                    @foreach($regiap as $iap)
                                        @if($iap->iap_id == $regapor->iap_id)
                                            {{$iap->iap_desc}}
                                            @break
                                        @endif
                                    @endforeach 
                                    </label>                                    
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label>Folio: {{$regapor->apor_folio}}</label>
                                </div>             
                            </div>

                            <div class="row">    
                                @if (!empty($regapor->apor_compdepo)||!is_null($regapor->apor_compdepo))  
                                    <div class="col-xs-4 form-group">
                                        <label >No. cheque y/o No. de referencia de depósito en caja en formato PDF</label>
                                        <label ><a href="/images/{{$regapor->apor_compdepo}}" class="btn btn-danger" title="No. cheque y/o No. de referencia de depósito en caja en formato PDF"><i class="fa fa-file-pdf-o"></i>PDF</a>
                                        </label>
                                    </div>   
                                    <div class="col-xs-4 form-group">
                                        <label >Actualizar archivo de No. cheque y/o No. de referencia de depósito en caja en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="apor_compdepo" id="apor_compdepo" placeholder="Subir archivo de No. cheque y/o No. de referencia de depósito en caja en formato PDF" >
                                    </div>      
                                @else     <!-- se captura archivo 1 -->
                                    <div class="col-xs-4 form-group">
                                        <label >Archivo de No. cheque y/o No. de referencia de depósito en caja en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="apor_compdepo" id="apor_compdepo" placeholder="Subir archivo de No. cheque y/o No. de referencia de depósito en caja en formato PDF" >
                                    </div>                                                
                                @endif       
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
                                    <a href="{{route('verApor')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\aportaciones1Request','#actualizarApor1') !!}
@endsection

@section('javascrpt')
@endsection