@extends('sicinar.principal')

@section('title','Ver artículos de la cedula de detección de necesidades')

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
            <h1>Requisitos asistenciales
                <small> Seleccionar para editar o registrar artículo en cédula </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">Requisitos asistenciales </a></li>   
                <li><a href="#">Cédula (artículos)  </a></li>               
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <table id="tabla1" class="table table-hover table-striped">
                            @foreach($regcedula as $cedula)
                            <tr>
                                <td style="text-align:left; vertical-align: middle;">   
                                </td>                                                                 
                                <td style="text-align:left; vertical-align: middle;">   
                                </td>
                                <td style="text-align:center; vertical-align: middle;"> 
                                </td>
                                <td style="text-align:right; vertical-align: middle;">   
                                    <a href="{{route('verCedula')}}" role="button" id="cancelar" class="btn btn-success"><small>Regresar a cédulas</small>
                                    </a>
                                    <a href="{{route('nuevaCedulaarti',array($cedula->periodo_id,$cedula->cedula_folio))}}" class="btn btn-primary btn_xs" title="Nuevo artículo en cédula de detección de necesidades"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span><small>Cédula - Lista de artículos</small>
                                    </a>
                                </td>                                     
                            </tr>                                                   
                            <tr>                            
                                <td style="text-align:left; vertical-align: middle;">   
                                    <input type="hidden" id="cedula_folio" name="cedula_folio" value="{{$cedula->folio}}">  
                                    <label>Folio: </label>{{$cedula->cedula_folio}}
                                </td>                                                                 
                                <td style="text-align:left; vertical-align: middle;">   
                                    <input type="hidden" id="periodo_id" name="periodo_id" value="{{$cedula->periodo_id}}">  
                                    <label>Periodo fiscal: </label>{{$cedula->periodo_id}}                                        
                                </td>
                                <td style="text-align:center; vertical-align: middle;"> 
                                    <input type="hidden" id="iap_id" name="iap_id" value="{{$cedula->iap_id}}">  
                                    <label>IAP: </label>
                                    @foreach($regiap as $iap)
                                        @if($iap->iap_id == $cedula->iap_id)
                                            {{$iap->iap_desc}}
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                                <td style="text-align:right; vertical-align: middle;">   
                                    <label>Responsable: </label>{{$cedula->sp_nomb}}
                                </td>                                     
                            </tr>      
                            @endforeach     
                        </table>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">#                </th>
                                        <th style="text-align:left;   vertical-align: middle;">Id.              </th>
                                        <th style="text-align:left;   vertical-align: middle;">Articulo         </th>
                                        
                                        <th style="text-align:left;   vertical-align: middle;">Cantidad         </th>
                                        <th style="text-align:left;   vertical-align: middle;">Tipo <br>Artículo</th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regcedulaarti as $arti)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$arti->cedula_partida}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{$arti->articulo_id}}   </td>
                                        <td style="text-align:left; vertical-align: middle;">  
                                        @foreach($regarticulos as $articulo)
                                            @if($articulo->articulo_id == $arti->articulo_id)
                                                {{$articulo->articulo_desc}}
                                                @break                                        
                                            @endif
                                        @endforeach
                                        </td>                   
                                        <td style="text-align:center; vertical-align: middle;">{{number_format($arti->articulo_cantidad,0)}}</td>
                                        <td style="text-align:left; vertical-align: middle;color: orange;font-size:11px;">   
                                        @foreach($regarticulos as $articulo)
                                            @if($articulo->articulo_id == $arti->articulo_id)
                                                {{$articulo->tipo_desc}}
                                                @break                                        
                                            @endif
                                        @endforeach
                                        </td>                                                                            
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarCedulaarti',array($arti->periodo_id,$arti->cedula_folio,$arti->articulo_id) )}}" class="btn badge-warning" title="Editar artículo de la cédula"><i class="fa fa-edit"></i>
                                            </a>
                                            <!--<a href="{{route('borrarCedulaarti',array($arti->cedula_folio,$arti->cedula_partida) )}}" class="btn badge-danger" title="Borrar artículo de la cédula de detección de necesidades" onclick="return confirm('¿Seguro que desea borrar artículo de la cédula de detección de necesidades?')"><i class="fa fa-times"></i>
                                            </a>
                                            -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {!! $regcedulaarti->appends(request()->input())->links() !!}
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

