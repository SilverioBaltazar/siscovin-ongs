@extends('sicinar.principal')

@section('title','Editar artículo de la cedula')

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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <h1>Menú
                <small> Requisitos asistenciales</small>                
                <small> Cédula - Lista de artículos - Editar artículo </small> 
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarCedulaarti',$regcedulaarti->periodo_id,$regcedulaarti->cedula_folio,$regcedulaarti->articulo_id], 'method' => 'PUT', 'id' => 'actualizarCedulaarti', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                        
                            <table id="tabla1" class="table table-hover table-striped">
                                <tr>
                                @foreach($regcedula as $cedula)
                                    <td style="color:green;text-align:left; vertical-align: middle;">   
                                        <input type="hidden" id="cedula_folio" name="cedula_folio" value="{{$cedula->cedula_folio}}">  
                                        <label>Folio: </label>{{$cedula->cedula_folio}}
                                    </td>                                                                 
                                    <td style="color:green;text-align:left; vertical-align: middle;">   
                                        <input type="hidden" id="periodo_id" name="periodo_id" value="{{$cedula->periodo_id}}">
                                        <label>Periodo fiscal: </label>{{$cedula->periodo_id}}                                        
                                    </td>
                                    <td style="color:green;text-align:center; vertical-align: middle;"> 
                                        <input type="hidden" id="iap_id" name="iap_id" value="{{$cedula->iap_id}}">  
                                        <label>IAP: </label>
                                        @foreach($regiap as $iap)
                                            @if($iap->iap_id == $cedula->iap_id)
                                                {{$iap->iap_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="text-align:right; vertical-align: middle;">   
                                        <label>Responsable: </label>{{$cedula->sp_nomb}}
                                    </td>                                     
                                </tr>      
                                @endforeach     
                            </table>                                       
                        

                            <div class="row">                            
                                <div class="col-xs-4 form-group">
                                    <label >Artículo </label><br>
                                        @foreach($regarticulos as $arti)
                                            @if($arti->articulo_id == $regcedulaarti->articulo_id)
                                               {{$arti->articulo_desc}} 
                                               @break
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                           
                                <div class="col-xs-4 form-group" style="color:orange;text-align:left; vertical-align: middle;">
                                    <label >Tipo de artículo </label><br>
                                        @foreach($regarticulos as $arti)
                                            @if($arti->articulo_id == $regcedulaarti->articulo_id)
                                               {{$arti->tipo_desc}} 
                                               @break
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                                                            
                            </div>

                            <div class="row">
                                <div class="col-xs-2 form-group">
                                    <label >Cantidad </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="articulo_cantidad" id="articulo_cantidad" placeholder="Cantidad" value="{{$regcedulaarti->articulo_cantidad}}" required>
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
                                    @foreach($regcedula as $cedula)
                                        <a href="{{route('verCedulaarti',array($cedula->periodo_id,$cedula->cedula_folio))}}" role="button" id="cancelar" class="btn btn-danger">Cancelar
                                        </a>
                                        @break
                                    @endforeach    
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
    {!! JsValidator::formRequest('App\Http\Requests\aportacionesRequest','#actualizarApor') !!}
@endsection

@section('javascrpt')
@endsection