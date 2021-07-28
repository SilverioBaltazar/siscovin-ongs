@extends('sicinar.principal')

@section('title','Ver requisitos asistenciales')

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
            <h1>IAPS - requisitos asistenciales
                <small> Seleccionar requisito asistencial para editar o registrar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">Instituciones de Asistencia Privada (IAPS) </a></li>
                <li><a href="#">requisitos asistenciales  </a></li>         
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header" style="text-align:right;">
                            <a href="{{route('nuevoReqa')}}" class="btn btn-primary btn_xs" title="Registrar requisitos asistenciales"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Registrar requisitos asistenciales</a>
                        </div>                        
                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Id.                </th>
                                        <th style="text-align:left;   vertical-align: middle;">IAP                </th>
                                        <th style="text-align:center; vertical-align: middle;">Padrón<br>Benef.   </th>
                                        <th style="text-align:center; vertical-align: middle;">Plantilla<br>Personal</th>
                                        <th style="text-align:center; vertical-align: middle;">Detección<br>Neces.</th>
                                        <th style="text-align:center; vertical-align: middle;">Prog.    <br>Trab. </th>
                                        <th style="text-align:center; vertical-align: middle;">Inf.anual<br>Labores</th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($regasistencia as $asistencial)
                                    <tr>
                                        @foreach($regiap as $iap)
                                            @if($iap->iap_id == $asistencial->iap_id)
                                                <td style="text-align:left; vertical-align: middle;">{{$iap->iap_id}}</td>
                                                <td style="text-align:left; vertical-align: middle;">{{Trim($iap->iap_desc)}}
                                                </td>                                                        
                                                @break
                                            @endif
                                        @endforeach    
                                        @if(!empty($asistencial->iap_d1)&&(!is_null($asistencial->iap_d1)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Padrón de beneficiarios">
                                                <a href="/images/{{$asistencial->iap_d1}}" class="btn btn-success" title="Padrón de beneficiarios"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                                </a>
                                                <a href="{{route('editarReqa1',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Padrón de beneficiarios"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Padrón de beneficiarios"><i class="fa fa-times"></i>
                                                <a href="{{route('editarReqa1',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Padrón de beneficiarios"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif
                                        @if(!empty($asistencial->iap_d2)&&(!is_null($asistencial->iap_d2)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Plantilla de personal">
                                                <a href="/images/{{$asistencial->iap_d2}}" class="btn btn-success" title="Plantilla de personal"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                                </a>
                                                <a href="{{route('editarReqa2',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Plantilla de personal"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Plantilla de personal"><i class="fa fa-times"></i>
                                                <a href="{{route('editarReqa2',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Plantilla de personal"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif
                                        @if(!empty($asistencial->iap_d3)&&(!is_null($asistencial->iap_d3)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Detección de necesidades">
                                                <a href="/images/{{$asistencial->iap_d3}}" class="btn btn-danger" title="Detección de necesidades"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                                </a>
                                                <a href="{{route('editarReqa3',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Detección de necesidades"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Detección de necesidades"><i class="fa fa-times"></i>
                                                <a href="{{route('editarReqa3',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Detección de necesidades"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif
                                        @if(!empty($asistencial->iap_d4)&&(!is_null($asistencial->iap_d4)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Programa de trabajo">
                                                <a href="/images/{{$asistencial->iap_d4}}" class="btn btn-danger" title="Programa de trabajo"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                                </a>
                                                <a href="{{route('editarReqa4',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Programa de trabajo"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Programa de trabajo"><i class="fa fa-times"></i>
                                                <a href="{{route('editarReqa4',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Programa de trabajo"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif
                                        @if(!empty($asistencial->iap_d5)&&(!is_null($asistencial->iap_d5)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Informe de labores">
                                                <a href="/images/{{$asistencial->iap_d5}}" class="btn btn-danger" title="Informe de labores"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                                </a>
                                                <a href="{{route('editarReqa5',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Informe de labores"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Informe de labores"><i class="fa fa-times"></i>
                                                <a href="{{route('editarReqa5',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar Informe de labores"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif

                                        <td style="text-align:center; vertical-align: middle;">
                                            <a href="{{route('editarReqa',$asistencial->iap_id)}}" class="btn badge-warning" title="Editar requisitos asistenciales"><i class="fa fa-edit"></i>
                                            </a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarReqa',$asistencial->iap_id)}}" class="btn badge-danger" title="Borrar registro" onclick="return confirm('¿Seguro que desea borrar requisitos asistenciales?')"><i class="fa fa-times"></i>
                                                </a>                                            
                                            @endif
                                        </td>
                    
                                    </tr>   
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regasistencia->appends(request()->input())->links() !!}
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
