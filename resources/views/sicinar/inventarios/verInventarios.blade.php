@extends('sicinar.principal')

@section('title','Ver Activos fijos')

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
            <h1>4.1 Activos fijos
                <small> Seleccionar alguno para editar o registrar nuevo activo fijo</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">4. Requisitos contables </a></li>
                <li><a href="#">4.1 Activos fijos   </a></li>         
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header" style="text-align:right;">
                              
                            {{ Form::open(['route' => 'buscarInventario', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group">
                                    {{ Form::text('fper', null, ['class' => 'form-control', 'placeholder' => 'Periodo fiscal']) }}
                                </div> 
                                <div class="form-group">
                                    {{ Form::text('nameiap', null, ['class' => 'form-control', 'placeholder' => 'Nombre OSC']) }}
                                </div>                                          
                                <div class="form-group"> 
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <a href="{{route('nuevoInventario')}}" class="btn btn-primary btn_xs" title="Registrar nuevo activo fijo"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Registrar activo fijo</a> 
                                </div>                                
                            {{ Form::close() }}                            
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo <br>Fiscal   </th>
                                        <th style="text-align:left;   vertical-align: middle;">OSC                  </th>
                                        <th style="text-align:left;   vertical-align: middle;">id.                  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Código               </th>
                                        <th style="text-align:left;   vertical-align: middle;">Activo fijo          </th>
                                        <th style="text-align:left;   vertical-align: middle;">Factura<br>recibo    </th>
                                        <th style="text-align:left;   vertical-align: middle;">Fecha <br>Adquisición</th>
                                        <th style="text-align:center; vertical-align: middle;">Condición            </th>
                                        <th style="text-align:center; vertical-align: middle;">Valor $              </th>
                                        <th style="text-align:center; vertical-align: middle;">Edo.                 </th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reginventario as $activo)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;font-size:10px;">{{$activo->periodo_id}}   </td>
                                        <td style="font-size:10px; text-align:left; vertical-align: middle;">
                                            @foreach($regosc as $osc)
                                                @if($osc->osc_id == $activo->osc_id)
                                                    {{$activo->osc_id.' '.$osc->osc_desc}}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>   
                                        <td style="text-align:left; vertical-align: middle;font-size:10px;">{{$activo->id}}           </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:10px;">{{$activo->activo_id}}    </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:10px;">{{$activo->activo_desc}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:10px;">{{$activo->inventario_doc}}</td>
                                        <td style="text-align:left; vertical-align: middle;font-size:10px;">{{$activo->inventario_fecadq2}}</td>
                                        <td style="text-align:left; vertical-align: middle;font-size:10px;">
                                        @foreach($regcondicion as $condicion)
                                            @if($condicion->condicion_id == $activo->condicion_id)
                                                {{$condicion->condicion_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                        </td>
                                        <td style="text-align:center; vertical-align: middle;font-size:10px;">{{number_format($activo->activo_valor,2)}}</td>
                                        @if($activo->inventario_status == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;font-size:10px;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;font-size:10px;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        <td style="text-align:center;">
                                            <a href="{{route('editarInventario',$activo->id)}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarInventario',$activo->id)}}" class="btn badge-danger" title="Eliminar activo fijo" onclick="return confirm('¿Seguro que desea eliminar el activo fijo?')"><i class="fa fa-times"></i></a>
                                            @endif
                                        </td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $reginventario->appends(request()->input())->links() !!}
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