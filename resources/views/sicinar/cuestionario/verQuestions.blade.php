@extends('sicinar.principal')

@section('title','Ver cuestionarios de diligencias')

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
            <h1>Cuestionarios de diligencias
                <small> Seleccionar alguno para editar o registrar nuevo cuestionario</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">Diligencias </a></li>
                <li><a href="#">Cuestionarios    </a></li>         
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="box-header" style="text-align:right;">
                            Busqueda  
                            {{ Form::open(['route' => 'buscarQuestion', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group">
                                    {{ Form::text('folioo', null, ['class' => 'form-control', 'placeholder' => 'folio de visita agenda']) }}
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                    
                                    <a href="{{route('nuevoQuestion')}}" class="btn btn-primary btn_xs" title="Nuevo cuestionario"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo cuestionario
                                    </a> 
                                </div>
                            {{ Form::close() }}
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Folio visita<br>Diligencia </th>
                                        <th style="text-align:left;   vertical-align: middle;">Nombre de la IAP     </th>
                                        <th style="text-align:center; vertical-align: middle;">Quien atendio<br>Diligencia </th>
                                        <th style="text-align:center; vertical-align: middle;">Cargo                </th>
                                        <th style="text-align:center; vertical-align: middle;">Edo.                 </th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regquestdili as $quest)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$quest->visita_folio}}</td>
                                        <td style="text-align:left; vertical-align: middle;">
                                        @foreach($regiap as $iap)
                                            @if($iap->iap_id == $quest->iap_id)
                                                {{$iap->iap_desc}}
                                                @break
                                            @endif
                                        @endforeach 
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$quest->visitaq_spub1}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{$quest->visitaq_cargo1}}</td>                                        
                                        @if($quest->visitaq_status == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        <td style="text-align:center;">
                                            <a href="{{route('editarQuestion',$quest->visita_folio)}}" class="btn badge-warning" title="Editar cuestionario"><i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{route('borrarQuestion',$quest->visita_folio)}}" class="btn badge-danger" title="Eliminar cuestionario" onclick="return confirm('¿Seguro que desea eliminar el cuestionario?')"><i class="fa fa-times"></i>
                                            </a>
                                            <a href="{{route('questionPDF',$quest->visita_folio)}}" class="btn btn-danger" title="Generar cuestionario de criterios de verificación en formato PDF"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                            </a>
                                        </td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regquestdili->appends(request()->input())->links() !!}
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