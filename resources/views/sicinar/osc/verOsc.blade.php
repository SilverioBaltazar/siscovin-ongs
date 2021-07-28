@extends('sicinar.principal')

@section('title','Ver OSC')

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
            <h1>1. Registro OSC
                <small> Seleccionar alguna para editar o registrar nueva OSC</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                
                <li><a href="#">1. Registro OSC  </a></li>   
                
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="page-header" style="text-align:right;">
                            <label style="color:green;"><small><i class="fa fa-check"></i>Activas :</small></label>
                            @foreach($regtotactivas as $total_a)
                               <label style="color:green;"><small>{{$total_a->total_activas}}</small></label>
                            @endforeach
                            <label style="color:red;"><small><i class="fa fa-times"></i>  Inactivas :</small></label>
                            @foreach($regtotinactivas as $total_i)
                               <label style="color:red;"><small>{{$total_i->total_inactivas}} </small></label>
                            @endforeach
                            
                            {{ Form::open(['route' => 'buscarOsc', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group">
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre OSC']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::text('bio', null, ['class' => 'form-control', 'placeholder' => 'Objeto social']) }}
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <a href="{{route('oscexcel')}}" class="btn btn-success" title="Exportar catálogo de OSC (formato Excel)"><i class="fa fa-file-excel-o"></i> Excel
                                    </a>                            
                                    <a href="{{route('nuevaOsc')}}" class="btn btn-primary btn_xs" title="Alta nueva OSC"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nueva OSC
                                    </a>
                                </div>                                
                            {{ Form::close() }}
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Id.              </th>
                                        <th style="text-align:left;   vertical-align: middle;">Nombre de la OSC </th>
                                        <th style="text-align:left;   vertical-align: middle;">Domicilio Legal  </th>     
                                        <th style="text-align:left;   vertical-align: middle;">Registro<br>Const.</th>     
                                        <th style="text-align:left;   vertical-align: middle;">Foto1            </th>
                                        <th style="text-align:left;   vertical-align: middle;">Foto2            </th>
                                        <th style="text-align:center; vertical-align: middle;">Activa <br>Inact.</th>
                                        
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regosc as $osc)
                                    <tr>
                                        <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{$osc->osc_id}}        
                                        </td>
                                        <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{Trim($osc->osc_desc)}}
                                        </td>
                                        <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{$osc->osc_dom1}}     
                                        </td>
                                        <td style="font-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{$osc->osc_regcons}}     
                                        </td>                                                                                
                                        @if(isset($osc->osc_foto1))
                                            <td style="font-family:'Arial, Helvetica, sans-serif'; font-size:10px; text-align:center; vertical-align: middle;" title="Fotografía 1">
                                                <a href="/images/{{$osc->osc_foto1}}" class="btn btn-success" title="Fotografía 1"><i class="fa-file-image-o"></i>gif, jpeg o png
                                                </a>
                                                <a href="{{route('editarOsc1',$osc->osc_id)}}" class="btn badge-warning" title="Editar Fotografía 1"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="font-family:'Arial, Helvetica, sans-serif'; font-size:10px; text-align:center; vertical-align: middle;" title="Sin Fotografía 1"><i class="fa fa-times">{{$osc->osc_foto1}} </i>
                                            <a href="{{route('editarOsc1',$osc->osc_id)}}" class="btn badge-warning" title="Editar Fotografía 1"><i class="fa fa-edit"></i>
                                            </a>
                                        @endif   
                                        @if(isset($osc->osc_foto2))
                                            <td style="font-family:'Arial, Helvetica, sans-serif'; font-size:10px; text-align:center; vertical-align: middle;" title="Fotografía 2">
                                                <a href="/images/{{$osc->osc_foto2}}" class="btn btn-success" title="Fotografía 2"><i class="fa-file-image-o"></i>gif, jpeg o png
                                                </a>
                                                <a href="{{route('editarOsc2',$osc->osc_id)}}" class="btn badge-warning" title="Editar Fotografía 2"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="font-family:'Arial, Helvetica, sans-serif'; font-size:10px; text-align:center; vertical-align: middle;" title="Sin Fotografía 2"><i class="fa fa-times"> </i>
                                            <a href="{{route('editarOsc2',$osc->osc_id)}}" class="btn badge-warning" title="Editar Fotografía 2"><i class="fa fa-edit"></i>
                                            </a>                                                
                                            </td>   
                                        @endif

                                        @if($osc->osc_status == 'S')
                                            <td style="font-family:'Arial, Helvetica, sans-serif'; font-size:10px; text-align:center; vertical-align: middle;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:10px; text-align:center; vertical-align: middle;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarOsc',$osc->osc_id)}}" class="btn badge-warning" title="Editar OSC"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('borrarOsc',$osc->osc_id)}}" class="btn badge-danger" title="Borrar OSC" onclick="return confirm('¿Seguro que desea borrar la OSC?')"><i class="fa fa-times"></i></a>
                                        </td>                                                                                
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regosc->appends(request()->input())->links() !!}
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
