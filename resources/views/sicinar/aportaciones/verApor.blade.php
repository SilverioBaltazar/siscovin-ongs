@extends('sicinar.principal')

@section('title','Ver Aportaciones monetarias')

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
            <h1>Aportaciones monetarias
                <small> Seleccionar alguna para editar o registrar nueva aportación monetaria</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">IAPS </a></li>
                <li><a href="#">Aportación monetaria   </a></li>         
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header" style="text-align:right;">
                            Busqueda  
                            {{ Form::open(['route' => 'buscarApor', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                <div class="form-group">
                                    {{ Form::text('per', null, ['class' => 'form-control', 'placeholder' => 'Periodo','maxlength' => '10']) }}
                                    <!--<option value=""> --Seleccionar periodo-- </option> -->
                                    <select class="form-control m-bot15" name="per" class="form-control">
                                        <option value=""> </option> 
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{trim($periodo->periodo_desc)}}</option>
                                        @endforeach   
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    {{ Form::text('iapp', null, ['class' => 'form-control', 'placeholder' => 'IAP','maxlength' => '20']) }}
                                    <select class="form-control m-bot15" name="iapp" class="form-control">
                                        <option value=""> </option>
                                        @foreach($regiap as $iap)
                                            <option value="{{$iap->iap_id}}">{{substr($iap->iap_desc,1,20)}}</option>
                                        @endforeach   
                                    </select>
                                </div>
                                <!--
                                <div class="form-group">
                                    {{ Form::text('bio', null, ['class' => 'form-control', 'placeholder' => 'Concepto']) }}
                                </div>
                                -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <a href="{{route('nuevaApor')}}" class="btn btn-primary btn_xs" title="Registrar nueva aportación"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Registrar aportación</a> 
                                </div>                                
                            {{ Form::close() }}
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Folio   </th>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo <br>Fiscal </th>
                                        <th style="text-align:left;   vertical-align: middle;">IAP                </th>
                                        <th style="text-align:left;   vertical-align: middle;">Mes                </th>     
                                        <th style="text-align:left;   vertical-align: middle;">Concepto de la aportación</th>
                                        <th style="text-align:left;   vertical-align: middle;">Monto $            </th>
                                        <th style="text-align:center; vertical-align: middle;">Institución bancaria</th>
                                        <th style="text-align:center; vertical-align: middle;">No. cheque <br>No. referen.</th>
                                        <th style="text-align:center; vertical-align: middle;">Comp.<br>deposito   </th>
                                        <th style="text-align:center; vertical-align: middle;">Fecha registro      </th>
                                        <th style="text-align:center; vertical-align: middle;">Edo.                </th> 
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regapor as $apor)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$apor->apor_folio}}   </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$apor->periodo_id}}   </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                        @foreach($regiap as $iap)
                                            @if($iap->iap_id == $apor->iap_id)
                                                {{$iap->iap_desc}}
                                                @break
                                            @endif
                                        @endforeach 
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $apor->mes_id)
                                                {{$mes->mes_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($apor->apor_concepto)}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{$apor->apor_monto}}   </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                        @foreach($regbancos as $banco)
                                            @if($banco->banco_id == $apor->banco_id)
                                                {{$banco->banco_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$apor->apor_nocheque}}</td>
                                        @if(!empty($apor->apor_compdepo)&&(!is_null($apor->apor_compdepo)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Comprobante de depósito">
                                                <a href="/images/{{$apor->apor_compdepo}}" class="btn btn-danger" title="Comprobante de depósito"><i class="fa fa-file-pdf-o"></i>PDF</a>
                                                <a href="{{route('editarApor1',$apor->apor_folio)}}" class="btn badge-warning" title="Editar Comprobante de depósito"><i class="fa fa-edit"></i></a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Comprobante de depósito"><i class="fa fa-times"></i>
                                            </td>   
                                        @endif   
                                        
                                        <td style="text-align:center; vertical-align: middle;">{{date("d/m/Y", strtotime($apor->fecreg))}}
                                        </td>                                                                              
                                        @if($apor->apor_status == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        <td style="text-align:center;">
                                            <a href="{{route('editarApor',$apor->apor_folio)}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('borrarApor',$apor->apor_folio)}}" class="btn badge-danger" title="Cancelar transacción" onclick="return confirm('¿Seguro que desea cancelar la aportación monetaria?')"><i class="fa fa-times"></i></a>
                                        </td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regapor->appends(request()->input())->links() !!}
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