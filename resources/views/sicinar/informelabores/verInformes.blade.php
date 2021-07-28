@extends('sicinar.principal')

@section('title','Ver informe de labores del programa de trabajo')

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
            <h1>3. Requisitos asistenciales
                <small>3.3 Seleccionar para editar o registrar informe de labores </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">3. Requisitos asistenciales </a></li>   
                <li><a href="#">3.3 Informe de labores       </a></li>               
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="page-header" style="text-align:right;">
                            
                            {{ Form::open(['route' => 'buscarInforme', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group">
                                    {{ Form::text('nameiap', null, ['class' => 'form-control', 'placeholder' => 'Nombre OSC']) }}
                                </div>                                                                 
                                <div class="form-group">
                                    {{ Form::text('folio', null, ['class' => 'form-control', 'placeholder' => 'Folio']) }}
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                            {{ Form::close() }}
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo        </th>
                                        <th style="text-align:left;   vertical-align: middle;">OSC            </th>
                                        <th style="text-align:left;   vertical-align: middle;">Folio          </th>                                        
                                        <th style="text-align:left;   vertical-align: middle;">Responsable    </th>
                                        <th style="text-align:left;   vertical-align: middle;">Elaboró        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Autorizó       </th>
                                        <th style="text-align:left;   vertical-align: middle;">Actividades    </th>
                                        <th style="text-align:left;   vertical-align: middle;">Fec. Reg.      </th>                                           
                                        <th style="text-align:center; vertical-align: middle;">Activo <br>Inact.</th>
                                        
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Funciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regprogtrab as $progtrab)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$progtrab->periodo_id}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{$progtrab->osc_id}}   
                                            @foreach($regosc as $osc)
                                                @if($osc->osc_id == $progtrab->osc_id)
                                                    {{$osc->osc_desc}}
                                                    @break 
                                                @endif
                                            @endforeach
                                        </td>                                          
                                        <td style="text-align:left; vertical-align: middle;">{{$progtrab->folio}}     </td>                                        
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($progtrab->responsable)}}
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($progtrab->elaboro)}}    
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                            {{Trim($progtrab->autorizo)}}    
                                        </td>
                                        <td style="text-align:center; vertical-align: middle;"><small>
                                            @foreach($totactivs as $partida)
                                                @if($partida->periodo_id == $progtrab->periodo_id && $partida->folio == $progtrab->folio)
                                                    @if(!empty($partida->totactividades)&&(!is_null($partida->totactividades)))
                                                        @if($partida->totactividades > 0)
                                                            <b style="color:darkgreen;">{{$partida->totactividades}}</b>
                                                        @else
                                                            <b style="color:darkred;">0 Faltan las actividades </b>
                                                        @endif                                                      
                                                    @else
                                                        <b style="color:darkred;">0 Faltan las actividades </b>
                                                    @endif  
                                                    @break
                                                @endif
                                            @endforeach </small>
                                        </td>                                                                                 
                                        <td style="text-align:left; vertical-align: middle;">{{date("d/m/Y",strtotime($progtrab->fecreg))}}</td>
                                        @if($progtrab->status_1 == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        

                                        <td style="text-align:center;">
                                            <a href="{{route('ExportInformePdf',array($progtrab->periodo_id,$progtrab->folio))}}" class="btn btn-danger" title="Informe de labores del Programa de trabajo (formato PDF)"><i class="fa fa-file-pdf-o"></i>
                                            <small> PDF</small> 
                                            </a>
                                            <a href="{{route('verInformelab',$progtrab->folio)}}" class="btn btn-primary btn_xs" title="Ver informe de labores del programa de trabajo"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span><small>Inf. labores</small>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regprogtrab->appends(request()->input())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
@endsection

@section('javascrpt')
@endsection
