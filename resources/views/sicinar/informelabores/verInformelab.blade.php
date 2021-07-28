@extends('sicinar.principal')

@section('title','Ver informe de labores de las actividades del programa de trabajo')

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
            <h1>3. Requisitos asistenciales
                <small> Seleccionar para editar o registrar informe de labores </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">3. Requisitos asistenciales </a></li>   
                <li><a href="#">3.3 Informe de labores  </a></li>               
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <table id="tabla1" class="table table-hover table-striped">
                            @foreach($regprogtrab as $progtrab)
                            <tr>
                                <td style="text-align:left; vertical-align: middle;">   
                                </td>                                                                 
                                <td style="text-align:left; vertical-align: middle;">   
                                </td>
                                <td style="text-align:center; vertical-align: middle;"> 
                                </td>
                                <td style="text-align:right; vertical-align: middle;">   
                                    <a href="{{route('verInformes')}}" role="button" id="cancelar" class="btn btn-success"><small>Regresar a programa trabajo-informe de labores</small>
                                    </a>
                                </td>                                     
                            </tr>                                                   
                            <tr>                            
                                <td style="color:green;text-align:left; vertical-align: middle;">   
                                    <input type="hidden" id="folio" name="folio" value="{{$progtrab->folio}}">  
                                    <label>Folio: </label>
                                    <label style="color:green;text-align:left; vertical-align: middle;">{{$progtrab->folio}}</label>
                                </td>                                                                 
                                <td>   
                                    <input type="hidden" id="periodo_id" name="periodo_id" value="{{$progtrab->periodo_id}}">  
                                    <label>Periodo fiscal: </label>
                                    <label style="color:green;text-align:left; vertical-align: middle;">{{$progtrab->periodo_id}}</label>
                                </td>
                                <td> 
                                    <input type="hidden" id="osc_id" name="osc_id" value="{{$progtrab->osc_id}}">  
                                    <label>OSC: </label>
                                    @foreach($regosc as $osc)
                                        @if($osc->osc_id == $progtrab->osc_id)
                                            <label style="color:green;text-align:left; vertical-align: middle;">{{$osc->osc_desc}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                                <td>   
                                    <input type="hidden" id="folio" name="folio" value="{{$progtrab->folio}}">  
                                    <label>Responsable: </label>
                                    <label style="color:green;text-align:left; vertical-align: middle;">{{$progtrab->responsable}}</label>
                                </td>                                     
                            </tr>      
                            @endforeach     
                        </table>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">#               </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Programa        </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Actividad       </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Objetivo        </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Unidad<br>Medida</th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Ene             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Feb             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Mar             </th> 
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Abr             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">May             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Jun             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Jul             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Ago             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Sep             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Oct             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Nov             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Dic             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Edo.            </th>
                                        <th style="text-align:center; vertical-align: middle;font-size:10px;width:100px;">Acciones</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regprogdtrab as $progdtrab)
                                    <tr>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:9px;">{{$progdtrab->partida}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:9px;">{{trim($progdtrab->programa_desc)}}
                                        </td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:9px;">{{Trim($progdtrab->actividad_desc)}}
                                        </td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:9px;">{{Trim($progdtrab->objetivo_desc)}}    
                                        </td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:9px;">   
                                        @foreach($regumedida as $umedida)
                                            @if($umedida->umedida_id == $progdtrab->umedida_id)
                                                {{$umedida->umedida_desc}}
                                                @break                                        
                                            @endif
                                        @endforeach
                                        </td>                                                                            
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_01}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_02}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_03}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_04}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_05}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_06}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_07}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_08}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_09}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_10}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_11}}</td>
                                        <td style="color:green;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesp_12}}</td>

                                        @if($progdtrab->dstatus_1 == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarInformelab',array($progdtrab->folio,$progdtrab->partida) )}}" class="btn badge-warning" title="Editar actividad del programa de trabajo"><i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:9px;"></td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:9px;"></td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:9px;"></td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:9px;"></td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:9px;"></td>                                                                            
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_01}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_02}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_03}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_04}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_05}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_06}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_07}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_08}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_09}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_10}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_11}}</td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:10px;">{{$progdtrab->mesc_12}}</td>

                                        <td style="color:darkgreen;text-align:center; vertical-align: middle;"></td>  
                                        <td style="text-align:center;"></td>
                                    </tr>                                    
                                    @endforeach
                                </tbody>
                            </table>

                            <table id="tabla1" class="table table-hover table-striped">
                                <tr>
                                @foreach($regprogtrab as $progtrab)
                                    <td style="text-align:left; vertical-align: middle;">
                                        <label>Elaboró: </label>{{$progtrab->elaboro}}   
                                    </td>
                                    <td style="text-align:right; vertical-align: middle;">   
                                        <label>Autorizo: </label>{{$progtrab->autorizo}}
                                    </td>                                     
                                </tr>                                 
                                @endforeach
                            </table>

                            {!! $regprogdtrab->appends(request()->input())->links() !!}
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

