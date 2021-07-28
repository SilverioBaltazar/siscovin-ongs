@extends('sicinar.principal')

@section('title','Editar curso')

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
    <!DOCTYPE html>
    <html lang="es">
    <div class="content-wrapper">
        <section class="content-header">
            <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
            <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
            <h1>
                Menú
                <small> Instituciones Privadas (IAPS) - Cursos - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Editar Curso</h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarCurso',$regcursos->curso_id], 'method' => 'PUT', 'id' => 'actualizarCurso', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Periodo fiscal </label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo fiscal </option>
                                        @foreach($regperiodos as $periodo)
                                            @if($periodo->periodo_id == $regcursos->periodo_id)
                                                <option value="{{$periodo->periodo_id}}" selected>{{$periodo->periodo_desc}}</option>
                                            @else                                        
                                               <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}} 
                                               </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Mes de aplicación </label>
                                    <select class="form-control m-bot15" name="mes_id" id="mes_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de aplicación </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $regcursos->mes_id)
                                                <option value="{{$mes->mes_id}}" selected>{{$mes->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                
                                <div class="col-xs-4 form-group">
                                    <label>Id del curso: {{$regcursos->curso_id}}</label>
                                </div>                                             
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre del curso </label>
                                    <input type="text" class="form-control" name="curso_desc" id="curso_desc" placeholder="Nombre del curso" value="{{Trim($regcursos->curso_desc)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Objetivo del curso</label>
                                    <input type="text" class="form-control" name="curso_obj" id="curso_obj" placeholder="Objetivo del curso" value="{{Trim($regcursos->curso_obj)}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Ponente(s) </label>
                                    <input type="text" class="form-control" name="curso_ponentes" id="curso_ponentes" placeholder="Ponente(s) del curso" value="{{Trim($regcursos->curso_ponentes)}}" required>
                                </div>                                
                            </div>                            

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Fecha de inicio del curso - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de inicio </option>
                                        @foreach($regperiodos as $periodo)
                                            @if($periodo->periodo_id == $regcursos->periodo_id1)
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
                                        <option selected="true" disabled="disabled">Seleccionar mes de inicio </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $regcursos->mes_id1)
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
                                        <option selected="true" disabled="disabled">Seleccionar día de inicio </option>
                                        @foreach($regdias as $dia)
                                            @if($dia->dia_id == $regcursos->dia_id1)
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
                                    <label >Fecha de termino del curso - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id2" id="periodo_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar año de ntermino </option>
                                        @foreach($regperiodos as $periodo)
                                            @if($periodo->periodo_id == $regcursos->periodo_id2)
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
                                        <option selected="true" disabled="disabled">Seleccionar mes de termino </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $regcursos->mes_id2)
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
                                        <option selected="true" disabled="disabled">Seleccionar día de termino </option>
                                        @foreach($regdias as $dia)
                                            @if($dia->dia_id == $regcursos->dia_id2)
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
                                    <label >Costo del curso </label>
                                    <input type="text" class="form-control" name="curso_costo" id="curso_costo" placeholder="Costo del curso" value="{{$regcursos->curso_costo}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Total de horas</label>
                                    <input type="text" class="form-control" name="curso_thoras" id="curso_thoras" placeholder="Total de horas" value="{{$regcursos->curso_thoras}}" required>
                                </div>
                                <div class="col-xs-4 form-group">
                                    <label >Total de dias</label>
                                    <input type="text" class="form-control" name="curso_tdias" id="curso_tdias" placeholder="Total de dias" value="{{$regcursos->curso_tdias}}" required>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">                        
                                    <label>Estado del curso (Activo, Inactivo o Cerrado)  </label>
                                    <select class="form-control m-bot15" name="curso_status" id="curso_status" required>
                                        @if($regcursos->curso_status == 'S')
                                            <option value="S" selected>Vigente</option>
                                            <option value="N">         Inactivo</option>
                                            <option value="C">         Cerrado</option>
                                        @else
                                            @if($regcursos->curso_status == 'N')
                                                <option value="S">         Vigente</option>
                                                <option value="N" selected>Inactivo</option>
                                                <option value="C">         Cerrado</option>
                                            @else
                                                <option value="S">         Vigente</option>
                                                <option value="N">         Inactivo</option>
                                                <option value="C" selected>Cerrado</option>
                                            @endif
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (4,000 carácteres)</label>
                                    <textarea class="form-control" name="curso_obs" id="curso_obs" rows="3" cols="120" placeholder="Observaciones" required>{{Trim($regcursos->curso_obs)}}
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
                                    <a href="{{route('verCursos')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\cursosRequest','#actualizarCurso') !!}
@endsection

@section('javascrpt')
@endsection