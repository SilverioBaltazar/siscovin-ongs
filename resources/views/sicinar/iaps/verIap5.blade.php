@extends('sicinar.principal')

@section('title','Ver ONGS')

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
            <h1>Directorio
                <small> Seleccionar para editar ONG</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
                <li><a href="#">ONGS </a></li>
                <li><a href="#">Directorio</a></li>               
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Id.              </th>
                                        <th style="text-align:left;   vertical-align: middle;">ONG              </th>
                                        <th style="text-align:left;   vertical-align: middle;">Domicilio Legal  </th>     
                                        <th style="text-align:center; vertical-align: middle;">Activa <br>Inact.</th> 
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regiap as $iap)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$iap->iap_id}}        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($iap->iap_desc)}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{$iap->iap_dom1}}     </td>
                                                                                

                                        @if($iap->iap_status == 'S')
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;" title="Activa"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;" title="Inactiva"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarIap5',$iap->iap_id)}}" class="btn badge-warning" title="Editar IAP"><i class="fa fa-edit"></i>
                                            </a>
                                        </td>                                                                                
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regiap->appends(request()->input())->links() !!}
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