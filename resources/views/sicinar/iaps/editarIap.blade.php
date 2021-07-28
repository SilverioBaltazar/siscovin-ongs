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
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Menú
                <small>ONGS - Directorio - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarIap',$regiap->iap_id], 'method' => 'PUT', 'id' => 'actualizarIap', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 offset-md-12">
                                    <label>Id.: {{$regiap->iap_id}}</label>
                                </div>             
                                <div class="col-xs-4 form-group">
                                    <label >ONG </label>
                                    <input type="text" class="form-control" name="iap_desc" placeholder="Nombre de la ONG" value="{{$regiap->iap_desc}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >RFC </label>
                                    <input type="text" class="form-control" name="iap_rfc" id="iap_rfc" placeholder="RFC" value="{{Trim($regiap->iap_rfc)}}" required>
                                </div>  
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Figura jurídica  </label>
                                    <select class="form-control m-bot15" name="figurajuridica_id" id="figurajuridica_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar figura jurídica </option>
                                        @foreach($regfigurajur as $figura)
                                            @if($figura->figurajuridica_id == $regiap->figurajuridica_id)
                                                <option value="{{$figura->figurajuridica_id}}" selected>{{trim($figura->figurajuridica_desc)}}</option>
                                            @else                                        
                                               <option value="{{$figura->figurajuridica_id}}">{{$figura->figurajuridica_id}} - {{trim($figura->figurajuridica_desc)}} 
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Rubro  </label>
                                    <select class="form-control m-bot15" name="rubro_id" id="rubro_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar rubro </option>
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
                                    <label >Domicilio Legal (Calle, no.ext/int., colonia) </label>
                                    <input type="text" class="form-control" name="iap_dom1" id="iap_dom1" placeholder="Domicilio Legal" value="{{Trim($regiap->iap_dom1)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Domicilio 2 (Calle, no.ext/int., colonia)</label>
                                    <input type="text" class="form-control" name="iap_dom2" id="iap_dom2" placeholder="Domicilio Fiscal" value="{{Trim($regiap->iap_dom2)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Domicilio 3 (Calle, no.ext/int., colonia) </label>
                                    <input type="text" class="form-control" name="iap_dom3" id="iap_dom3" placeholder="Domicilio Asistencial" value="{{Trim($regiap->iap_dom3)}}" required>
                                </div>                                
                            </div>

                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Código postal </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="iap_cp" id="iap_cp" placeholder="Código postal" value="{{Trim($regiap->iap_cp)}}" required>
                                </div>                                                                        
                                <div class="col-xs-4 form-group">
                                    <label >Entidad federativa</label>
                                    <select class="form-control m-bot15" name="entidadfederativa_id" id="entidadfederativa_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar entidad federativa</option>
                                        @foreach($regentidades as $estado)
                                            @if($estado->entidadfederativa_id == $regiap->entidadfederativa_id)
                                                <option value="{{$estado->entidadfederativa_id}}" selected>{{$estado->entidadfederativa_desc}}</option>
                                            @else                                        
                                               <option value="{{$estado->entidadfederativa_id}}">{{$estado->entidadfederativa_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>                                                                                      
                                <div class="col-xs-4 form-group">
                                    <label >Municipio</label>
                                    <select class="form-control m-bot15" name="municipio_id" id="municipio_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar municipio</option>
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
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="iap_telefono" id="iap_telefono" placeholder="Teléfono" value="{{Trim($regiap->iap_telefono)}}" required>
                                </div>                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Correo electrónico </label>
                                    <input type="text" class="form-control" name="iap_email" id="iap_email" placeholder=" Correo electrónico" value="{{Trim($regiap->iap_email)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Sitio web </label>
                                    <input type="text" class="form-control" name="iap_sweb" id="iap_sweb" placeholder=" Sitio web o pagina electrónica" value="{{Trim($regiap->iap_sweb)}}" required>
                                </div>                                
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de constitución (dd/mm/aaaa) </label>
                                    <input type="text" class="form-control" name="iap_feccons2" id="iap_feccons2" placeholder="dd/mm/aaaa" value="{{Trim($regiap->iap_feccons2)}}" required>
                                </div>                                                                 
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de vencimiento del Patronato (dd/mm/aaaa) </label>
                                    <input type="text" class="form-control" name="iap_fvp2" id="iap_fvp2" placeholder="dd/mm/aaaa" value="{{Trim($regiap->iap_fvp2)}}" required>
                                </div>                                  
                            </div>


                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Registro de constitución </label>
                                    <input type="text" class="form-control" name="iap_regcons" id="iap_regcons" placeholder="Registro de constitución de la IAP" value="{{Trim($regiap->iap_regcons)}}" required>
                                </div>                                                                                    
                                <div class="col-xs-4 form-group">
                                    <label >Vigencia del patronato en años</label>
                                    <select class="form-control m-bot15" name="anio_id" id="anio_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar la vigencia </option>
                                        @foreach($regvigencia as $vigencia)
                                            @if($vigencia->anio_id == $regiap->anio_id)
                                                <option value="{{$vigencia->anio_id}}" selected>{{$vigencia->anio_desc}}</option>
                                            @else                                        
                                               <option value="{{$vigencia->anio_id}}">{{$vigencia->anio_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Situación del inmueble</label>
                                    <select class="form-control m-bot15" name="inm_id" id="inm_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar situación del inmueble</option>
                                        @foreach($reginmuebles as $inmueble)
                                            @if($inmueble->inm_id == $regiap->inm_id)
                                                <option value="{{$inmueble->inm_id}}" selected>{{$inmueble->inm_desc}}</option>
                                            @else 
                                               <option value="{{$inmueble->inm_id}}">{{$inmueble->inm_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>                                    
                            </div>
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Presidente </label>
                                    <input type="text" class="form-control" name="iap_pres" id="iap_pres" placeholder=" Presidente" value="{{Trim($regiap->iap_pres)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Representante legal </label>
                                    <input type="text" class="form-control" name="iap_replegal" id="iap_replegal" placeholder="Representante legal" value="{{Trim($regiap->iap_replegal)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Secretario </label>
                                    <input type="text" class="form-control" name="iap_srio" id="iap_srio" placeholder="Secretario" value="{{Trim($regiap->iap_srio)}}" required>
                                </div>                          
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Tesorero </label>
                                    <input type="text" class="form-control" name="iap_tesorero" id="iap_tesorero" placeholder="Tesorero" value="{{Trim($regiap->iap_tesorero)}}" required>
                                </div>                                                                
                                <div class="col-xs-4 form-group">                        
                                    <label>Activa o Inactiva </label>
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
                                    <label >Georeferenciación latitud (google maps) </label>
                                    <input type="text" class="form-control" name="iap_georef_latitud" id="iap_georef_latitud" placeholder="Georeferenciación latitud (google maps)" value="{{$regiap->iap_georef_latitud}}" required>
                                </div>                                                                
                                <div class="col-xs-4 form-group">
                                    <label >Georeferenciación longitud (google maps) </label>
                                    <input type="text" class="form-control" name="iap_georef_longitud" id="iap_georef_longitud" placeholder="Georeferenciación longitud (google maps)" value="{{$regiap->iap_georef_longitud}}" required>
                                </div>                                           
                            </div>                            

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Objeto social (800 carácteres)</label>
                                    <textarea class="form-control" name="iap_objsoc" id="iap_objsoc" rows="6" cols="120" placeholder="Objeto social de la IAP" required>{{Trim($regiap->iap_objsoc)}}
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (200 carácteres)</label>
                                    <textarea class="form-control" name="iap_obs1" id="iap_obs1" rows="3" cols="120" placeholder="Observaciones" required>{{Trim($regiap->iap_obs1)}}
                                    </textarea>
                                </div>                                
                            </div>                            
                            <div class="row">
                                @if (!empty($regiap->iap_foto1)||!is_null($regiap->iap_foto1))  
                                    <div class="col-sm">
                                        <div class="card" style="width: 18rem;">
                                           <label >Fotografía 1 </label>
                                           <img class="card-img-top" src="/images/{{$regiap->iap_foto1}}" alt="foto 1">
                                           <!--<input type="hidden" name="iap_foto1" id="iap_foto1" value="{{$regiap->iap_foto1}}">-->
                                        </div>
                                    </div>      
                                @else     <!-- se captura foto 1 -->
                                    <div class="col-xs-4 form-group">
                                        <label >Archivo de foto 1 </label>
                                        <input type="file" class="text-md-center" style="color:red" name="iap_foto1" id="iap_foto1" placeholder="Subir archivo de fotografía 1" >
                                    </div>                                                
                                @endif                                    
                                @if (isset($regiap->iap_foto2)||!empty($regiap->iap_foto2)||!is_null($regiap->iap_foto2)) 
                                    <div class="col-sm">
                                        <div class="card" style="width: 18rem;">
                                           <label >Fotografía 2 </label>
                                           <img class="card-img-top" src="/images/{{$regiap->iap_foto2}}" alt="foto 2">
                                           <!--<input type="hidden" name="iap_foto2" id="iap_foto2" value="{{$regiap->iap_foto2}}"> -->
                                        </div>
                                    </div>   
                                @else      
                                    <div class="col-xs-4 form-group">
                                        <label >Archivo de foto 2 </label>
                                        <input type="file" class="text-md-center" style="color:red" name="iap_foto2" id="iap_foto2" placeholder="Subir archivo de fotografía 2" >
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
    {!! JsValidator::formRequest('App\Http\Requests\iapsRequest','#actualizarIap') !!}
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