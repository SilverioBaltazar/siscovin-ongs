@extends('sicinar.principal')

@section('title','Editar beneficiario')

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
                <small>2. Requisitos de operación</small>                
                <small> Padrón - editar beneficiario</small>           
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title"><b>Recordatorio: </b>El registro del padrón de beneficiarios deberá realizarse mensualmente.
                            </h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarPadron',$regpadron->folio], 'method' => 'PUT', 'id' => 'actualizarPadron', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">    
                                <div class="col-xs-8 form-group">
                                    <input type="hidden" name="osc_id" id="osc_id" value="{{$regpadron->osc_id}}">
                                    <label>OSC &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regosc as $osc)
                                        @if($osc->osc_id == $regpadron->osc_id)
                                            <label style="color:green;">{{$regpadron->osc_id.' '.$osc->osc_desc}}</label>
                                            @break
                                        @endif 
                                    @endforeach
                                </div>              
                                <div class="col-xs-4 form-group">
                                    <input type="hidden" id="folio" name="folio" value="{{$regpadron->folio}}">  
                                    <label >Folio asignado </label><br>
                                    <label style="color:green;">{{$regpadron->folio}} </label>
                                </div>    
                            </div>

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de ingreso - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de ingreso </option>
                                        @foreach($regperiodos as $periodo)
                                            @if($periodo->periodo_id == $regpadron->periodo_id1)
                                                <option value="{{$periodo->periodo_id}}" selected>{{$periodo->periodo_desc}}</option>
                                            @else                                        
                                               <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}} 
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de ingreso </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $regpadron->mes_id1)
                                                <option value="{{$mes->mes_id}}" selected>{{$mes->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="col-xs-4 form-group">
                                    <label >Día </label>
                                    <select class="form-control m-bot15" name="dia_id1" id="dia_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar día de ingreso </option>
                                        @foreach($regdias as $dia)
                                            @if($dia->dia_id == $regpadron->dia_id1)
                                                <option value="{{$dia->dia_id}}" selected>{{$dia->dia_desc}}</option>
                                            @else                                        
                                               <option value="{{$dia->dia_id}}">{{$dia->dia_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Apellido paterno </label>
                                    <input type="text" class="form-control" name="primer_apellido" id="primer_apellido" placeholder="Apellido paterno" value="{{$regpadron->primer_apellido}}" onkeypress="return soloLetras(event)" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Apellido materno </label>
                                    <input type="text" class="form-control" name="segundo_apellido" id="segundo_apellido" placeholder="Apellido materno" value="{{$regpadron->segundo_apellido}}" onkeypress="return soloLetras(event)" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Nombre(s) </label>
                                    <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombre(s)" value="{{$regpadron->nombres}}" onkeypress="return soloLetras(event)" required>
                                </div>
                            </div>

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de nacimiento - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id2" id="periodo_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de nacimiento </option>
                                        @foreach($regperiodos as $periodo)
                                            @if($periodo->periodo_id == $regpadron->periodo_id2)
                                                <option value="{{$periodo->periodo_id}}" selected>{{$periodo->periodo_desc}}</option>
                                            @else                                        
                                               <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}} 
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id2" id="mes_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de nacimiento </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $regpadron->mes_id2)
                                                <option value="{{$mes->mes_id}}" selected>{{$mes->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="col-xs-4 form-group">
                                    <label >Día </label>
                                    <select class="form-control m-bot15" name="dia_id2" id="dia_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar día de nacimiento </option>
                                        @foreach($regdias as $dia)
                                            @if($dia->dia_id == $regpadron->dia_id2)
                                                <option value="{{$dia->dia_id}}" selected>{{$dia->dia_desc}}</option>
                                            @else                                        
                                               <option value="{{$dia->dia_id}}">{{$dia->dia_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >CURP </label>
                                    <input type="text" class="form-control" name="curp" id="curp" placeholder="CURP" value="{{$regpadron->curp}}" onkeypress="return soloAlfaSE(event)" required>
                                </div>        
                                <div class="col-xs-4 form-group">                        
                                    <label>Sexo </label>
                                    <select class="form-control m-bot15" name="sexo" id="sexo" required>
                                        @if($regpadron->sexo == 'H')
                                            <option value="H" selected>Hombre </option>
                                            <option value="M">         Mujer  </option>
                                        @else
                                            <option value="H">         Hombre </option>
                                            <option value="M" selected>Mujer  </option>
                                        @endif
                                    </select>
                                </div>                                   
                            </div>                                

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Domicilio (Calle, no.ext/int.) </label>
                                    <input type="text" class="form-control" name="domicilio" id="domicilio" value="{{trim($regpadron->domicilio)}}" placeholder="Domicilio donde vive" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Colonia)</label>
                                    <input type="text" class="form-control" name="colonia" id="colonia" value="{{trim($regpadron->colonia)}}" placeholder="Colonia" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Código postal </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="cp" id="cp" placeholder="Código postal" value="{{$regpadron->cp}}" required>
                                </div>                                                                                  
                            </div>

                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Entidad federativa</label>
                                    <select class="form-control m-bot15" name="entidad_fed_id" id="entidad_fed_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar entidad federativa</option>
                                        @foreach($regentidades as $estado)
                                            @if($estado->entidadfederativa_id == $regpadron->entidad_fed_id)
                                                <option value="{{$estado->entidadfederativa_id}}" selected>{{$estado->entidadfederativa_desc}}</option>
                                            @else                                        
                                               <option value="{{$estado->entidadfederativa_id}}">{{$estado->entidadfederativa_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>                                                
                                <div class="col-xs-4 form-group">
                                    <label >Municipio </label>
                                    <input type="text" class="form-control" name="localidad" id="localidad" placeholder="Municipio" value="{{Trim($regpadron->localidad)}}" required>
                                </div>                                                                                      
                                <!--                              
                                <div class="col-xs-4 form-group">
                                    <label >Municipio</label>
                                    <select class="form-control m-bot15" name="municipio_id" id="municipio_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar municipio</option>
                                        @foreach($regmunicipio as $municipio)
                                            @if($municipio->municipioid == $regpadron->municipio_id)
                                                <option value="{{$municipio->municipioid}}" selected>{{$municipio->entidadfederativa_desc.'-'.$municipio->municipionombre}}</option>
                                            @else 
                                               <option value="{{$municipio->municipioid}}">{{$municipio->entidadfederativa_desc.'-'.$municipio->municipionombre}}
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>
                                -->                                    
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono" value="{{$regpadron->telefono}}" required>
                                </div>                                                                 
                                <div class="col-xs-4 form-group">
                                    <label >Servicio que le brindan</label>
                                    <select class="form-control m-bot15" name="servicio_id" id="servicio_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar servicio</option>
                                        @foreach($regservicios as $servicio)
                                            @if($servicio->servicio_id == $regpadron->servicio_id)
                                                <option value="{{$servicio->servicio_id}}" selected>{{$servicio->servicio_desc.'-'.$servicio->rubro_desc}}
                                                </option>
                                            @else 
                                               <option value="{{$servicio->servicio_id}}">{{$servicio->servicio_desc.'-'.$servicio->rubro_desc}}
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>   
                            </div>

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label >Integrantes de la familia </label>
                                    <input type="number" min="0" max="99" class="form-control" name="integ_fam" id="integ_fam" placeholder=" Integrantes de la familia"value="{{$regpadron->integ_fam}}" required>
                                </div>
                                <div class="col-xs-3 form-group">
                                    <label >Cuota de recuperación </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="cuota_recup" id="cuota_recup" placeholder="Cuota de recuperación" value="{{$regpadron->cuota_recup}}" required>
                                </div>                                
                                <div class="col-xs-4 form-group">                        
                                    <label>Beneficiario Activo o Inactivo </label>
                                    <select class="form-control m-bot15" name="status_1" required>
                                        @if($regpadron->status_1 == 'S')
                                            <option value="S" selected>Activo  </option>
                                            <option value="N">         Inactivo</option>
                                        @else
                                            <option value="S">         Activo  </option>
                                            <option value="N" selected>Inactivo</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Motivo del ingreso (300 carácteres)</label>
                                    <textarea class="form-control" name="motivo_ing" id="motivo_ing" rows="3" cols="120" placeholder="Motivo del ingreso (300 carácteres)" required>{{Trim($regpadron->motivo_ing)}}
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Quien lo canalizó (300 carácteres)</label>
                                    <textarea class="form-control" name="quien_canalizo" id="quien_canalizo" rows="3" cols="120" placeholder="Quien lo canalizó (300 carácteres)" required>{{Trim($regpadron->quien_canalizo)}}
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
                                    <a href="{{route('verPadron')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\padronRequest','#actualizarPadron') !!}
@endsection

@section('javascrpt')
<script>
    function soloNumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "1234567890";
       especiales = "8-37-39-46";
       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }    

    function soloAlfa(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ.";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
    function general(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890,.;:-_<>!%()=?¡¿/*+";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
    function soloAlfaSE(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }    
</script>

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

