@extends('sicinar.principal')

@section('title','Ver padrón de beneficiarios')

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
            <h1>Requisitos de operación
                <small> Seleccionar alguna para editar o registrar beneficiario </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">Requisitos de operación   </a></li>   
                <li><a href="#">Padrón de beneficiarios   </a></li>               
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="page-header" style="text-align:right;">
                            Buscar  
                            {{ Form::open(['route' => 'buscarPadron', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group">
                                    {{ Form::text('nameiap', null, ['class' => 'form-control', 'placeholder' => 'Nombre OSC']) }}
                                </div>                                                             
                                <div class="form-group">
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre beneficiario']) }}
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <a href="{{route('ExportPadronExcel')}}" class="btn btn-success" title="Exportar padrón de Beneficiarios (formato Excel)"><i class="fa fa-file-excel-o"></i> Excel
                                    </a>                            
                                    <a href="{{route('nuevoPadron')}}" class="btn btn-primary btn_xs" title="Nuevo beneficiario"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo beneficiario
                                    </a>
                                </div>                                
                            {{ Form::close() }}
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Folio          </th>
                                        <th style="text-align:left;   vertical-align: middle;">OSC           </th>
                                        <th style="text-align:left;   vertical-align: middle;">Beneficiaria(o)</th>
                                        <th style="text-align:left;   vertical-align: middle;">CURP           </th>
                                        <th style="text-align:left;   vertical-align: middle;">Fecha <br>Nac. </th>
                                        <th style="text-align:center; vertical-align: middle;">Activa <br>Inact.</th>
                                        
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regpadron as $padron)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$padron->folio}}    </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$padron->osc_id}}   
                                            @foreach($regosc as $osc)
                                                @if($osc->osc_id == $padron->osc_id)
                                                    {{$osc->osc_desc}}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>                                          
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($padron->nombre_completo)}}
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$padron->curp}}    </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                            {{$padron->fecha_nacimiento2}}    
                                        </td>
                                                                                
                                        @if($padron->status_1 == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarPadron',$padron->folio)}}" class="btn badge-warning" title="Editar beneficiario"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarPadron',$padron->folio)}}" class="btn badge-danger" title="Borrar beneficiario del padrón" onclick="return confirm('¿Seguro que desea borrar beneficiario del padrón?')"><i class="fa fa-times"></i></a>
                                            @endif                                                
                                        </td>                                                                                
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regpadron->appends(request()->input())->links() !!}
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