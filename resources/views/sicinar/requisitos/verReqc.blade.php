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
                <small>4. Requisitos contables</small>
                <small>4.2 Otros requisitos - Seleccionar para editar o registrar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">4. Requisitos contables    </a></li>         
                <li><a href="#">4.2 Otros requisitos       </a></li>            
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <b style="background-color:darkorange;color:black;text-align:center; vertical-align: middle;">
                        *** Nota: Los requisitos de este apartado serán solicitados y registrados anualmente, esto es cada ejercicio fiscal. ***
                        </b>
                        <div class="box-header" style="text-align:right;">
                            {{ Form::open(['route' => 'buscarReqc', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
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
                                    <a href="{{route('nuevoReqc')}}" class="btn btn-primary btn_xs" title="Registrar requisitos contables"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Registrar requisitos contables</a>
                                </div>                                
                            {{ Form::close() }}                            
                        </div>                        

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify"> 
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:11px;">Per.             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:11px;">Fol.             </th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:11px;">OSC              </th>
                                        <th style="text-align:center; vertical-align: middle;font-size:11px;">Presup.<br>Anual </th>
                                        <th style="text-align:center; vertical-align: middle;font-size:11px;">Constan.<br>Recibir<br>Donativos</th>
                                        <th style="text-align:center; vertical-align: middle;font-size:11px;">Declar.<br>Anual </th>
                                        <th style="text-align:center; vertical-align: middle;font-size:11px; width:100px;">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($regcontable as $contable)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;font-size:11px;">{{$contable->periodo_id}}</td>
                                        <td style="text-align:left; vertical-align: middle;font-size:11px;">{{$contable->osc_folio}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:11px;">
                                            @foreach($regosc as $osc)
                                                @if($osc->osc_id == $contable->osc_id)
                                                    {{$osc->osc_id.' '.Trim($osc->osc_desc)}} 
                                                    @break
                                                @endif
                                            @endforeach    
                                        </td>  

                                        @if(!empty($contable->osc_d1)&&(!is_null($contable->osc_d1)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Presupuesto anual">
                                                <a href="/images/{{$contable->osc_d1}}" class="btn btn-danger" title="Documento de Presupuesto anual"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                                </a>
                                                <a href="{{route('editarReqc1',$contable->osc_id)}}" class="btn badge-warning" title="Editar documento de Presupuesto anual"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Documento de Presupuesto anual"><i class="fa fa-times"></i>
                                                <a href="{{route('editarReqc1',$contable->osc_id)}}" class="btn badge-warning" title="Editar documento de Presupuesto anual"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif                                        


                                        @if(!empty($contable->osc_d2)&&(!is_null($contable->osc_d2)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;font-size:11px;" title="Constancia para recibir donativos">
                                                <a href="/images/{{$contable->osc_d2}}" class="btn btn-danger" title="Contancia para recibir donativos"><i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                <a href="{{route('editarReqc2',$contable->osc_folio)}}" class="btn badge-warning" title="Editar Constancia para recibir donativos"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;font-size:11px;" title="Contancia para recibir donativos"><i class="fa fa-times"></i>
                                                <a href="{{route('editarReqc2',$contable->osc_folio)}}" class="btn badge-warning" title="Editar Constancia para recibir donativos"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif

                                        @if(!empty($contable->osc_d3)&&(!is_null($contable->osc_d3)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;font-size:11px;" title="Declaración anual">
                                                <a href="/images/{{$contable->osc_d3}}" class="btn btn-danger" title="Declaración anual"><i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                <a href="{{route('editarReqc3',$contable->osc_folio)}}" class="btn badge-warning" title="Editar Declaración anual"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;font-size:11px;" title="Declaración anual"><i class="fa fa-times"></i>
                                                <a href="{{route('editarReqc3',$contable->osc_folio)}}" class="btn badge-warning" title="Editar Declaración anual"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif

                                        <td style="text-align:center; vertical-align: middle;font-size:11px;">
                                            <a href="{{route('editarReqc',$contable->osc_folio)}}" class="btn badge-warning" title="Editar requisitos admon."><i class="fa fa-edit"></i>
                                            </a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarReqc',$contable->osc_folio)}}" class="btn badge-danger" title="Borrar registro" onclick="return confirm('¿Seguro que desea borrar requisitos admon.?')"><i class="fa fa-times"></i>
                                                </a>                                             
                                            @endif 
                                        </td>
                    
                                    </tr>   
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regcontable->appends(request()->input())->links() !!}
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
