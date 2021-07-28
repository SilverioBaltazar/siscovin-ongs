@extends('sicinar.principal')

@section('title','Editar informe de actividad de labores del programa de trabajo')

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
                <small>3. Requisitos asistenciales     </small>                
                <small>3.3 Informe de labores - editar </small>           
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarInformelab',$regprogdtrab->folio, $regprogdtrab->partida], 'method' => 'PUT', 'id' => 'actualizarInformelab', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <table id="tabla1" class="table table-hover table-striped">
                                <tr>
                                @foreach($regprogtrab as $progtrab)
                                    <td style="color:green;text-align:left; vertical-align: middle;">   
                                        <input type="hidden" id="folio" name="folio" value="{{$progtrab->folio}}">  
                                        <label>Folio: </label>{{$progtrab->folio}}
                                    </td>                                                                 
                                    <td style="color:green;text-align:left; vertical-align: middle;">   
                                        <input type="hidden" id="periodo_id" name="periodo_id" value="{{$progtrab->periodo_id}}">
                                        <label>Periodo fiscal: </label>{{$progtrab->periodo_id}}                                        
                                    </td>
                                    <td style="color:green;text-align:center; vertical-align: middle;"> 
                                        <input type="hidden" id="osc_id" name="osc_id" value="{{$progtrab->osc_id}}">  
                                        <label>OSC: </label>
                                        @foreach($regosc as $osc)
                                            @if($osc->osc_id == $progtrab->osc_id)
                                                {{$osc->osc_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="color:green;text-align:right; vertical-align: middle;">   
                                        <input type="hidden" id="folio" name="folio" value="{{$progtrab->folio}}">  
                                        <input type="hidden" id="periodo_id1" name="periodo_id1" value="{{$progtrab->periodo_id1}}">  
                                        <input type="hidden" id="mes_id1" name="mes_id1" value="{{$progtrab->mes_id1}}">  
                                        <input type="hidden" id="dia_id1" name="dia_id1" value="{{$progtrab->dia_id1}}">  
                                        <label>Responsable: </label>{{$progtrab->responsable}}
                                    </td>                                     
                                </tr>      
                                @endforeach     
                            </table>  

                            <div class="row">
                                <div class="col-xs-12 form-group" style="color:green; vertical-align: middle;">
                                    <label >Programa (500 caracteres)</label>
                                    <textarea class="form-control" name="programa_desc" id="programa_desc" rows="2" cols="120" placeholder="Programa (500 carácteres)">{{Trim($regprogdtrab->programa_desc)}}
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group" style="color:green; vertical-align: middle;">
                                    <label >Actividad (500 caracteres)</label>
                                    <textarea class="form-control" name="actividad_desc" id="actividad_desc" rows="2" cols="120" placeholder="Actividad (300 carácteres)" required>{{Trim($regprogdtrab->actividad_desc)}}
                                    </textarea>
                                </div>                                
                            </div>    
                            <div class="row">
                                <div class="col-xs-12 form-group" style="color:green;vertical-align: middle;">
                                    <label >Objetivo (500 caracteres)</label>
                                    <textarea class="form-control" name="objetivo_desc" id="objetivo_desc" rows="2" cols="120" placeholder="Objetivo (300 carácteres)" required>{{Trim($regprogdtrab->objetivo_desc)}}
                                    </textarea>
                                </div>                                
                            </div>             

                            <div class="row">    
                                <div class="col-xs-4 form-group" style="color:green; vertical-align: middle;">
                                    <label >Unidad de medida:  </label>
                                        @foreach($regumedida as $umedida)
                                            @if($umedida->umedida_id == $regprogdtrab->umedida_id)
                                                {{$umedida->umedida_desc}}
                                                @break                                        
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div> 
                            </div>

                            <div class="row" >
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de enero </label><br>
                                    {{$regprogdtrab->mesp_01}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Avance de enero </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_01" id="mesc_01" placeholder="Avence de febrero" value="{{$regprogdtrab->mesc_01}}" required>
                                </div> 
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de febrero </label><br>
                                    {{$regprogdtrab->mesp_02}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Avance de febrero </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_02" id="mesc_02" placeholder="Avance de febrero" value="{{$regprogdtrab->mesc_02}}" required>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de marzo </label><br>
                                    {{$regprogdtrab->mesp_03}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Avance de marzo </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_03" id="mesc_03" placeholder="Avance de marzo " value="{{$regprogdtrab->mesc_03}}" required>
                                </div>                                 
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de abril </label><br>
                                    {{$regprogdtrab->mesp_04}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Avance de abril </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_04" id="mesc_04" placeholder="Avance de abril " value="{{$regprogdtrab->mesc_04}}" required>
                                </div>                                                                 
                            </div>

                            <div class="row">
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de mayo </label><br>
                                    {{$regprogdtrab->mesp_05}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Avance de mayo </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_05" id="mesc_05" placeholder="Avance de mayo" value="{{$regprogdtrab->mesc_05}}" required>
                                </div> 
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de junio </label><br>
                                    {{$regprogdtrab->mesp_06}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Avance de junio </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_06" id="mesc_06" placeholder="Avance de junio" value="{{$regprogdtrab->mesc_06}}" required>
                                </div>                                                                 
                            </div>

                            <div class="row">                                
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de julio </label><br>
                                    {{$regprogdtrab->mesp_07}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Meta programada de julio </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_07" id="mesc_07" placeholder="Avance de julio" value="{{$regprogdtrab->mesc_07}}" required>
                                </div> 
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de agosto </label><br>
                                    {{$regprogdtrab->mesp_08}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Avance de agosto </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_08" id="mesc_08" placeholder="Avance de agosto " value="{{$regprogdtrab->mesc_08}}" required>
                                </div>                                                                 
                            </div>

                            <div class="row">
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de septiembre </label><br>
                                    {{$regprogdtrab->mesp_09}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label >Avance de septiembre </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_09" id="mesc_09" placeholder="Avance de septiembre " value="{{$regprogdtrab->mesc_09}}" required>
                                </div>
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de octubre </label><br>
                                    {{$regprogdtrab->mesp_10}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label >Avance de octubre </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_10" id="mesc_10" placeholder="Avance de octubre " value="{{$regprogdtrab->mesc_10}}" required>
                                </div> 
                            </div>

                            <div class="row">                                
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de noviembre </label><br>
                                    {{$regprogdtrab->mesp_11}}
                                </div> 
                                <div class="col-xs-2 form-group">
                                    <label >Avance de noviembre </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_11" id="mesc_11" placeholder="Avance de noviembre " value="{{$regprogdtrab->mesc_11}}" required>
                                </div> 
                                <div class="col-xs-3 form-group" style="color:green;vertical-align: middle;">
                                    <label >Meta programada de diciembre </label><br>
                                    {{$regprogdtrab->mesp_12}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label >Avance de diciembre </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesc_12" id="mesc_12" placeholder="Avance de diciembre " value="{{$regprogdtrab->mesc_12}}" required>
                                </div>                                 
                            </div>               
                                            
                             <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (300 carácteres)</label>
                                    <textarea class="form-control" name="dobs_2" id="dobs_2" rows="3" cols="120" placeholder="Observaciones (300 carácteres)" required>{{Trim($regprogdtrab->dobs_2)}}
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
                                    @foreach($regprogtrab as $progtrab)
                                       <a href="{{route('verInformelab',$progtrab->folio)}}" role="button" id="cancelar" class="btn btn-danger">Cancelar
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
    {!! JsValidator::formRequest('App\Http\Requests\informelabRequest','#actualizarInformelab') !!}
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

