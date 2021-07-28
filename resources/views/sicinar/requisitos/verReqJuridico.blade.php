@extends('sicinar.principal')

@section('title','Ver requisitos jurídicos')

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
            <h1>Menu
                <small>2. Requisitos jurídicos - Seleccionar para editar o registrar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                
                <li><a href="#">2. Requisitos Jurídicos  </a></li>         
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <b style="background-color:darkorange;color:black;text-align:center; vertical-align: middle;">
                        *** Nota: Los requisitos de este apartado serán solicitados y registrados por única vez y se deberán actualizar cuando haya algún cambio de estos documentos. ***
                        </b>
                        <div class="box-header" style="text-align:right;">
                            {{ Form::open(['route' => 'buscarJur', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group">
                                    {{ Form::text('fper', null, ['class' => 'form-control', 'placeholder' => 'Periodo fiscal']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre OSC']) }}
                                </div>                                 
                                <div class="form-group"> 
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <a href="{{route('nuevaJur')}}" class="btn btn-primary btn_xs" title="Registrar requisitos jurídicos"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Registrar requisitos jurídicos</a>
                                </div>                                
                            {{ Form::close() }}                            
                        </div>                        

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify"> 
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Folio       </th>
                                        <th style="text-align:left;   vertical-align: middle;">OSC         </th>
                                        <th style="text-align:center; vertical-align: middle;">Acta <br>Constitutiva</th>
                                        <th style="text-align:center; vertical-align: middle;">Cve. Única<br>Inscrip. </th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($regjuridico as $juridico)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$juridico->osc_folio}}</td> 
                                        @foreach($regosc as $osc)
                                            @if($osc->osc_id == $juridico->osc_id)
                                                <td style="text-align:left; vertical-align: middle;">{{$osc->osc_id.' '.Trim($osc->osc_desc)}}
                                                </td>                                                        
                                                @break
                                            @endif
                                        @endforeach    

                                        @if(!empty($juridico->osc_d12)&&(!is_null($juridico->osc_d12)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Acta Constitutiva">
                                                <a href="/images/{{$juridico->osc_d12}}" class="btn btn-danger" title="Acta Constitutiva"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                                </a>
                                                <a href="{{route('editarJur12',$juridico->osc_id)}}" class="btn badge-warning" title="Editar Acta Constitutiva"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Acta Constitutiva"><i class="fa fa-times"></i>
                                                <a href="{{route('editarJur12',$juridico->osc_id)}}" class="btn badge-warning" title="Editar Acta Constitutiva"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif
                                        @if(!empty($juridico->osc_d13)&&(!is_null($juridico->osc_d13)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Clave Única de inscripción">
                                                <a href="/images/{{$juridico->osc_d13}}" class="btn btn-danger" title="Clave Única de inscripción"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                                </a>
                                                <a href="{{route('editarJur13',$juridico->osc_id)}}" class="btn badge-warning" title="Editar Clave Única de inscripción"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Documento de registro en el IFREM"><i class="fa fa-times"></i>
                                                <a href="{{route('editarJur13',$juridico->osc_id)}}" class="btn badge-warning" title="Editar Clave Única de inscripción"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif

                                        <td style="text-align:center; vertical-align: middle;">
                                            <a href="{{route('editarJur',$juridico->osc_id)}}" class="btn badge-warning" title="Editar requisitos jurídicos"><i class="fa fa-edit"></i>
                                            </a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarJur',$juridico->osc_folio)}}" class="btn badge-danger" title="Borrar registro" onclick="return confirm('¿Seguro que desea borrar requisitos jurídicos?')"><i class="fa fa-times"></i>
                                                </a>                                            
                                            @endif
                                        </td>
                    
                                    </tr>   
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regjuridico->appends(request()->input())->links() !!}
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
