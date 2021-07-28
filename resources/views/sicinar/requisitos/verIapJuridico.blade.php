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
            <h1>IAPS - Requisitos jurídicos
                <small> Seleccionar requisito jurídico para editar o registrar</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">Instituciones de Asistencia Privada (IAPS) </a></li>
                <li><a href="#">Requisitos Jurídicos  </a></li>         
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header" style="text-align:right;">
                            <a href="{{route('nuevaIapj')}}" class="btn btn-primary btn_xs" title="Registrar requisitos jurídicos"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Registrar requisitos jurídicos</a>
                        </div>                        
                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Id.                  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Nombre de la IAP     </th>
                                        <th style="text-align:center; vertical-align: middle;">Acta <br>Constitutiva</th>
                                        <th style="text-align:center; vertical-align: middle;">Registro<br>IFREM    </th>
                                        <th style="text-align:center; vertical-align: middle;">Situación<br>Inmueble</th>
                                        <th style="text-align:center; vertical-align: middle;">Última<br>Protocolización</th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($regjuridico as $juridico)
                                    <tr>
                                        @foreach($regiap as $iap)
                                            @if($iap->iap_id == $juridico->iap_id)
                                                <td style="text-align:left; vertical-align: middle;">{{$iap->iap_id}}</td>
                                                <td style="text-align:left; vertical-align: middle;">{{Trim($iap->iap_desc)}}
                                                </td>                                                        
                                                @break
                                            @endif
                                        @endforeach    

                                        @if(!empty($juridico->iap_d12)&&(!is_null($juridico->iap_d12)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Acta Constitutiva">
                                                <a href="/images/{{$juridico->iap_d12}}" class="btn btn-danger" title="Acta Constitutiva"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                                </a>
                                                <a href="{{route('editarIapj12',$juridico->iap_id)}}" class="btn badge-warning" title="Editar Acta Constitutiva"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Acta Constitutiva"><i class="fa fa-times"></i>
                                                <a href="{{route('editarIapj12',$juridico->iap_id)}}" class="btn badge-warning" title="Editar Acta Constitutiva"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif
                                        @if(!empty($juridico->iap_d13)&&(!is_null($juridico->iap_d13)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Documento de registro en el IFREM">
                                                <a href="/images/{{$juridico->iap_d13}}" class="btn btn-danger" title="Documento de registro en el IFREM"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                                </a>
                                                <a href="{{route('editarIapj13',$juridico->iap_id)}}" class="btn badge-warning" title="Editar documento de registro en el IFREM"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Documento de registro en el IFREM"><i class="fa fa-times"></i>
                                                <a href="{{route('editarIapj13',$juridico->iap_id)}}" class="btn badge-warning" title="Editar documento de registro en el IFREM"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif

                                        @if(!empty($juridico->iap_d14)&&(!is_null($juridico->iap_d14)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Documento comprobatorio de situación del inmueble">
                                                <a href="/images/{{$juridico->iap_d14}}" class="btn btn-danger" title="Documento comprobatorio de situación del inmueble"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                                </a>
                                                <a href="{{route('editarIapj14',$juridico->iap_id)}}" class="btn badge-warning" title="Editar documento comprobatorio de situación del inmueble"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Documento comprobatorio de situación del inmueble"><i class="fa fa-times"></i>
                                                <a href="{{route('editarIapj14',$juridico->iap_id)}}" class="btn badge-warning" title="Editar documento comprobatorio de situación del inmueble "><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif

                                        @if(!empty($juridico->iap_d15)&&(!is_null($juridico->iap_d15)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Documento de última protocolización">
                                                <a href="/images/{{$juridico->iap_d15}}" class="btn btn-danger" title="Documento de última protocolización"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                                </a>
                                                <a href="{{route('editarIapj15',$juridico->iap_id)}}" class="btn badge-warning" title="Editar documento de última protocolización"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Documento de última protocolización"><i class="fa fa-times"></i>
                                                <a href="{{route('editarIapj15',$juridico->iap_id)}}" class="btn badge-warning" title="Editar documento de última protocolización "><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif                                        
                                        <td style="text-align:center; vertical-align: middle;">
                                            <a href="{{route('editarIapj',$juridico->iap_id)}}" class="btn badge-warning" title="Editar requisitos jurídicos"><i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{route('borrarIapj',$juridico->iap_id)}}" class="btn badge-danger" title="Borrar registro" onclick="return confirm('¿Seguro que desea borrar requisitos jurídicos?')"><i class="fa fa-times"></i>
                                            </a>                                            
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