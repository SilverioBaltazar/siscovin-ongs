@extends('sicinar.principal')

@section('title','Ver cursos')

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
            <h1>Cursos
                <small> Seleccionar alguno para editar o registrar nuevo curso</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">IAPS </a></li>
                <li><a href="#">Cursos   </a></li>         
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header" style="text-align:right;">
                            <a href="{{route('nuevoCurso')}}" class="btn btn-primary btn_xs" title="Registrar nuevo curso"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Registrar curso</a> 
                        </div>
                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">id.                  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo <br>Fiscal   </th>
                                        <th style="text-align:left;   vertical-align: middle;">Mes                  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Nombre del curso     </th>
                                        <th style="text-align:left;   vertical-align: middle;">Ponente(s)           </th>
                                        <th style="text-align:left;   vertical-align: middle;">Fecha <br>Inicio     </th>
                                        <th style="text-align:center; vertical-align: middle;">Fecha <br>Término    </th>
                                        <th style="text-align:center; vertical-align: middle;">Edo.                 </th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regcursos as $curso)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$curso->curso_id}}   </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$curso->periodo_id}} </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $curso->mes_id)
                                                {{$mes->mes_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($curso->curso_desc)}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($curso->curso_ponentes)}}</td>
                                        <td style="text-align:center; vertical-align: middle;">{{$curso->curso_finicio2}}
                                        </td>
                                        <td style="text-align:center; vertical-align: middle;">{{$curso->curso_ffin2}}
                                        </td>                                                                           
                                        @if($curso->curso_status == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        <td style="text-align:center;">
                                            <a href="{{route('editarCurso',$curso->curso_id)}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('borrarCurso',$curso->curso_id)}}" class="btn badge-danger" title="Eliminar curso" onclick="return confirm('¿Seguro que desea eliminar curso?')"><i class="fa fa-times"></i></a>
                                        </td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regcursos->appends(request()->input())->links() !!}
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