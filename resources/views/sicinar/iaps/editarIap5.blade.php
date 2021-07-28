@extends('sicinar.principal')

@section('title','Editar ONG')

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
    <meta charset="utf-8">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Menú
                <small> ONGS - Directorio - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Editar ONG</h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarIap5',$regiap->iap_id], 'method' => 'PUT', 'id' => 'actualizarIap5', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">             
                                <div class="col-xs-4 form-group">
                                    <label>Id.  </label><br>
                                    <label style="color:green">{{$regiap->iap_id}}</label>
                                </div>                                      
                                <div class="col-xs-4 form-group">
                                    <label >ONG  </label><br>
                                    <label style="color:green">{{$regiap->iap_desc}}  </label>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">RFC </label>
                                    <input type="text" class="form-control" name="iap_rfc" id="iap_rfc" placeholder="RFC de la ONG" value="{{Trim($regiap->iap_rfc)}}" required>
                                </div>  
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Teléfono </label>
                                    <input type="text" class="form-control" name="iap_telefono" id="iap_telefono" placeholder="Teléfono" value="{{Trim($regiap->iap_telefono)}}" required>
                                </div>                                
                                <div class="col-xs-4 form-group">
                                    <label >Registro de constitución </label><br>
                                    <label style="color:green">{{Trim($regiap->iap_regcons)}}</label>
                                </div>
 
                                <div class="col-xs-4 form-group">
                                    <label>Fecha de constitución </label><br>
                                    <label style="color:green">{!! date('d/m/Y',strtotime($regiap->iap_feccons)) !!}</label>
                                </div>                                                            
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Domicilio Legal (Calle, no.ext/int., colonia) </label><br>
                                    <label style="color:green">{{Trim($regiap->iap_dom1)}}</label>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Domicilio 2 (Calle, no.ext/int., colonia)</label>
                                    <input type="text" class="form-control" name="iap_dom2" id="iap_dom2" placeholder="Domicilio Fiscal" value="{{Trim($regiap->iap_dom2)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Domicilio 3 (Calle, no.ext/int., colonia) </label>
                                    <input type="text" class="form-control" name="iap_dom3" id="iap_dom3" placeholder="Domicilio Asistencial" value="{{Trim($regiap->iap_dom3)}}" required>
                                </div>                                
                            </div>

                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Código postal </label><br>
                                    <label style="color:green">{{Trim($regiap->iap_cp)}}</label>
                                </div>                                                                        
                                <div class="col-xs-4 form-group">
                                    <label >Entidad federativa</label>
                                    <select style="color:green" class="form-control m-bot15" name="entidadfederativa_id" id="entidadfederativa_id">
                                        @foreach($regentidades as $estado)
                                            @if($estado->entidadfederativa_id == $regiap->entidadfederativa_id)
                                                <option value="{{$estado->entidadfederativa_id}}" selected>{{$estado->entidadfederativa_desc}}
                                                </option>
                                            @else                                        
                                               <option value="{{$estado->entidadfederativa_id}}">{{$estado->entidadfederativa_desc}}
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>                                                                                      
                                <div class="col-xs-4 form-group">
                                    <label >Municipio</label>
                                    <select style="color:green" class="form-control m-bot15" name="municipio_id" id="municipio_id">
                                        @foreach($regmunicipio as $municipio)
                                            @if($municipio->municipioid == $regiap->municipio_id)
                                                <option value="{{$municipio->municipioid}}" selected>{{$municipio->entidadfederativa_desc.'-'.$municipio->municipionombre}}</option>
                                            @else 
                                               <option value="{{$municipio->municipioid}}">{{$municipio->entidadfederativa_desc.'-'.$municipio->municipionombre}}
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>                                    
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Correo electrónico </label>
                                    <input type="text" class="form-control" name="iap_email" id="iap_email" placeholder=" Correo electrónico" value="{{Trim($regiap->iap_email)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Sitio web </label>
                                    <input type="text" class="form-control" name="iap_sweb" id="iap_sweb" placeholder=" Sitio web o pagina electrónica" value="{{Trim($regiap->iap_sweb)}}" required>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Presidente </label>
                                    <input type="text" class="form-control" name="iap_pres" id="iap_pres" placeholder=" Presidente" value="{{Trim($regiap->iap_pres)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Representante legal </label>
                                    <input type="text" class="form-control" name="iap_replegal" id="iap_replegal" placeholder="Representante legal" value="{{Trim($regiap->iap_replegal)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Secretario </label>
                                    <input type="text" class="form-control" name="iap_srio" id="iap_srio" placeholder="Secretario" value="{{Trim($regiap->iap_srio)}}" required>
                                </div>                          
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Tesorero </label>
                                    <input type="text" class="form-control" name="iap_tesorero" id="iap_tesorero" placeholder="Tesorero" value="{{Trim($regiap->iap_tesorero)}}" required>
                                </div>                                                                
                                <div class="col-xs-4 form-group">                        
                                    <label>Activa o Inactiva </label>
                                    <select style="color:green" class="form-control m-bot15" name="iap_status">
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
                                    <label style="color:orange;">Georeferenciación latitud (google maps) </label>
                                    <input type="text" class="form-control" name="iap_georef_latitud" id="iap_georef_latitud" placeholder="Georeferenciación latitud (google maps)" value="{{$regiap->iap_georef_latitud}}" required>
                                </div>                                                                
                                <div class="col-xs-4 form-group">
                                    <label style="color:orange;">Georeferenciación longitud (google maps) </label>
                                    <input type="text" class="form-control" name="iap_georef_longitud" id="iap_georef_longitud" placeholder="Georeferenciación longitud (google maps)" value="{{$regiap->iap_georef_longitud}}" required>
                                </div>                                           
                            </div>                            

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label style="color:green">Objeto social (800 carácteres)</label>
                                    <textarea class="form-control" name="iap_objsoc" id="iap_objsoc" rows="6" cols="120" placeholder="Objeto social de la IAP">{{Trim($regiap->iap_objsoc)}}
                                    </textarea>
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
                                    <a href="{{route('verIap')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\iaps5Request','#actualizarIap5') !!}
@endsection

@section('javascrpt')
<script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        startDate: '-29y',
        endDate: '-18y',
        startView: 2,
        maxViewMode: 2,
        clearBtn: true,        
        language: "es",
        autoclose: true
    });
</script>

@endsection