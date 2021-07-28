@extends('sicinar.principal')

@section('title','Editar IAP')

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
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Menú
                <small> Instituciones Privadas (IAPS) - IAPS - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Editar IAP</h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarIap',$regiap->iap_id], 'method' => 'PUT', 'id' => 'actualizarIap']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 offset-md-12">
                                    <label>id. IAP: {{$regiap->iap_id}}</label>
                                </div>                                
                                <div class="col-xs-4 form-group">
                                    <label >Nombre de la IAP </label>
                                    <input type="text" class="form-control" name="iap_desc" placeholder="Nombre de la IAP" value="{{$regiap->iap_desc}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >RFC </label>
                                    <input type="text" class="form-control" name="iap_rfc" id="iap_rfc" placeholder="* RFC de la IAP" value="{{Trim($regiap->iap_rfc)}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Rubro asistencial </label>
                                    <select class="form-control m-bot15" name="rubro_id" id="rubro_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar rubro asistencial</option>
                                        @foreach($regrubro as $rubro)
                                            @if($rubro->rubro_id == $regiap->rubro_id)
                                                <option value="{{$rubro->rubro_id}}" selected>{{$rubro->rubro_desc}}</option>
                                            @else                                        
                                               <option value="{{$rubro->rubro_id}}">{{$rubro->rubro_id}} - {{$rubro->rubro_desc}} 
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>     
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="iap_telefono" id="iap_telefono" placeholder="* Teléfono" value="{{Trim($regiap->iap_telefono)}}" required>
                                </div>                                
                                <div class="col-xs-4 form-group">
                                    <label >Registro de constitución </label>
                                    <input type="text" class="form-control" name="iap_regcons" id="iap_regcons" placeholder="* Registro de constitución de la IAP" value="{{Trim($regiap->iap_regcons)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de constitución </label>
                                    <input type="text" class="form-control" name="iap_feccons" id="iap_feccons" placeholder="* Fecha de constitución (dd/mm/aaaa)" value="{{Trim($regiap->iap_feccons)}}" required>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Calle </label>
                                    <input type="text" class="form-control" name="iap_calle" id="iap_calle" placeholder="* Calle de la IAP" value="{{Trim($regiap->iap_calle)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Número ext./int.</label>
                                    <input type="text" class="form-control" name="iap_num" id="iap_num" placeholder="* Número exterior y/o interior" value="{{Trim($regiap->iap_num)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Colonia </label>
                                    <input type="text" class="form-control" name="iap_colonia" id="iap_colonia" placeholder="* Calle de la IAP" value="{{Trim($regiap->iap_colonia)}}" required>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Código postal </label>
                                    <input type="text" class="form-control" name="iap_cp" id="iap_cp" placeholder="* Código postal" value="{{Trim($regiap->iap_cp)}}" required>
                                </div>                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Municipio</label>
                                    <select class="form-control m-bot15" name="municipio_id" id="municipio_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar municipio</option>
                                        @foreach($regmunicipio as $municipio)
                                            @if($municipio->municipioid == $regiap->municipio_id)
                                                <option value="{{$municipio->municipioid}}" selected>{{$municipio->municipionombre}}</option>
                                            @else 
                                               <option value="{{$municipio->municipioid}}">{{$municipio->municipionombre}}
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>                                    
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Correo electrónico </label>
                                    <input type="text" class="form-control" name="iap_email" id="iap_email" placeholder="* Código postal" value="{{Trim($regiap->iap_email)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Sitio web </label>
                                    <input type="text" class="form-control" name="iap_sweb" id="iap_sweb" placeholder="* Sitio web o pagina electrónica" value="{{Trim($regiap->iap_sweb)}}" required>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Presidente </label>
                                    <input type="text" class="form-control" name="iap_pres" id="iap_pres" placeholder="* Presidente" value="{{Trim($regiap->iap_pres)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Representante legal </label>
                                    <input type="text" class="form-control" name="iap_replegal" id="iap_replegal" placeholder="* Representante legal" value="{{Trim($regiap->iap_replegal)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Secretario </label>
                                    <input type="text" class="form-control" name="iap_srio" id="iap_srio" placeholder="* Secretario" value="{{Trim($regiap->iap_srio)}}" required>
                                </div>                          
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Tesorero </label>
                                    <input type="text" class="form-control" name="iap_tesorero" id="iap_tesorero" placeholder="* Tesorero" value="{{Trim($regiap->iap_tesorero)}}" required>
                                </div>                                                                
                                <div class="col-xs-4 form-group">                        
                                    <label>* Activa o Inactiva </label>
                                    <select class="form-control m-bot15" name="iap_status" required>
                                        @if($regiap->iap_status == 'S')
                                            <option value="S" selected>Vigente</option>
                                            <option value="N">         Extinta</option>
                                        @else
                                            <option value="S">         Vigente</option>
                                            <option value="N" selected>Extinta</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Objeto social </label>
                                    <textarea class="form-control" name="iap_objsoc" id="iap_objsoc" rows="5" cols="120" placeholder="* Objeto social de la IAP" required>{{Trim($regiap->iap_objsoc)}}
                                    </textarea>
                                </div>                                
                            </div>

                            
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
                                <a href="{{route('verIap')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\iapsRequest','#actualizarIap') !!}
@endsection

@section('javascrpt')
@endsection