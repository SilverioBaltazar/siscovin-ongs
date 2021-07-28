@extends('sicinar.principal')

@section('title','Ver cédula de detección de necesidades')

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
            <h1>Requisitos asistenciales
                <small> Seleccionar alguna para editar o registrar cédula </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">Requisitos asistenciales </a></li>   
                <li><a href="#">Cédula de detección de necesidades  </a></li>               
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="page-header" style="text-align:right;">
                            Buscar  
                            {{ Form::open(['route' => 'buscarCedula', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group">
                                    {{ Form::text('folio', null, ['class' => 'form-control', 'placeholder' => 'Folio']) }}
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                                <div class="form-group">   
                                    <a href="{{route('nuevaCedula')}}" class="btn btn-primary btn_xs" title="Nueva Cédula"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span><small>Nueva Cédula</small>
                                    </a>
                                </div>                                
                            {{ Form::close() }}
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>

                                        <th style="text-align:left;   vertical-align: middle;">Periodo        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Folio          </th>
                                        <th style="text-align:left;   vertical-align: middle;">IAP            </th>
                                        <th style="text-align:left;   vertical-align: middle;">Responsable    </th>
                                        <th style="text-align:left;   vertical-align: middle;">Artículos      </th>
                                        <th style="text-align:center; vertical-align: middle;">Activa <br>Inact.</th>
                                        
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Funciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regcedula as $cedula)

                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$cedula->periodo_id}}  </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$cedula->cedula_folio}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{$cedula->iap_id}}   
                                            @foreach($regiap as $iap)
                                                @if($iap->iap_id == $cedula->iap_id)
                                                    {{$iap->iap_desc}}
                                                    @break
                                                @endif 
                                            @endforeach
                                        </td>                                          
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($cedula->sp_nomb)}}</td>
                                        <td style="text-align:center; vertical-align: middle;"><small>
                                            @foreach($totarticulos as $partida)
                                                @if($partida->periodo_id == $cedula->periodo_id && $partida->cedula_folio == $cedula->cedula_folio)
                                                    {{$partida->totarticulos}}
                                                    @break
                                                @endif
                                            @endforeach </small>
                                        </td>                                                                                 
                                        @if($cedula->cedula_status == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Activa"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Inactiva"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarCedula',$cedula->cedula_folio)}}" class="btn badge-warning" title="Editar cédula"><i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{route('borrarCedula',$cedula->cedula_folio)}}" class="btn badge-danger" title="Borrar cédula de detección de necesidades" onclick="return confirm('¿Seguro que desea borrar cédula de detección de necesidades?')"><i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{route('ExportCedulaPdf',array($cedula->periodo_id,$cedula->cedula_folio))}}" class="btn btn-danger" title="Cédula de detección de necesidades en formato PDF"><i class="fa fa-file-pdf-o"></i>
                                            <small> PDF</small>
                                            </a>
                                            <a href="{{route('verCedulaarti',array($cedula->periodo_id,$cedula->cedula_folio))}}" class="btn btn-primary btn_xs" title="Ver artículos de la cédula de detección de necesidades"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span><small>Artículos</small>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regcedula->appends(request()->input())->links() !!}
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
